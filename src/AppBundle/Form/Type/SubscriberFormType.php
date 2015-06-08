<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\AddressFormType;
use AppBundle\Entity\Types\PaymentType;

class SubscriberFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('school')
            ->add('pricingtype', 'choice', [
                'choices' => PaymentType::getChoices()
            ])
			->add('graduation', 'date')
            ->add('wantsBill', 'checkbox',
                array(
                    'required' => false,
                )
            )
            ->add('deliveryaddress', new AddressFormType())
            ->add('facturationaddress', new AddressFormType())
            ->add('sameaddress', 'checkbox', array(
        	   		'label' => 'Delivery address and facturation address are the same',
            		'mapped' => false,
            		'data' => true,
            		
            	))
            /*->add('paperversion', 'checkbox', array(
				    'label'    => 'I want to receive a paper version',
				    'required' => false,
				    
				))*/
			->add('save', 'submit');
	}

	public function getName(){
		return 'SubscriberForm';
	}
}
