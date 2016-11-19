<?php namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VisitaType extends AbstractType {
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
                ->add('observaciones', TextareaType::class, [
                    'required' => false,
                ])
                ->add('notasPersonales', TextareaType::class, [
                    'required' => false,
                ])
                ->add('motivos')
                ->add('diagnosticos', null, ['label' => 'Diagnósticos'])
                ->add('medico', null, ['label' => 'Médico'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Visita']);
    }

}
