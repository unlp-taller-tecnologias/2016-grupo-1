<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Medicacion;
use AppBundle\Form\MedicacionType;

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

        $medicacions = $em->getRepository('AppBundle:Medicacion')->findAll();

        return $this->render('medicacion/index.html.twig', array(
            'medicacions' => $medicacions,
        ));
    }

    /**
     * Crea una nueva opción de medicación
     *
     * @Route("/crear", name="medicacion_new")
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

            return $this->redirectToRoute('medicacion_show', array('id' => $medicacion->getId()));
        }

        return $this->render('medicacion/new.html.twig', array(
            'medicacion' => $medicacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Vista detalle de una opción de medicación.
     *
     * @Route("/{id}", name="medicacion_show")
     * @Method("GET")
     */
    public function showAction(Medicacion $medicacion)
    {
        $deleteForm = $this->createDeleteForm($medicacion);

        return $this->render('medicacion/show.html.twig', array(
            'medicacion' => $medicacion,
            'delete_form' => $deleteForm->createView(),
        ));
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

            return $this->redirectToRoute('medicacion_edit', array('id' => $medicacion->getId()));
        }

        return $this->render('medicacion/edit.html.twig', array(
            'medicacion' => $medicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
            ->setAction($this->generateUrl('medicacion_delete', array('id' => $medicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
