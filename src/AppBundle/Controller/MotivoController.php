<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Motivo;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Motivo controller.
 *
 * @Route("/motivo")
 * @Security("has_role('ROLE_ADMIN')")
 */
class MotivoController extends Controller
{
    /**
     * Lists all Motivo entities.
     *
     * @Route("/", name="motivo_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityRepository $motivosRepo */
        $motivosRepo = $this->getDoctrine()->getRepository('AppBundle:Motivo');
        $motivosQB = $motivosRepo->createQueryBuilder('m')->orderBy('m.motivo');
        $motivos = $this->get('knp_paginator')->paginate(
            $motivosQB,
            $request->query->getInt('page', 1),
            25
        );

        $deleteForms = [];
        /** @var Motivo $motivo */
        foreach ($motivos as $motivo) {
            $deleteForms[$motivo->getId()] = $this->createDeleteForm($motivo)->createView();
        }

        return $this->render('motivo/index.html.twig', [
            'motivos' => $motivos,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Motivo entity.
     *
     * @Route("/agregar", name="motivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $motivo = new Motivo();
        $form = $this->createForm('AppBundle\Form\MotivoType', $motivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motivo);
            $em->flush();

            return $this->redirectToRoute('motivo_index');
        }

        return $this->render('motivo/new.html.twig', [
            'motivo' => $motivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Motivo entity.
     *
     * @Route("/{id}/editar", name="motivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Motivo $motivo)
    {
        $editForm = $this->createForm('AppBundle\Form\MotivoType', $motivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motivo);
            $em->flush();

            return $this->redirectToRoute('motivo_index');
        }

        return $this->render('motivo/edit.html.twig', [
            'motivo' => $motivo,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Motivo entity.
     *
     * @Route("/{id}", name="motivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Motivo $motivo)
    {
        $form = $this->createDeleteForm($motivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $em->remove($motivo);
            try {
                $em->flush();
                $message = 'El motivo de consulta ha sido eliminado satisfactoriamente';
                $flashBag->add('success', $message);
            } catch (\Exception $e) {
                $message = 'Lo sentimos, el motivo de consulta no pudo ser eliminado';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('motivo_index');
    }

    /**
     * Creates a form to delete a Motivo entity.
     *
     * @param Motivo $motivo The Motivo entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Motivo $motivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('motivo_delete', ['id' => $motivo->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
