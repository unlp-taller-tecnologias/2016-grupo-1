<?php namespace AppBundle\Controller;

use AppBundle\Entity\Paciente;
use AppBundle\Entity\Visita;
use AppBundle\Repository\VisitaRepository;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Visita controller.
 *
 * @Security("has_role('ROLE_MEDICO')")
 */
class VisitaController extends Controller {
    /**
     * Muestra la historia clínica de un paciente.
     *
     * @Route("/paciente/{id}/historia-clinica", name="paciente_historia-clinica")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request, Paciente $paciente) {
        /** @var VisitaRepository $visitasRepo */
        $visitasRepo = $this->getDoctrine()->getRepository('AppBundle:Visita');
        $visitasQB = $visitasRepo->findByPaciente($paciente);
        $visitas = $this->get('knp_paginator')->paginate(
                $visitasQB, $request->query->getInt('page', 1), 25
        );

        $deleteForms = [];
        /** @var Visita $visita */
        foreach ($visitas as $visita) {
            $deleteForms[$visita->getId()] = $this->createDeleteForm($visita)->createView();
        }

        return $this->render('visita/index.html.twig', [
                    'visitas' => $visitas,
                    'paciente' => $paciente,
                    'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Registra la visita de un paciente.
     *
     * @Route("/paciente/{id}/registrar-visita", name="paciente_registrar-visita")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Paciente $paciente) {
        $visita = new Visita($paciente, $this->getUser());
        $form = $this->createForm('AppBundle\Form\VisitaType', $visita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visita);
            if ($paciente->getMedico() === null) {
                $paciente->setMedico($visita->getMedico());
            }
            $em->flush();

            return $this->redirectToRoute('paciente_historia-clinica', ['id' => $paciente->getId()]);
        }

        return $this->render('visita/new.html.twig', [
                    'visita' => $visita,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * Genera el reporte de cantidad de visitas
     *
     * @Route("/visita/reporte", name="visita_reporte")
     * @Method("GET")
     */
    public function reporte(Request $request) {
        $form = $this->createForm('AppBundle\Form\ReporteType');
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return $this->render('visita/reporte.html.twig', ['form' => $form->createView()]);
        }

        return $this->reporteChart($request, $form);
    }

    private function reporteChart(Request $request, Form $form) {
        $em = $this->getDoctrine()->getManager();

        $formData = $form->getData();
        $desde = '01/' . $formData['desde']; // Añadir día inicial
        $hasta = '31/' . $formData['hasta']; // Añadir día límite
        $desde = implode('/', array_reverse(explode('/', $desde))); // Invertir formato
        $hasta = implode('/', array_reverse(explode('/', $hasta))); // Invertir formato
        $partido = $formData['partido'];

        /** @var VisitaRepository $visitasRepo */
        $visitasRepo = $this->getDoctrine()->getRepository('AppBundle:Visita');
        if ($partido !== null) {
            $partido = $em->find('AppBundle:Partido', $partido);
            $title = 'Pacientes atendidos de ' . $partido;
            $visitas = $visitasRepo->cantXPartido($desde, $hasta, $partido);
        } else {
            $title = 'Pacientes atendidos por partido';
            $visitas = $visitasRepo->cantXPartido($desde, $hasta);
        }

        $series = [];
        foreach ($visitas as $visita) {
            $series[] = [
                'name' => $visita['lugar'],
                'data' => [(int) $visita['cant']],
            ];
        }

        $ob = new Highchart();
        $ob->chart->type('column');
        $ob->chart->renderTo('grafico');
        $ob->title->text($title);
        $ob->xAxis->title(['text' => 'Período']);
        $ob->plotOptions->series(
                array(
                    'dataLabels' => array(
                        'enabled' => true)
                )
        );
        $ob->yAxis
                ->title(['text' => 'Pacientes (cantidad)'])
                ->allowDecimals(false)
        ;

        $ob->xAxis->categories([$formData['desde'] . ' - ' . $formData['hasta']]);

        $ob->series($series);

        return $this->render('visita/reporte.html.twig', [
                    'form' => $form->createView(),
                    'chart' => $ob,
        ]);
    }

    /**
     * Muestra una visita en particular de un paciente.
     *
     * @Route("/visita/{id}", name="visita_show")
     * @Method("GET")
     */
    public function showAction(Visita $visita) {
        $deleteForm = $this->createDeleteForm($visita);

        return $this->render('visita/show.html.twig', [
                    'visita' => $visita,
                    'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Visita entity.
     *
     * @Route("/visita/{id}/editar", name="visita_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Visita $visita) {
        if ($this->getUser() != $visita->getMedico()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $message = 'La visita sólo puede ser modificada por el médico que la registró.';
            $flashBag->add('danger', $message);

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $editForm = $this->createForm('AppBundle\Form\VisitaType', $visita);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visita);
            $em->flush();

            return $this->redirectToRoute('visita_show', ['id' => $visita->getId()]);
        }

        return $this->render('visita/edit.html.twig', [
                    'visita' => $visita,
                    'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Visita entity.
     *
     * @Route("/visita/{id}", name="visita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Visita $visita) {
        if ($this->getUser() != $visita->getMedico()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $message = 'La visita sólo puede ser eliminada por el médico que la registró.';
            $flashBag->add('danger', $message);

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $form = $this->createDeleteForm($visita);
        $form->handleRequest($request);

        $pacienteID = $visita->getPaciente()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $em->remove($visita);
            try {
                $em->flush();
                $message = 'La visita ha sido eliminada satisfactoriamente';
                $flashBag->add('success', $message);
            } catch (\Exception $e) {
                $message = 'Lo sentimos, la visita no pudo ser eliminada';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('paciente_historia-clinica', ['id' => $pacienteID]);
    }

    public function cantXPartido($desdeQuery, $hastaQuery) {
        
    }

    /**
     * Genera el PDF con todas las visitas del paciente
     * 
     * @Route("/paciente/{id}/historia-clinica/imprimir", name="historia_print")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function printAction(Paciente $paciente) {
        $img_file = $this->get('kernel')->getRootDir() . '/../web/img/logos/logo-color-sm.png';
        $img_data = base64_encode(file_get_contents($img_file));
        $img = 'data:' . mime_content_type($img_file) . ';base64,' . $img_data;

        $html = $this->renderView('visita/print.html.twig', [
            'paciente' => $paciente,
            'logo_data' => $img
        ]);
        $pdf = $this->get("knp_snappy.pdf");

        return new Response(
                $pdf->getOutputFromHtml($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="HC_' . $paciente->getId() . '.pdf"',
                ]
        );
    }

    /**
     * Creates a form to delete a Visita entity.
     *
     * @param Visita $visita The Visita entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visita $visita) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('visita_delete', ['id' => $visita->getId()]))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
