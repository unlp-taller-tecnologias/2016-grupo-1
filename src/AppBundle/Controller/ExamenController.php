<?php namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Examen;
use AppBundle\Form\ExamenType;

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

        return $this->render('examen/index.html.twig', array(
                    'examens' => $examens,
        ));
    }

    /**
     * Crea una nueva entidad de Examen prequirúrgico
     *
     * @Route("/nuevo", name="examen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $examan = new Examen();
        $form = $this->createForm('AppBundle\Form\ExamenType', $examan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examan);
            $em->flush();

            return $this->redirectToRoute('examen_show', array('id' => $examan->getId()));
        }

        return $this->render('examen/new.html.twig', array(
                    'examan' => $examan,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Muestra un examen prequirúrgico en particular
     *
     * @Route("/{id}", name="examen_show")
     * @Method("GET")
     */
    public function showAction(Examen $examan) {
        $deleteForm = $this->createDeleteForm($examan);

        return $this->render('examen/show.html.twig', array(
                    'examan' => $examan,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Muestra el formulario de edición de un examen prequirúrgico
     *
     * @Route("/{id}/editar", name="examen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Examen $examan) {
        $deleteForm = $this->createDeleteForm($examan);
        $editForm = $this->createForm('AppBundle\Form\ExamenType', $examan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($examan);
            $em->flush();

            return $this->redirectToRoute('examen_edit', array('id' => $examan->getId()));
        }

        return $this->render('examen/edit.html.twig', array(
                    'examan' => $examan,
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
    public function deleteAction(Request $request, Examen $examan) {
        $form = $this->createDeleteForm($examan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($examan);
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
