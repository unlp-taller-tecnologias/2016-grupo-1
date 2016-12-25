<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Localidad;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Localidad controller.
 *
 * @Route("/localidad")
 * @Security("has_role('ROLE_ADMIN')")
 */
class LocalidadController extends Controller
{
    /**
     * Lists all Localidad entities.
     *
     * @Route("/", name="localidad_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityRepository $localidadesRepo */
        $localidadesRepo = $this->getDoctrine()->getRepository('AppBundle:Localidad');
        $localidadesQB = $localidadesRepo->createQueryBuilder('l')->orderBy('l.localidad');
        $localidades = $this->get('knp_paginator')->paginate(
            $localidadesQB,
            $request->query->getInt('page', 1),
            25
        );

        $deleteForms = [];
        /** @var Localidad $localidad */
        foreach ($localidades as $localidad) {
            $deleteForms[$localidad->getId()] = $this->createDeleteForm($localidad)->createView();
        }

        return $this->render('localidad/index.html.twig', [
            'localidades' => $localidades,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Creates a new Localidad entity.
     *
     * @Route("/agregar", name="localidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $localidad = new Localidad();
        $form = $this->createForm('AppBundle\Form\LocalidadType', $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($localidad);
            $em->flush();

            return $this->redirectToRoute('localidad_index');
        }

        return $this->render('localidad/new.html.twig', [
            'localidad' => $localidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Localidad entity.
     *
     * @Route("/{id}/editar", name="localidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Localidad $localidad)
    {
        $editForm = $this->createForm('AppBundle\Form\LocalidadType', $localidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($localidad);
            $em->flush();

            return $this->redirectToRoute('localidad_index');
        }

        return $this->render('localidad/edit.html.twig', [
            'localidad' => $localidad,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Localidad entity.
     *
     * @Route("/{id}", name="localidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Localidad $localidad)
    {
        $form = $this->createDeleteForm($localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $pacientesRepo = $em->getRepository('AppBundle:Paciente');
            if (!$pacientesRepo->findOneBy(['localidad' => $localidad])) { // La localidad no contiene pacientes
                $em->remove($localidad);
                try {
                    $em->flush();
                    $message = 'La localidad ha sido eliminada satisfactoriamente';
                    $flashBag->add('success', $message);
                } catch (\Exception $e) {
                    $message = 'Lo sentimos, la localidad no pudo ser eliminada';
                    $flashBag->add('warning', $message);
                }
            } else {
                // TODO: Ofrecer mover los pacientes a otra localidad
                $message = 'La localidad no puede ser eliminada ya que contiene pacientes';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('localidad_index');
    }

    /**
     * Creates a form to delete a Localidad entity.
     *
     * @param Localidad $localidad The Localidad entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Localidad $localidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localidad_delete', ['id' => $localidad->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
