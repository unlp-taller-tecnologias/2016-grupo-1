<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Visita;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Visita controller.
 *
 * @Route("/visita")
 * @Security("has_role('ROLE_MEDICO')")
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

        return $this->render('visita/index.html.twig', [
            'visitas' => $visitas,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Visita entity.
     *
     * @Route("/agregar", name="visita_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $visita = new Visita();
        $form = $this->createForm('AppBundle\Form\VisitaType', $visita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visita);
            $em->flush();

            return $this->redirectToRoute('visita_show', ['id' => $visita->getId()]);
        }

        return $this->render('visita/new.html.twig', [
            'visita' => $visita,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Visita entity.
     *
     * @Route("/{id}", name="visita_show")
     * @Method("GET")
     */
    public function showAction(Visita $visita)
    {
        $deleteForm = $this->createDeleteForm($visita);

        return $this->render('visita/show.html.twig', [
            'visita' => $visita,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Visita entity.
     *
     * @Route("/{id}/editar", name="visita_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Visita $visita)
    {
        $deleteForm = $this->createDeleteForm($visita);
        $editForm = $this->createForm('AppBundle\Form\VisitaType', $visita);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visita);
            $em->flush();

            return $this->redirectToRoute('visita_edit', ['id' => $visita->getId()]);
        }

        return $this->render('visita/edit.html.twig', [
            'visita' => $visita,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Visita entity.
     *
     * @Route("/{id}", name="visita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Visita $visita)
    {
        $form = $this->createDeleteForm($visita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visita);
            $em->flush();
        }

        return $this->redirectToRoute('visita_index');
    }

    /**
     * Creates a form to delete a Visita entity.
     *
     * @param Visita $visita The Visita entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visita $visita)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visita_delete', ['id' => $visita->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
