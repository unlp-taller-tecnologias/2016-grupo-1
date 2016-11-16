<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Motivo;
use AppBundle\Form\MotivoType;

/**
 * Motivo controller.
 *
 * @Route("/motivo")
 */
class MotivoController extends Controller
{
    /**
     * Lists all Motivo entities.
     *
     * @Route("/", name="motivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $motivos = $em->getRepository('AppBundle:Motivo')->findAll();

        $deleteForms = [];
        /** @var Motivo $motivo */
        foreach ($motivos as $motivo) {
            $deleteForms[$motivo->getId()] = $this->createDeleteForm($motivo)->createView();
        }

        return $this->render('motivo/index.html.twig', array(
            'motivos' => $motivos,
            'delete_forms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Motivo entity.
     *
     * @Route("/new", name="motivo_new")
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

        return $this->render('motivo/new.html.twig', array(
            'motivo' => $motivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Motivo entity.
     *
     * @Route("/{id}", name="motivo_show")
     * @Method("GET")
     */
    public function showAction(Motivo $motivo)
    {
        $deleteForm = $this->createDeleteForm($motivo);

        return $this->render('motivo/show.html.twig', array(
            'motivo' => $motivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Motivo entity.
     *
     * @Route("/{id}/edit", name="motivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Motivo $motivo)
    {
        $deleteForm = $this->createDeleteForm($motivo);
        $editForm = $this->createForm('AppBundle\Form\MotivoType', $motivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motivo);
            $em->flush();

            return $this->redirectToRoute('motivo_edit', array('id' => $motivo->getId()));
        }

        return $this->render('motivo/edit.html.twig', array(
            'motivo' => $motivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
            $em = $this->getDoctrine()->getManager();
            $em->remove($motivo);
            $em->flush();
        }

        return $this->redirectToRoute('motivo_index');
    }

    /**
     * Creates a form to delete a Motivo entity.
     *
     * @param Motivo $motivo The Motivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Motivo $motivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('motivo_delete', array('id' => $motivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
