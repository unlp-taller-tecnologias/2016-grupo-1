<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Paciente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paciente controller.
 *
 * @Route("/paciente")
 * @Security("has_role('ROLE_USER')")
 */
class PacienteController extends Controller
{
    /**
     * Lists all Paciente entities.
     *
     * @Route("/", name="paciente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pacientes = $em->getRepository('AppBundle:Paciente')->findAll();

        $deleteForms = [];
        /** @var Paciente $paciente */
        foreach ($pacientes as $paciente) {
            $deleteForms[$paciente->getId()] = $this->createDeleteForm($paciente)->createView();
        }

        return $this->render('paciente/index.html.twig', [
            'pacientes' => $pacientes,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Paciente entity.
     *
     * @Route("/agregar", name="paciente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', ['id' => $paciente->getId()]);
        }

        return $this->render('paciente/new.html.twig', [
            'paciente' => $paciente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Paciente entity.
     *
     * @Route("/{id}", name="paciente_show")
     * @Method("GET")
     */
    public function showAction(Paciente $paciente)
    {
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
    public function editAction(Request $request, Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);
        $editForm = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_edit', ['id' => $paciente->getId()]);
        }

        return $this->render('paciente/edit.html.twig', [
            'paciente' => $paciente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Paciente entity.
     *
     * @Route("/{id}", name="paciente_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Paciente $paciente)
    {
        $form = $this->createDeleteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paciente);
            $em->flush();
        }

        return $this->redirectToRoute('paciente_index');
    }

    /**
     * Creates a form to delete a Paciente entity.
     *
     * @param Paciente $paciente The Paciente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paciente $paciente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paciente_delete', ['id' => $paciente->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
