<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Repository\UsuarioRepository;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Controlador de Usuario.
 *
 * @Route("/usuario")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UsuarioController extends Controller
{
    /**
     * Lista los usuarios.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityRepository $usuariosRepo */
        $usuariosRepo = $this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuariosQB = $usuariosRepo->createQueryBuilder('u')->orderBy('u.apellido, u.nombre, u.username');
        $usuarios = $this->get('knp_paginator')->paginate(
            $usuariosQB,
            $request->query->getInt('page', 1),
            25
        );

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
     * @Route("/agregar", name="usuario_new")
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
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $switchEnabledForm = $this->createSwitchEnabledForm($usuario);
        $switchAdminForm = $this->createSwitchAdminForm($usuario);

        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
            'switch_enabled_form' => $switchEnabledForm->createView(),
            'switch_admin_form' => $switchAdminForm->createView(),
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

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
        ]);
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
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            /** @var UsuarioRepository $usuariosRepo */
            $usuariosRepo = $em->getRepository('AppBundle:Usuario');
            if ($usuariosRepo->isRemovable($usuario)) {
                $em->remove($usuario);
                try {
                    $em->flush();
                    $message = 'El usuario ha sido eliminado satisfactoriamente';
                    $flashBag->add('success', $message);
                } catch (\Exception $e) {
                    $message = 'Lo sentimos, el usuario no pudo ser eliminado';
                    $flashBag->add('warning', $message);
                }
            } else {
                $message = 'Lo sentimos, el usuario no puede ser eliminado (se ha deshabilitado)';
                $flashBag->add('warning', $message);
                $usuario->setEnabled(false);
                $em->persist($usuario);
                $em->flush();
            }
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Habilitar un usuario
     *
     * @Route("/{id}/habilitar", name="usuario_enable")
     * @Method("POST")
     */
    public function enableAction(Usuario $usuario)
    {
        return $this->toggleEnabled($usuario, true);
    }

    /**
     * Deshabilitar un usuario
     *
     * @Route("/{id}/deshabilitar", name="usuario_disable")
     * @Method("POST")
     */
    public function disableAction(Usuario $usuario)
    {
        return $this->toggleEnabled($usuario, false);
    }

    /**
     * Habilitar/Deshabilitar un usuario
     *
     * @param boolean $enable
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function toggleEnabled(Usuario $usuario, $enable)
    {
        $usuario->setEnabled($enable);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->redirectToRoute('usuario_show', ['id' => $usuario->getId()]);
    }

    /**
     * Otorgar rol de administrador a un usuario
     *
     * @Route("/{id}/otorgar-admin", name="usuario_promote")
     * @Method("POST")
     */
    public function promoteAction(Usuario $usuario)
    {
        return $this->switchPromotion($usuario, true);
    }

    /**
     * Quitar rol de administrador a un usuario
     *
     * @Route("/{id}/quitar-admin", name="usuario_demote")
     * @Method("POST")
     */
    public function demoteAction(Usuario $usuario)
    {
        return $this->switchPromotion($usuario, false);
    }

    private function switchPromotion(Usuario $usuario, $promote)
    {
        if ($promote) {
            $usuario->addRole('ROLE_ADMIN');
        } else {
            $usuario->removeRole('ROLE_ADMIN');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->redirectToRoute('usuario_show', ['id' => $usuario->getId()]);
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

    /**
     * Crea un formulario para habilitar/deshabilitar un usuario
     *
     * @param Usuario $usuario
     * @return \Symfony\Component\Form\Form
     */
    private function createSwitchEnabledForm(Usuario $usuario)
    {
        if ($usuario->isEnabled()) {
            $action = 'usuario_disable';
        } else {
            $action = 'usuario_enable';
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl($action, ['id' => $usuario->getId()]))
            ->add('usuario_enabled', HiddenType::class, ['data' => $usuario->isEnabled()])
            ->getForm()
        ;
    }

    /**
     * Crea un formulario para otorgar/quitar rol de administrador
     * a un usuario
     *
     * @param Usuario $usuario
     * @return \Symfony\Component\Form\Form
     */
    private function createSwitchAdminForm(Usuario $usuario)
    {
        if ($usuario->hasRole('ROLE_ADMIN')) {
            $action = 'usuario_demote';
        } else {
            $action = 'usuario_promote';
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl($action, ['id' => $usuario->getId()]))
            ->add('usuario_admin', HiddenType::class, ['data' => $usuario->hasRole('ROLE_ADMIN')])
            ->getForm()
        ;
    }
}
