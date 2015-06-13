<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubscriptionFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('startdate', 'collot_datetime',
                array( 'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy',
                    'minView' => 'month',
            )))
            ->add('enddate', 'collot_datetime',
                array( 'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy',
                    'minView' => 'month',
            )))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subscription',
        ));
    }

    public function getName(){
        return 'SubscriptionForm';
    }
}
