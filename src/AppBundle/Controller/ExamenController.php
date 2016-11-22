<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Examen;
use AppBundle\Entity\Paciente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Examen controller.
 */
class ExamenController extends Controller
{
    /**
     * Muestra el listado de exámenes prequirúrgico de un paciente
     *
     * @Route("/paciente/{id}/examenes", name="paciente_examenes")
     * @Method("GET")
     */
    public function indexAction(Paciente $paciente)
    {
        $examenes = $paciente->getExamenes();

        $deleteForms = [];
        /** @var Examen $examen */
        foreach ($examenes as $examen) {
            $deleteForms[$examen->getId()] = $this->createDeleteForm($examen)->createView();
        }

        return $this->render('examen/index.html.twig', [
            'examenes' => $examenes,
            'paciente' => $paciente,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Registra un examen realizado por un paciente.
     *
     * @Route("/paciente/{id}/registrar-examen", name="paciente_registrar-examen")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Paciente $paciente)
    {
        $examen = new Examen($paciente, $this->getUser());
        $form = $this->createForm('AppBundle\Form\ExamenType', $examen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            return $this->redirectToRoute('paciente_examenes', ['id' => $paciente->getId()]);
        }

        return $this->render('examen/new.html.twig', [
            'examen' => $examen,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Muestra un examen prequirúrgico en particular
     *
     * @Route("/examen/{id}", name="examen_show")
     * @Method("GET")
     */
    public function showAction(Examen $examen)
    {
        $deleteForm = $this->createDeleteForm($examen);

        return $this->render('examen/show.html.twig', [
            'examen' => $examen,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Muestra el formulario de edición de un examen prequirúrgico
     *
     * @Route("/examen/{id}/editar", name="examen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Examen $examen)
    {
        $editForm = $this->createForm('AppBundle\Form\ExamenType', $examen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            return $this->redirectToRoute('examen_show', ['id' => $examen->getId()]);
        }

        return $this->render('examen/edit.html.twig', [
            'examen' => $examen,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Elimina un examen prequirúrgico
     *
     * @Route("/examen/{id}", name="examen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Examen $examen)
    {
        $form = $this->createDeleteForm($examen);
        $form->handleRequest($request);

        $pacienteID = $examen->getPaciente()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($examen);
            $em->flush();
        }

        return $this->redirectToRoute('paciente_examenes', ['id' => $pacienteID]);
    }

    /**
     * Crea el formulario para eliminar el examen prequirúrgico
     *
     * @param Examen $examen La entidad Examen a eliminar
     * @return \Symfony\Component\Form\Form El formulario
     */
    private function createDeleteForm(Examen $examen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('examen_delete', ['id' => $examen->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
