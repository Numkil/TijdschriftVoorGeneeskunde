<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
	}

	public function getName(){
		return 'SubscriptionForm';
	}
}
