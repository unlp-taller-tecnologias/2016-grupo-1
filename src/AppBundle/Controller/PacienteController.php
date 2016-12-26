<?php namespace AppBundle\Controller;

use AppBundle\Entity\Paciente;
use AppBundle\Repository\PacienteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Paciente controller.
 *
 * @Route("/paciente")
 * @Security("has_role('ROLE_USER')")
 */
class PacienteController extends Controller {
    /**
     * Lists all Paciente entities.
     *
     * @Route("/", name="paciente_index")
     * @Method("GET")
     */
    public function indexAction(Request $request) {
        $searchForm = $this->createForm('AppBundle\Form\PacienteSearchType');
        $searchForm->handleRequest($request);

        /** @var PacienteRepository $pacientesRepo */
        $pacientesRepo = $this->getDoctrine()->getRepository('AppBundle:Paciente');
        if ($searchForm->isSubmitted()) {
            $pacientesQB = $pacientesRepo->findAllByMultiParametros($searchForm->getData());
        } else {
            $pacientesQB = $pacientesRepo->findAllServicio();
        }

        $pacientes = $this->get('knp_paginator')->paginate(
                $pacientesQB, $request->query->getInt('page', 1), 25
        );

        $deleteForms = [];
        /** @var Paciente $paciente */
        foreach ($pacientes as $paciente) {
            $deleteForms[$paciente->getId()] = $this->createDeleteForm($paciente)->createView();
        }

        return $this->render('paciente/index.html.twig', [
                    'pacientes' => $pacientes,
                    'delete_forms' => $deleteForms,
                    'search_form' => $searchForm->createView(),
                    'busquedaRealizada' => $searchForm->isSubmitted()
        ]);
    }

    /**
     * Creates a new Paciente entity.
     *
     * @Route("/agregar", name="paciente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteType', $paciente, ['entity_manager' => $this->getDoctrine()->getManager()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', ['id' => $paciente->getId()]);
        }

        $sentdata = $request->request->get("paciente");
        if ($sentdata !== null) {
            $loc = $sentdata["localidad"];
            $localidad = $this->getDoctrine()->getManager()->getRepository("AppBundle:Localidad")->find($loc);
        } else {
            $localidad = "";
        }

        $partidos = $this->getDoctrine()->getRepository('AppBundle:Partido')->findAll();
        return $this->render('paciente/new.html.twig', [
                    'paciente' => $paciente,
                    'form' => $form->createView(),
                    'partidos' => $partidos,
                    'localidad_text' => $localidad
        ]);
    }

    /**
     * Finds and displays a Paciente entity.
     *
     * @Route("/{id}", name="paciente_show")
     * @Method("GET")
     */
    public function showAction(Paciente $paciente) {
        $deleteForm = $this->createDeleteForm($paciente);

        return $this->render('paciente/show.html.twig', [
                    'paciente' => $paciente,
                    'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Paciente entity.
     *
     * @Route("/{id}/editar", name="paciente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paciente $paciente) {
        $editForm = $this->createForm('AppBundle\Form\PacienteType', $paciente, ['entity_manager' => $this->getDoctrine()->getManager()]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', ['id' => $paciente->getId()]);
        }

        $sentdata = $request->request->get("paciente");
        if ($sentdata !== null) {
            $loc = $sentdata["localidad"];
            $localidad = $this->getDoctrine()->getManager()->getRepository("AppBundle:Localidad")->find($loc);
        } else {
            if ($paciente->getLocalidad() !== null) {
                $localidad = $paciente->getLocalidad();
            }
        }

        $partidos = $this->getDoctrine()->getRepository('AppBundle:Partido')->findAll();

        return $this->render('paciente/edit.html.twig', [
                    'paciente' => $paciente,
                    'edit_form' => $editForm->createView(),
                    'partidos' => $partidos,
                    'localidad_text' => $localidad
        ]);
    }

    /**
     * Deletes a Paciente entity.
     *
     * @Route("/{id}", name="paciente_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Paciente $paciente) {
        $form = $this->createDeleteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $em->remove($paciente);
            try {
                $em->flush();
                $message = 'El paciente ha sido eliminado satisfactoriamente';
                $flashBag->add('success', $message);
            } catch (\Exception $e) {
                $message = 'Lo sentimos, el paciente no pudo ser eliminado';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('paciente_index');
    }

    /**
     * Creates a form to delete a Paciente entity.
     *
     * @param Paciente $paciente The Paciente entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paciente $paciente) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('paciente_delete', ['id' => $paciente->getId()]))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
