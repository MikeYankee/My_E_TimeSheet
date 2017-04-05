<?php

namespace AdministrateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\Matiere;

class EtudiantType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', 'text', array(
                "label" => "Nom :"
            ))
            ->add('prenom', 'text', array(
                "label" => "Prénom :"
            ))
            ->add('email', 'email', array(
                "label" => "Email :",
                'required' => true,
            ));
    }

    public function getName() {
        return 'user';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\User',
        ));
    }

}