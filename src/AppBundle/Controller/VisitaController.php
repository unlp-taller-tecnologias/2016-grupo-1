<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Visita;
use AppBundle\Form\VisitaType;

/**
 * Visita controller.
 *
 * @Route("/visita")
 */
class VisitaController extends Controller
{
    /**
     * Lists all Visita entities.
     *
     * @Route("/", name="visita_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visitas = $em->getRepository('AppBundle:Visita')->findAll();
        
        $deleteForms = [];
        /** @var Visita $visita */
        foreach ($visitas as $visita){
            $deleteForms[$visita->getId()] = $this->createDeleteForm($visita)->createView();
        }

        return $this->render('visita/index.html.twig', array(
            'visitas' => $visitas,
            'delete_forms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Visita entity.
     *
     * @Route("/new", name="visita_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $visitum = new Visita();
        $form = $this->createForm('AppBundle\Form\VisitaType', $visitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitum);
            $em->flush();

            return $this->redirectToRoute('visita_show', array('id' => $visitum->getId()));
        }

        return $this->render('visita/new.html.twig', array(
            'visitum' => $visitum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Visita entity.
     *
     * @Route("/{id}", name="visita_show")
     * @Method("GET")
     */
    public function showAction(Visita $visitum)
    {
        $deleteForm = $this->createDeleteForm($visitum);

        return $this->render('visita/show.html.twig', array(
            'visitum' => $visitum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Visita entity.
     *
     * @Route("/{id}/edit", name="visita_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Visita $visitum)
    {
        $deleteForm = $this->createDeleteForm($visitum);
        $editForm = $this->createForm('AppBundle\Form\VisitaType', $visitum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitum);
            $em->flush();

            return $this->redirectToRoute('visita_edit', array('id' => $visitum->getId()));
        }

        return $this->render('visita/edit.html.twig', array(
            'visitum' => $visitum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Visita entity.
     *
     * @Route("/{id}", name="visita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Visita $visitum)
    {
        $form = $this->createDeleteForm($visitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visitum);
            $em->flush();
        }

        return $this->redirectToRoute('visita_index');
    }

    /**
     * Creates a form to delete a Visita entity.
     *
     * @param Visita $visitum The Visita entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visita $visitum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visita_delete', array('id' => $visitum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
