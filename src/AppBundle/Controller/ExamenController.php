<?php namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Examen;
use AppBundle\Form\ExamenType;
use AppBundle\Entity\Paciente;

/**
 * Examen controller.
 *
 * @Route("/examen")
 */
class ExamenController extends Controller {
    /**
     * Lists all Examen entities.
     *
     * @Route("/", name="examen_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $examens = $em->getRepository('AppBundle:Examen')->findAll();

        $deleteForms = [];
        /** @var Examen $examen */
        foreach ($examens as $examen) {
            $deleteForms[$examen->getId()] = $this->createDeleteForm($examen)->createView();
        }

        return $this->render('examen/index.html.twig', [
                    'examens' => $examens,
                    'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Crea una nueva entidad de Examen prequirúrgico
     *
     * @Route("/nuevo", name="examen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $examen = new Examen($this->get("security.token_storage")->getToken()->getUser());
        $form = $this->createForm('AppBundle\Form\ExamenType', $examen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            return $this->redirectToRoute('examen_show', array('id' => $examen->getId()));
        }

        return $this->render('examen/new.html.twig', array(
                    'examen' => $examen,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Muestra el listado de exámenes prequirúrgico de un paciente.
     * 
     * @Route("/listar/{id}", name="examen_paciente")
     * @Method("GET")
     */
    public function listarAction(Paciente $paciente) {
        $em = $this->getDoctrine()->getManager();
        $examens = $em->getRepository('AppBundle:Examen')->findByPaciente($paciente->getId());
        $deleteForms = [];
        /** @var Examen $examen */
        foreach ($examens as $examen) {
            $deleteForms[$examen->getId()] = $this->createDeleteForm($examen)->createView();
        }

        return $this->render('examen/index.html.twig', [
                    'examens' => $examens,
                    'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Muestra un examen prequirúrgico en particular
     *
     * @Route("/{id}", name="examen_show")
     * @Method("GET")
     */
    public function showAction(Examen $examen) {
        $deleteForm = $this->createDeleteForm($examen);

        return $this->render('examen/show.html.twig', array(
                    'examen' => $examen,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Muestra el formulario de edición de un examen prequirúrgico
     *
     * @Route("/{id}/editar", name="examen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Examen $examen) {
        $deleteForm = $this->createDeleteForm($examen);
        $editForm = $this->createForm('AppBundle\Form\ExamenType', $examen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            return $this->redirectToRoute('examen_edit', array('id' => $examen->getId()));
        }

        return $this->render('examen/edit.html.twig', array(
                    'examen' => $examen,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Elimina un examen prequirúrgico
     *
     * @Route("/{id}", name="examen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Examen $examen) {
        $form = $this->createDeleteForm($examen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($examen);
            $em->flush();
        }

        return $this->redirectToRoute('examen_index');
    }

    /**
     * Crea el formulario para eliminar el examen prequirúrgico
     *
     * @param Examen $examen La entidad Examen a eliminar
     *
     * @return \Symfony\Component\Form\Form El formulario
     */
    private function createDeleteForm(Examen $examen) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('examen_delete', array('id' => $examen->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
