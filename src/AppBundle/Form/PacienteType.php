<?php

namespace AppBundle\Form;

use AppBundle\Entity\Paciente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('dni', null, ['label' => 'DNI'])
            ->add('nombre')
            ->add('apellido')
            ->add('edad')
            ->add('sexo', ChoiceType::class, [
                'placeholder' => "- Seleccione una opción -",
                'choices' => [
                    'Femenino'  => Paciente::SEXO_FEMENINO,
                    'Masculino' => Paciente::SEXO_MASCULINO,
                ],
                'choices_as_values' => true
            ])
            ->add('obraSocial')
            ->add('localidad', null, ['placeholder' => '- Seleccione una opción -'])
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
