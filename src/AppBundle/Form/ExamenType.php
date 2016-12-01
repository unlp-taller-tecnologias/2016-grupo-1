<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'input-datepicker',
                    'data-date-end-date' => '0d',
                    'readonly' => true
                ],
                'placeholder' => 'Haga clic para seleccionar una fecha',
                'format' => 'dd/MM/yyyy',
                'data' => new \DateTime()
            ])
            ->add('derivadoDesde')
            ->add('procedimiento')
            ->add('medicaciones', null, [
                'label' => 'Medicación',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('otrasMedicaciones', 'text', ['label' => 'Medicación (otras)', 'required' => false])
            ->add('factores', null, [
                'label' => 'Factores de riesgo cardiovascular',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('otrosFactores', 'text', ['label' => 'Factores de riesgo (otros)', 'required' => false])
            ->add('antecedentes')
            ->add('tensionArterialSistolica', null, [
                'label' => 'Tensión arterial sistólica',
                'attr' => [
                    'class' => 'en-linea',
                    'max' => 999,
                ]
            ])
            ->add('tensionArterialDiastolica', null, [
                'label' => 'Tensión arterial diastólica',
                'attr' => [
                    'class' => 'en-linea',
                    'max' => 999,
                ]
            ])
            ->add('ruido1', null, ['label' => 'R1'])
            ->add('ruido2', null, ['label' => 'R2'])
            ->add('ruido3', null, ['label' => 'R3'])
            ->add('ruido4', null, ['label' => 'R4'])
            ->add('soplos')
            ->add('soplosComentario', null, ['attr' => ['class' => 'en-linea']])
            ->add('aparatoRespiratorio')
            ->add('electrocardiograma')
            ->add('comentarios')
            ->add('gradoRiesgo', ChoiceType::class, [
                'label' => 'Grado de riesgo',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3 (con monitoreo cardiológico)' => 3,
                    '4 (se contraindica cirugía)' => 4,
                ],
                'multiple' => false,
                'expanded' => true,
                'choices_as_values' => true,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Examen']);
    }
}
