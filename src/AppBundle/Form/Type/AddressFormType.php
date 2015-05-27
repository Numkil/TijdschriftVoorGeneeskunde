<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('street')
			->add('postalcode')
			->add('municipality')
			->add('country');
	}

	public function getName(){
		return 'AddressForm';
	}
}
