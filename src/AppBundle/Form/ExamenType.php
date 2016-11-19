<?php namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ExamenType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('fecha', DateType::class, array('widget' => 'single_text',
                    'html5' => false,
                    'attr' => ['class' => 'input-datepicker', 'readonly' => true],
                    'placeholder' => 'Haga clic para seleccionar una fecha',
                    'format' => 'dd/MM/yyyy',
                    'data' => new \DateTime()
                        )
                )
                ->add('paciente', EntityType::class, array(
                    'class' => 'AppBundle:Paciente',
                    'multiple' => false,
                    'expanded' => false
                ))
                ->add('derivadoDesde')
                ->add('procedimiento')
                ->add('medicaciones', EntityType::class, array(
                    'class' => 'AppBundle:Medicacion',
                    'multiple' => true,
                    'expanded' => true,
                ))
                ->add('otrasMedicaciones')
                ->add('factores', EntityType::class, array(
                    'class' => 'AppBundle:Factor',
                    'multiple' => true,
                    'expanded' => true,
                ))
                ->add('otrosFactores')
                ->add('antecedentes')
                ->add('tensionArterialSistolica')
                ->add('tensionArterialDiastolica')
                ->add('ruido1')
                ->add('ruido2')
                ->add('ruido3')
                ->add('ruido4')
                ->add('soplos')
                ->add('spolosComentario')
                ->add('gradoRiesgo')
                ->add('aparatoRespiratorio')
                ->add('electrocardiograma')
                ->add('comentarios')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Examen'
        ));
    }

}
