<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Type\AddressFormType;
use AppBundle\Entity\Types\PaymentType;

class SubscriberFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('school', 'text', array('required' => false))
            ->add('pricingtype', 'choice', [
                'choices' => PaymentType::getChoices()
            ])
            ->add('graduation', 'collot_datetime',
                array( 
                    'required' => false,
                    'pickerOptions' => array(
                        'format' => 'dd/mm/yyyy',
                        'minView' => 'month',
            )))
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
            ->add('vatNumber', 'text', array('required' => false))
            /*->add('paperversion', 'checkbox', array(
				    'label'    => 'I want to receive a paper version',
				    'required' => false,

				))*/
			->add('save', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subscriber',
        ));
    }

	public function getName(){
		return 'SubscriberForm';
	}
}
