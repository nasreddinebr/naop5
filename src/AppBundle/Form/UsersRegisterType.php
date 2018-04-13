<?php
/**
 * Created by PhpStorm.
 * User: radoncode
 * Date: 11/01/18
 * Time: 17:58
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class UsersRegisterType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
     {

     }

     public function getParent()
     {
         return BaseRegistrationFormType::class;
     }
}