<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('startDate', 'collot_datetime',
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

    public function getName(){
        return 'SubscriptionForm';
    }
}
