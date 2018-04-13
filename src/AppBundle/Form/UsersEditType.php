<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UsersEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('name', TextType::class, array(
                  'label'=>'Nom',
                  'constraints' => array(
                      new NotBlank(array('message'   => "Entrez votre nom")),
                      new Length(array('min' => 3, 'max' => 35))
                  )
              ))
              ->add('firstname', TextType::class, array(
                  'label'=>'Prénom',
                  'constraints' => array(
                      new NotBlank(array('message'   => "Entrez votre prénom")),
                      new Length(array('min' => 3, 'max' => 35))
                  )
              ))
              ->add('profession', TextType::class, array(
                  'label'       =>'Profession',
                  'constraints' => array(
                      new NotBlank(array('message' => "Entrez votre profession")),
                      new Length(array(
                          'min' => 3,
                          'max' => 35
                      ))
                  )
              ))
              ->add('birthday', BirthdayType::class, array(
                  'label'       => 'Naissance',
                  'format'      => 'dd MM yy',
                  'html5'       => false,
                  'constraints' => array(new Date())
              ))
              ->add('isnaturalist', checkboxType::class, array(
                  'label'       => 'Je suis naturaliste',
                  'required'    => false
              ))
              ->add('picture', PictureUsersNewsType::class, array(
                  'required'    => false
              ))
              ->remove('username')
              ->remove('email')
              ->remove('current_password')
              ->add('save', SubmitType::class, array('label'=>'valider'));
    }

    public function getParent()
    {
        return  BaseProfileFormType::class;
    }
}
