<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Factor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Factor;
use AppBundle\Form\FactorType;

/**
 * Controlador de factores de riesgo.
 *
 * @Route("/factor")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FactorController extends Controller
{
    /**
     * Lista todos los factores de riesgo.
     *
     * @Route("/", name="factor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factores = $em->getRepository('AppBundle:Factor')->findAll();

        $deleteForms = [];
        /** @var Factor $factor */
        foreach ($factores as $factor) {
            $deleteForms[$factor->getId()] = $this->createDeleteForm($factor)->createView();
        }

        return $this->render('factor/index.html.twig', [
            'factores' => $factores,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Crear un nuevo factor de riesgo.
     *
     * @Route("/nuevo", name="factor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $factor = new Factor();
        $form = $this->createForm('AppBundle\Form\FactorType', $factor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($factor);
            $em->flush();

            return $this->redirectToRoute('factor_index');
        }

        return $this->render('factor/new.html.twig', [
            'factor' => $factor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edición de un factor de riesgo.
     *
     * @Route("/{id}/editar", name="factor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Factor $factor)
    {
        $deleteForm = $this->createDeleteForm($factor);
        $editForm = $this->createForm('AppBundle\Form\FactorType', $factor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($factor);
            $em->flush();

            return $this->redirectToRoute('factor_edit', ['id' => $factor->getId()]);
        }

        return $this->render('factor/edit.html.twig', [
            'factor' => $factor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Eliminar un factor de riesgo.
     *
     * @Route("/{id}", name="factor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Factor $factor)
    {
        $form = $this->createDeleteForm($factor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($factor);
            $em->flush();
        }

        return $this->redirectToRoute('factor_index');
    }

    /**
     * Crea el formulario para eliminar un factor de riesgo.
     *
     * @param Factor $factor Un elemento entidad de factor de riesgo.
     *
     * @return \Symfony\Component\Form\Form Formulario.
     */
    private function createDeleteForm(Factor $factor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('factor_delete', ['id' => $factor->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
