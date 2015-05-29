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
            ->add('deliveryaddress', new AddressFormType())
            ->add('facturationaddress', new AddressFormType())
			->add('save', 'submit');
	}

	public function getName(){
		return 'SubscriberForm';
	}
}
