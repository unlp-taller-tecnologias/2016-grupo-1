<?php namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ExamenType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('fecha', 'datetime')
                ->add('otrosFactores')
                ->add('otrasMedicaciones')
                ->add('derivadoDesde')
                ->add('gradoRiesgo')
                ->add('antecedentes')
                ->add('procedimiento')
                ->add('ruido1')
                ->add('ruido2')
                ->add('ruido3')
                ->add('ruido4')
                ->add('tensionArterialSistolica')
                ->add('tensionArterialDiastolica')
                ->add('soplos')
                ->add('comentarios')
                ->add('aparatoRespiratorio')
                ->add('electrocardiograma')
                ->add('spolosComentario')
                ->add('medicaciones', EntityType::class, array(
                    'class' => 'AppBundle:Medicacion',
                    'multiple' => true,
                    'expanded' => true,
                ))
                ->add('factores', EntityType::class, array(
                    'class' => 'AppBundle:Factor',
                    'multiple' => true,
                    'expanded' => true,
                ))
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
