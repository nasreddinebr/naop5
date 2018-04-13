<?php

namespace AppBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',textType::class, array(
                'constraints'   => array(
                    new NotBlank(array('message' => "Entrez votre nom")),
                    new Length(array(
                        'min' => 3,
                        'max' => 35
                    ))
                ))
            )
            ->add('username', TextType::class, array(
                'constraints'   => array(
                    new NotBlank(array('message' => "Entrez votre Username")),
                    new Length(array(
                        'min' => 3,
                        'max' => 35
                    ))
                ))
            )
            ->add('email',EmailType::class, array(
                'constraints'   => array(new Email(array(
                    'message'   => "{{ value }} n'est pas un email valide.",
                    'checkMX'   => true
                )))
            ))
            ->add('plainPassword',RepeatedType::class,array(
                'type'=>PasswordType::class,
                'invalid_message'   => 'Les mots de passe doivent correspondre',
                'required'          => true,
                'first_options'     => array('label' => 'Mot de passe'),
                'second_options'    => array('label' => 'Répétez le mot de passe'),
                'constraints'       => array(
                    new NotBlank(array('message' => "Entrez votre Password")),
                    new Length(array(
                        'min' => 6,
                        'max' => 65
                    ))
                ))
            )

            ->add('firstname',textType::class, array(
                'constraints'   => array(
                    new NotBlank(array('message' => "Entrez votre prénom")),
                    new Length(array(
                        'min' => 3,
                        'max' => 35
                    ))
                ))
            )
            ->add('profession',textType::class, array(
                'constraints'   => array(
                    new NotBlank(array('message' => "Entrez votre profession")),
                    new Length(array(
                        'min' => 3,
                        'max' => 35
                    ))
                ))
            )
            ->add('birthday',BirthdayType::class,array(
                'format'        => 'd M yyyy',
                'constraints'   => new Date()
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_users';
    }


}
