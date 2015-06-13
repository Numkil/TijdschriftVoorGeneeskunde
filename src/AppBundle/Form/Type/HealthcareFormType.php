<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class HealthcareFormType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('name')
			->add('email')
			->add('telephone', 'tel', array('default_region' => 'BE',
            'format' => PhoneNumberFormat::NATIONAL))
			->add('address', new AddressFormType())
			->add('vatNumber', 'text', array('required' => false))
			->add('save', 'submit');
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Healthcare',
        ));
    }

	public function getName(){
		return 'healthcare';
	}
}
