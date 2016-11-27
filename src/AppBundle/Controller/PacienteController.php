<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Paciente;
use AppBundle\Repository\PacienteRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Paciente controller.
 *
 * @Route("/paciente")
 * @Security("has_role('ROLE_USER')")
 */
class PacienteController extends Controller
{
    /**
     * Lists all Paciente entities.
     *
     * @Route("/", name="paciente_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityRepository $pacientesRepo */
        $pacientesRepo = $this->getDoctrine()->getRepository('AppBundle:Paciente');
        $pacientesQuery = $pacientesRepo->createQueryBuilder('p')->getQuery();
        $pacientes = $this->get('knp_paginator')->paginate(
                $pacientesQuery, $request->query->getInt('page', 1), 5
        );

        $deleteForms = [];
        /** @var Paciente $paciente */
        foreach ($pacientes as $paciente) {
            $deleteForms[$paciente->getId()] = $this->createDeleteForm($paciente)->createView();
        }

        return $this->render('paciente/index.html.twig', [
            'pacientes' => $pacientes,
            'delete_forms' => $deleteForms,
            'search_form' => $this->createSearchForm()->createView(),
        ]);
    }

    /**
     * Buscar un paciente.
     * Procesa los datos enviados desde un formulario de búsqueda.
     * Almacena los parámetros de la búsqueda en la sesión para
     * no interferir con el paginado.
     * 
     * @Route("/buscar", name="paciente_search")
     * @Method({"POST", "GET"})
     */
    public function searchAction(Request $request) {
        $this->procesarParametrosBusqueda($request->request->get('form'));
        $pacientes = $this->get('knp_paginator')->paginate(
            $this->obtenerConsulta(),
            $request->query->getInt('page', 1),
            5
        );

        $deleteForms = [];
        /** @var Paciente $paciente */
        foreach ($pacientes as $paciente) {
            $deleteForms[$paciente->getId()] = $this->createDeleteForm($paciente)->createView();
        }

        return $this->render('paciente/index.html.twig', [
            'pacientes' => $pacientes,
            'delete_forms' => $deleteForms,
            'search_form' => $this->createSearchForm()->createView()
        ]);
    }

    /**
     * Procesa los datos enviados desde el formulario y los agrega a la sesión,
     * o bien persiste los datos si existieran (flash).
     */
    private function procesarParametrosBusqueda($parametros = null)
    {
        if ($parametros !== null) {
            $this->get("session")->getFlashBag()->set("busqueda", $parametros);
        } else if ($this->get("session")->getFlashBag()->has("busqueda")) {
            $this->get("session")->getFlashBag()->set("busqueda", $this->get("session")->getFlashBag()->peek("busqueda"));
        }
    }

    /**
     * Crea la consulta de búsqueda de pacientes tomando los parámetros desde la sesión.
     * @return QueryBuilder object
     */
    private function obtenerConsulta()
    {
        /** @var PacienteRepository $pacientesRepo */
        $pacientesRepo = $this->getDoctrine()->getRepository('AppBundle:Paciente');
        $pacientesQuery = $pacientesRepo->findAllByMultiParametros($this->get("session")->getFlashBag()->peek('busqueda'));

        return $pacientesQuery;
    }

    /**
     * Creates a new Paciente entity.
     *
     * @Route("/agregar", name="paciente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', ['id' => $paciente->getId()]);
        }

        return $this->render('paciente/new.html.twig', [
            'paciente' => $paciente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Paciente entity.
     *
     * @Route("/{id}", name="paciente_show")
     * @Method("GET")
     */
    public function showAction(Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);

        return $this->render('paciente/show.html.twig', [
            'paciente' => $paciente,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Paciente entity.
     *
     * @Route("/{id}/editar", name="paciente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paciente $paciente)
    {
        $editForm = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', ['id' => $paciente->getId()]);
        }

        return $this->render('paciente/edit.html.twig', [
            'paciente' => $paciente,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Paciente entity.
     *
     * @Route("/{id}", name="paciente_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Paciente $paciente)
    {
        $form = $this->createDeleteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getFlashBag();
            $em = $this->getDoctrine()->getManager();
            $em->remove($paciente);
            try {
                $em->flush();
                $message = 'El paciente ha sido eliminado satisfactoriamente';
                $flashBag->add('success', $message);
            } catch (\Exception $e) {
                $message = 'Lo sentimos, el paciente no pudo ser eliminado';
                $flashBag->add('warning', $message);
            }
        }

        return $this->redirectToRoute('paciente_index');
    }

    /**
     * Creates a form to delete a Paciente entity.
     *
     * @param Paciente $paciente The Paciente entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paciente $paciente) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paciente_delete', ['id' => $paciente->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Crear el formulario para buscar un paciente.
     *
     * @return \Symfony\Component\Form\Form Formulario
     */
    private function createSearchForm()
    {
        $parametros = $this->get("session")->getFlashBag()->get("busqueda");
        return $this->createFormBuilder($parametros)
            ->setAction($this->generateUrl('paciente_search'))
            ->setMethod('POST')
            ->add("dni", \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, array(
                'required' => false,
                'data' => ($parametros === null || !isset($parametros["dni"]) || empty($parametros["dni"])) ? null : $parametros["dni"]
            ))
            ->add("nombre", \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['required' => false])
            ->add("apellido", \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['required' => false])
            ->add("tipo", \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
                'required' => false,
                'multiple' => false,
                'label' => 'Tipo de paciente',
                'choices' => [
                    'Nuevos' => 'nuevos',
                    'Del servicio' => 'serv',
                    'Prequirúrgicos' => 'preq',
                ],
                'choices_as_values' => true,
            ])
            ->getForm()
        ;
    }

}
