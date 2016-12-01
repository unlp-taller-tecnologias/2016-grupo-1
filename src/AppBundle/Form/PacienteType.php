<?php

namespace AppBundle\Form;

use AppBundle\Entity\Paciente;
use AppBundle\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PacienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dni', null, [
                'label' => 'DNI',
                'attr' => [
                    'min' => '10000000',
                    'max' => '99999999',
                ]
            ])
            ->add('apellido')
            ->add('nombre')
            ->add('edad', IntegerType::class)
            ->add('sexo', ChoiceType::class, [
                'placeholder' => '- Seleccione un sexo -',
                'choices' => [
                    'Femenino' => Paciente::SEXO_FEMENINO,
                    'Masculino' => Paciente::SEXO_MASCULINO,
                ],
                'choices_as_values' => true
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
            ->add('obraSocial')
            ->add('localidad', null, [
                'placeholder' => '- Seleccione una localidad -',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')->orderBy('l.localidad');
                },

            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Paciente']);
    }

}
