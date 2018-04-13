<?php

namespace AppBundle\Form\Admin;

use AppBundle\Form\PictureUsersNewsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;


class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('newsDate',DateType::class,array(
                'label'     => 'Date de la publication',
                'format'    => 'dd MM yy','html5'=>false
            ))
            ->add('post', TextareaType::class, array(
                'required'  => false
            ))
            ->add('picture', PictureUsersNewsType::class, array(
                'required'  => false,
            ))
            ->add('published')
            ->add('user');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_news';
    }


}
