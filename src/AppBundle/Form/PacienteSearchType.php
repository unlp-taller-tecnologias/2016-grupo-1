<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PacienteSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('apellido', TextType::class, ['required' => false])
            ->add('nombre', TextType::class, ['required' => false])
            ->add('dni', IntegerType::class, [
                'label' => 'DNI',
                'attr' => ['class' => 'hide-spinners'],
                'required' => false,
            ])
            ->add('medico', EntityType::class, [
                'class' => 'AppBundle:Usuario',
                'label' => 'Médico asignado',
                'placeholder' => '-',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.profesion = :profesion')
                        ->andWhere('u.enabled = true')
                        ->orderBy('u.apellido, u.nombre')
                        ->setParameter('profesion', Usuario::PROFESION_MEDICO)
                    ;
                },
            ])
            ->add('tipo', ChoiceType::class, [
                'required' => false,
                'multiple' => false,
                'label' => 'Tipo de paciente',
                'placeholder' => '-',
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return null;
    }
}
