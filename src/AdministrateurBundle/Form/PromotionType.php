<?php

namespace AdministrateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\Promotion;

class PromotionType extends AbstractType {

    public function __construct($lesResponsables) {

        $this->lesResponsables = $lesResponsables;

    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('libelle', 'text', array(
                "label" => "Libellé :"
            ))
            ->add('lesResponsables', 'entity', array(
                'class' => 'ConnexionBundle\Entity\User',
                'choices' => $this->lesResponsables,
                'multiple' => true,
                'expanded' => false,
                "label" => "Responsable(s) :",
                'required' => false,
            ));
    }

    public function getName() {
        return 'promotion';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\Promotion',
        ));
    }

}