<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aves', AvesType::class)
            ->add('observationDate', DateType::class, array(
                'constraints' => array(new Date())
            ))
            ->add('latitude', TextType::class, array(
                'constraints' => array(new NotBlank(array('message' => "La latitude doit étre mentionner")))
            ))
            ->add('longitude',TextType::class, array(
                'constraints' => array(new NotBlank(array('message' => "La longintude doit étre mentionner")))
            ))
            ->add('observationComment',TextareaType::class, array(
                'constraints' => array(
                    new NotBlank(array('message' => "Vous devez ajouter votre observation")),
                    new Length(array(
                        'min'   => 10,
                        'max'   => 350
                    ))
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }


}
