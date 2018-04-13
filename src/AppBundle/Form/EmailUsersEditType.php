<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;



class EmailUsersEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
             ->remove('username')
             ->remove('current_password')
             ->add('update',SubmitType::class,array('label' => 'Modifier'));

    }

    public function getParent()
    {
        return  BaseProfileFormType::class;
    }

}
