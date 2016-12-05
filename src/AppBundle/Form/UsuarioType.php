<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);

        $builder
            ->add('username', null, [
                'label' => 'DNI',
                'attr' => [
                    'min' => '1000000',
                    'max' => '99999999',
                ]
            ])
            ->add('apellido')
            ->add('nombre')
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
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => 'Nueva contraseña'],
                'second_options' => ['label' => 'form.password_confirmation'],
                'invalid_message' => 'fos_user.password.mismatch',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Usuario',
            'csrf_token_id' => 'profile',
        ]);
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'fos_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
     function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle'
            ])
        ;
    }
}
