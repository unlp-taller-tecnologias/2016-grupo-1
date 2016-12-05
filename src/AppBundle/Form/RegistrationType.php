<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('nombre')
            ->add('apellido')
            ->add('username', IntegerType::class, [
                'label' => 'DNI',
                'attr' => [
                    'min' => '10000000',
                    'max' => '99999999',
                ]
            ])
            ->add('telefono', null, ['label' => 'Teléfono'])
            ->add('profesion', ChoiceType::class, [
                'placeholder' => '- Seleccione una ocupación -',
                'label' => 'Ocupación',
                'choices' => [
                    'Médico'     => Usuario::PROFESION_MEDICO,
                    'Secretario' => Usuario::PROFESION_SECRETARIO,
                ],
                'choices_as_values' => true,
            ])
            ->add('matricula', null, ['label' => 'Matrícula'])
            ->add('especialidad')
        ;
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
