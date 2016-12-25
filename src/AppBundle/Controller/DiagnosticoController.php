<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Diagnostico;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Diagnostico controller.
 *
 * @Route("/diagnostico")
 * @Security("has_role('ROLE_ADMIN')")
 */
class DiagnosticoController extends Controller
{
    /**
     * Lists all Diagnostico entities.
     *
     * @Route("/", name="diagnostico_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityRepository $diagnosticosRepo */
        $diagnosticosRepo = $this->getDoctrine()->getRepository('AppBundle:Diagnostico');
        $diagnosticosQB = $diagnosticosRepo->createQueryBuilder('d')->orderBy('d.diagnostico');
        $diagnosticos = $this->get('knp_paginator')->paginate(
            $diagnosticosQB,
            $request->query->getInt('page', 1),
            25
        );

        $deleteForms = [];
        /** @var Diagnostico $diagnostico */
        foreach ($diagnosticos as $diagnostico) {
            $deleteForms[$diagnostico->getId()] = $this->createDeleteForm($diagnostico)->createView();
        }

        return $this->render('diagnostico/index.html.twig', [
            'diagnosticos' => $diagnosticos,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Diagnostico entity.
     *
     * @Route("/agregar", name="diagnostico_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $diagnostico = new Diagnostico();
        $form = $this->createForm('AppBundle\Form\DiagnosticoType', $diagnostico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diagnostico);
            $em->flush();

            return $this->redirectToRoute('diagnostico_index');
        }

        return $this->render('diagnostico/new.html.twig', [
            'diagnostico' => $diagnostico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Diagnostico entity.
     *
     * @Route("/{id}/editar", name="diagnostico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Diagnostico $diagnostico)
    {
        $editForm = $this->createForm('AppBundle\Form\DiagnosticoType', $diagnostico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diagnostico);
            $em->flush();

            return $this->redirectToRoute('diagnostico_index');
        }

        return $this->render('diagnostico/edit.html.twig', [
            'diagnostico' => $diagnostico,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Diagnostico entity.
     *
     * @Route("/{id}", name="diagnostico_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Diagnostico $diagnostico)
    {
        $form = $this->createDeleteForm($diagnostico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $em->remove($diagnostico);
            try {
                $em->flush();
                $message = 'El diagnóstico ha sido eliminado satisfactoriamente';
                $flashBag->add('success', $message);
            } catch (\Exception $e) {
                $message = 'Lo sentimos, el diagnóstico no pudo ser eliminado';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('diagnostico_index');
    }

    /**
     * Creates a form to delete a Diagnostico entity.
     *
     * @param Diagnostico $diagnostico The Diagnostico entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Diagnostico $diagnostico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diagnostico_delete', ['id' => $diagnostico->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
