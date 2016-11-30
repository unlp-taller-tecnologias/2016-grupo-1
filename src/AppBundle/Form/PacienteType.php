<?php

namespace AppBundle\Form;

use AppBundle\Entity\Paciente;
use Doctrine\ORM\EntityRepository;
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
                'placeholder' => "- Seleccione una opción -",
                'choices' => [
                    'Femenino' => Paciente::SEXO_FEMENINO,
                    'Masculino' => Paciente::SEXO_MASCULINO,
                ],
                'choices_as_values' => true
            ])
            ->add('obraSocial')
            ->add('localidad', null, [
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.localidad', 'ASC');
                },
                'placeholder' => '- Seleccione una opción -',

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
