<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de Usuario.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lista los usuarios.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();
        $deleteForms = [];
        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {
            $deleteForms[$usuario->getId()] = $this->createDeleteForm($usuario)->createView();
        }

        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * Crea un nuevo usuario
     *
     * @Route("/nuevo", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $usuario = $userManager->createUser();
        $usuario->setEnabled(true);

        $form = $formFactory->createForm();
        $form->setData($usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($usuario);

            return $this->redirectToRoute('usuario_show', ['id' => $usuario->getId()]);
        }

        return $this->render('usuario/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Muestra un usuario
     *
     * @Route("/{id}", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Modifica un usuario
     *
     * @Route("/{id}/editar", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $editForm = $formFactory->createForm();
        $editForm->setData($usuario);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($usuario);

            return $this->redirectToRoute('usuario_show', ['id' => $usuario->getId()]);
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Eliminar un usuario
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Crea un formulario para eliminar un usuario
     *
     * @param Usuario $usuario
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', ['id' => $usuario->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
