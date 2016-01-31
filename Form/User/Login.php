<?php
// src/Atks/CmsBundle/Form/User/Login.php
namespace Oni\UserManagerBundle\Form\User;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class Login //extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction($options['action']);
        $builder
            ->add('username' , null , array(
                'attr' => array ( 'name' => 'username' ),
                'block_name' => false
                ))
            ->add('password','password')
            ->add('remember_me', 'choice', array(
                'label' => false,
                'choices' => array('yes' => 'Remember Me'),
                'mapped' => false,
                'multiple' => true,
                'expanded' => true
                ))
            ->add('sign_in', 'submit');
    }

    public function getName()
    {
        return 'login';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Oni\UserManagerBundle\Entity\User'
        ));
    }

}