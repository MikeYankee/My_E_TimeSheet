<?php

namespace AdministrateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConventionType extends AbstractType {

    public function __construct($type) {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('prixheure', 'number', array(
                "label" => "Prix / heure :",
                'required' => true,
            ))
            ->add('type', 'entity', array(
                'class' => 'ConnexionBundle\Entity\Type',
                'choices' => $this->type,
                'multiple' => false,
                'expanded' => false,
                "label" => "Type :",
                'required' => true,
            ));
    }

    public function getName() {
        return 'convention';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\Convention',
        ));
    }

}