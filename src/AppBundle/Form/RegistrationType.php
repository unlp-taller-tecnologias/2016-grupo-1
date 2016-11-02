<?php


namespace AppBundle\Form;


use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Validator\Constraints\Choice;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('nombre')
            ->add('apellido')
            ->add('username', null, ['label' => 'DNI'])
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), [
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle'
            ])
            ->add('telefono', null, ['label' => 'Teléfono'])
            ->add('profesion', ChoiceType::class, [
                'placeholder' => "- Seleccione una opción -",
                'label' => "Profesión",
                'choices' => [
                    'Médico'     => Usuario::PROFESION_MEDICO,
                    'Secretario' => Usuario::PROFESION_SECRETARIO,
                ],
                'choices_as_values' => true,
                'required'          => true,
            ])
            ->add('matricula', null, ['label' => 'Matrícula'])
            ->add('especialidad')
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), [
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => 'form.password'],
                'second_options' => ['label' => 'form.password_confirmation'],
                'invalid_message' => 'fos_user.password.mismatch',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Usuario',
                'csrf_token_id' => 'registration',
            ]
        );
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
