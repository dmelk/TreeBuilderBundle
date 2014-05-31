<?php

namespace Melk\TreeBuilderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for uploading tree data files
 *
 * @author melk
 */
class TreeFileType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('file', 'file', ['label' => 'File']);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
    
    public function getName() {
        return 'tree_file_type';
    }
}

?>
