<?php

namespace umal\userBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class userType extends AbstractType

{
    private $loginSection;

    public function __construct($loginSection = true,$editform= true)
    {
        $this->loginSection = $loginSection;
        $this->editform= $editform;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($this->loginSection)
    {
        $builder

            ->add('firstname','text',array('label'=>'Firstname',

                'label_attr' => array('class' => 'col-lg-4 control-label',),
                'attr'       => array(
                    'class' => 'form-control'
                )))

            ->add('lastname','text',array('label'=>'Lastname',

                'label_attr' => array('class' => 'col-lg-4 control-label',),
                'attr'       => array('class' => 'form-control')))

            ->add('email','text',array('label'=>'Email ',

                'label_attr' => array('class' => 'col-lg-4 control-label',),
                'attr'       => array('class' => 'form-control')));
    }
        if($this->editform == false)
        {
            $builder
                ->add('username', 'text', array('label' => 'Username',

                    'label_attr' => array('class' => 'col-lg-4 control-label',),
                    'attr' => array('class' => 'form-control')))

                ->add('password', 'password', array('label' => 'Password',
                    'label_attr' => array('class' => 'col-lg-4 control-label'),
                    'attr' => array('class' => 'form-control')
                ));
        }


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'umal\userBundle\Entity\user'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umal_userbundle_user';
    }
}
