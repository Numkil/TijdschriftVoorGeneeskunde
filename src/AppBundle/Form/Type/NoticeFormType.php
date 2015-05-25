<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NoticeFormType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('title')
			->add('message', 'textarea')
			->add('save', 'submit');
	}

	public function getName(){
		return 'NoticeForm';
	}
}