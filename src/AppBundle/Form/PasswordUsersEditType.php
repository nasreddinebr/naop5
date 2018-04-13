<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class PasswordUsersEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('email')
            ->remove('username')
            ->add('plainPassword',PasswordType::class, array(
                'constraints' => array(
                    new NotBlank(array('message' => "Entrer votre nouveau mot de passe")),
                    new Length(array(
                        'min'   => 6,
                        'max'   => 20
                    ))
                )
            ))
            ->add('update',SubmitType::class,array('label'=>'Modifier'));

    }

    public function getParent()
    {
        return  BaseProfileFormType::class;
    }


}
