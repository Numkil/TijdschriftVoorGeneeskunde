<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageContentFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('content', 'ckeditor', array(
                'config' => array(
                    'toolbar' => array(
                        array(
                            'name'  => 'document',
                            'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Print', '-', 'Templates'),
                        ),
                        array(
                            'name'  => 'clipboard',
                            'items' => array('Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo'),
                        ),
                        array(
                            'name'  => 'basicstyles',
                            'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                        ),
                        array(
                            'name' => 'fonts',
                            'items' => array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
                        ),
                        array(
                            'name' => 'links',
                            'items' => array('Link', 'Unlink', 'Anchor'),
                        ),
                    ),
                    'uiColor' => '#ffffff',
                ),
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PageContent',
        ));
    }

    public function getName(){
        return 'pagecontent';
    }
}
