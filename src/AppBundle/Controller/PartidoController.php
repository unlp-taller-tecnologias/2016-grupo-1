<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partido;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partido controller.
 *
 * @Route("/partido")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PartidoController extends Controller
{
    /**
     * Lists all Partido entities.
     *
     * @Route("/", name="partido_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partidos = $em->getRepository('AppBundle:Partido')->findAll();

        $deleteForms = [];
        /** @var Partido $partido */
        foreach ($partidos as $partido) {
            $deleteForms[$partido->getId()] = $this->createDeleteForm($partido)->createView();
        }

        return $this->render('partido/index.html.twig', [
            'partidos' => $partidos,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Partido entity.
     *
     * @Route("/agregar", name="partido_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $partido = new Partido();
        $form = $this->createForm('AppBundle\Form\PartidoType', $partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partido);
            $em->flush();

            return $this->redirectToRoute('partido_index');
        }

        return $this->render('partido/new.html.twig', [
            'partido' => $partido,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Partido entity.
     *
     * @Route("/{id}/editar", name="partido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Partido $partido)
    {
        $editForm = $this->createForm('AppBundle\Form\PartidoType', $partido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partido);
            $em->flush();

            return $this->redirectToRoute('partido_index');
        }

        return $this->render('partido/edit.html.twig', [
            'partido' => $partido,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Partido entity.
     *
     * @Route("/{id}", name="partido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Partido $partido)
    {
        $form = $this->createDeleteForm($partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partido);
            $em->flush();
        }

        return $this->redirectToRoute('partido_index');
    }

    /**
     * Creates a form to delete a Partido entity.
     *
     * @param Partido $partido The Partido entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partido $partido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partido_delete', ['id' => $partido->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
