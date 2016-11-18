<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Medicacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Medicacion controller.
 *
 * @Route("/medicacion")
 */
class MedicacionController extends Controller
{
    /**
     * Listar todas las opciones de "recibe medicación".
     *
     * @Route("/", name="medicacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $medicaciones = $em->getRepository('AppBundle:Medicacion')->findAll();

        $deleteForms = [];
        /** @var Medicacion $medicacion */
        foreach ($medicaciones as $medicacion) {
            $deleteForms[$medicacion->getId()] = $this->createDeleteForm($medicacion)->createView();
        }

        return $this->render('medicacion/index.html.twig', [
            'medicaciones' => $medicaciones,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Crea una nueva opción de medicación
     *
     * @Route("/agregar", name="medicacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $medicacion = new Medicacion();
        $form = $this->createForm('AppBundle\Form\MedicacionType', $medicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medicacion);
            $em->flush();

            return $this->redirectToRoute('medicacion_index');
        }

        return $this->render('medicacion/new.html.twig', [
            'medicacion' => $medicacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Formulario de edición de medicación.
     *
     * @Route("/{id}/editar", name="medicacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Medicacion $medicacion)
    {
        $deleteForm = $this->createDeleteForm($medicacion);
        $editForm = $this->createForm('AppBundle\Form\MedicacionType', $medicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medicacion);
            $em->flush();

            return $this->redirectToRoute('medicacion_edit', ['id' => $medicacion->getId()]);
        }

        return $this->render('medicacion/edit.html.twig', [
            'medicacion' => $medicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Eliminar una opción de medicación.
     *
     * @Route("/{id}", name="medicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Medicacion $medicacion)
    {
        $form = $this->createDeleteForm($medicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medicacion);
            $em->flush();
        }

        return $this->redirectToRoute('medicacion_index');
    }

    /**
     * Formulario para eliminar una medicación.
     *
     * @param Medicacion $medicacion Entidad de Medicacion
     *
     * @return \Symfony\Component\Form\Form Formulario
     */
    private function createDeleteForm(Medicacion $medicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicacion_delete', ['id' => $medicacion->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
