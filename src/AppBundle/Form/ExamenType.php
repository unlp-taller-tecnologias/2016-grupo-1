<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'attr' => ['class' => 'input-datepicker', 'readonly' => true],
                'placeholder' => 'Haga clic para seleccionar una fecha',
                'format' => 'dd/MM/yyyy',
                'data' => new \DateTime()
            ])
            ->add('derivadoDesde')
            ->add('procedimiento')
            ->add('medicaciones', EntityType::class, [
                'class' => 'AppBundle:Medicacion',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('otrasMedicaciones')
            ->add('factores', EntityType::class, [
                'class' => 'AppBundle:Factor',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('otrosFactores')
            ->add('antecedentes')
            ->add('tensionArterialSistolica', null, ['label' => 'Tensión arterial sistólica'])
            ->add('tensionArterialDiastolica', null, ['label' => 'Tensión arterial diastólica'])
            ->add('ruido1')
            ->add('ruido2')
            ->add('ruido3')
            ->add('ruido4')
            ->add('soplos')
            ->add('soplosComentario')
            ->add('aparatoRespiratorio')
            ->add('electrocardiograma')
            ->add('comentarios')
            ->add('gradoRiesgo', ChoiceType::class, [
                'choices' => [
                    '1 (uno)' => 1,
                    '2 (dos)' => 2,
                    '3 (tres) con monitoreo cardiológico' => 3,
                    '4 (cuatro) se contraindica cirugia' => 4,
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
