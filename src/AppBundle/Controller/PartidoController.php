<?php namespace AppBundle\Controller;

use AppBundle\Entity\Partido;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Partido controller.
 *
 * @Route("/partido")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PartidoController extends Controller {
    /**
     * Lists all Partido entities.
     *
     * @Route("/", name="partido_index")
     * @Method("GET")
     */
    public function indexAction(Request $request) {
        /** @var EntityRepository $partidosRepo */
        $partidosRepo = $this->getDoctrine()->getRepository('AppBundle:Partido');
        $partidosQB = $partidosRepo->createQueryBuilder('p')->orderBy('p.partido');
        $partidos = $this->get('knp_paginator')->paginate(
                $partidosQB, $request->query->getInt('page', 1), 25
        );

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
    public function newAction(Request $request) {
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
     * Lista las localidades del partido indicado enviando el resultado en JSON.
     * 
     * @Route("/{id}/localidades", name="partido_localidades", options={"expose"=true})
     * @Method("GET")
     */
    public function localidadesAction(Request $request, Partido $partido) {
        if ($request->isXmlHttpRequest()) {
            $localidadesRepo = $this->getDoctrine()->getRepository('AppBundle:Localidad');
            $localidades = $localidadesRepo->findByPartido($partido, ["localidad" => "asc"]);
            return new Response(json_encode($localidades, JSON_UNESCAPED_UNICODE));
        } else {
            return $this->redirectToRoute('partido_index');
        }
    }

    /**
     * Displays a form to edit an existing Partido entity.
     *
     * @Route("/{id}/editar", name="partido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Partido $partido) {
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
    public function deleteAction(Request $request, Partido $partido) {
        $form = $this->createDeleteForm($partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $localidadesRepo = $em->getRepository('AppBundle:Localidad');
            if (!$localidadesRepo->findOneBy(['partido' => $partido])) { // El partido no contiene localidades
                $em->remove($partido);
                $em->flush();
                $message = 'El partido ha sido eliminado satisfactoriamente';
                $flashBag->add('success', $message);
            } else {
                $message = 'El partido no puede ser eliminado ya que contiene localidades';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('partido_index');
    }

    /**
     * Creates a form to delete a Partido entity.
     *
     * @param Partido $partido The Partido entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partido $partido) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('partido_delete', ['id' => $partido->getId()]))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
