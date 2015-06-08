<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('street', 'text', array(
					'attr' => array('id' => 'street'),
				))
			->add('postalCode', 'text', array(
					'attr' => array('id' => 'postalCode'),
				))
			->add('municipality', 'text', array(
					'attr' => array('id' => 'municipality'),
				))
			->add('country', 'text', array(
					'attr' => array('id' => 'country'),
				)); 

			//TODO: country vervangen door dropdown
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Address',
        ));
    }

	public function getName(){
		return 'address';
	}
}
