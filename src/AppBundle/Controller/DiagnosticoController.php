<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Diagnostico;
use AppBundle\Form\DiagnosticoType;

/**
 * Diagnostico controller.
 *
 * @Route("/diagnostico")
 */
class DiagnosticoController extends Controller
{
    /**
     * Lists all Diagnostico entities.
     *
     * @Route("/", name="diagnostico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diagnosticos = $em->getRepository('AppBundle:Diagnostico')->findAll();

        $deleteForms = [];
        /** @var Diagnostico $diagnostico */
        foreach ($diagnosticos as $diagnostico) {
            $deleteForms[$diagnostico->getId()] = $this->createDeleteForm($diagnostico)->createView();
        }

        return $this->render('diagnostico/index.html.twig', array(
            'diagnosticos' => $diagnosticos,
            'delete_forms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Diagnostico entity.
     *
     * @Route("/new", name="diagnostico_new")
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

            return $this->redirectToRoute('diagnostico_show', array('id' => $diagnostico->getId()));
        }

        return $this->render('diagnostico/new.html.twig', array(
            'diagnostico' => $diagnostico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Diagnostico entity.
     *
     * @Route("/{id}", name="diagnostico_show")
     * @Method("GET")
     */
    public function showAction(Diagnostico $diagnostico)
    {
        $deleteForm = $this->createDeleteForm($diagnostico);

        return $this->render('diagnostico/show.html.twig', array(
            'diagnostico' => $diagnostico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Diagnostico entity.
     *
     * @Route("/{id}/edit", name="diagnostico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Diagnostico $diagnostico)
    {
        $deleteForm = $this->createDeleteForm($diagnostico);
        $editForm = $this->createForm('AppBundle\Form\DiagnosticoType', $diagnostico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diagnostico);
            $em->flush();

            return $this->redirectToRoute('diagnostico_edit', array('id' => $diagnostico->getId()));
        }

        return $this->render('diagnostico/edit.html.twig', array(
            'diagnostico' => $diagnostico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
            $em = $this->getDoctrine()->getManager();
            $em->remove($diagnostico);
            $em->flush();
        }

        return $this->redirectToRoute('diagnostico_index');
    }

    /**
     * Creates a form to delete a Diagnostico entity.
     *
     * @param Diagnostico $diagnostico The Diagnostico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Diagnostico $diagnostico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diagnostico_delete', array('id' => $diagnostico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
