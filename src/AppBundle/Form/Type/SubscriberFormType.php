<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\AddressFormType;

class SubscriberFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('school')
			->add('pricingtype')
			->add('graduation', 'datetime')
            ->add('deliveryaddress', new AddressFormType())
            ->add('facturationaddress', new AddressFormType());
	}

	public function getName(){
		return 'SubscriberForm';
	}
}
