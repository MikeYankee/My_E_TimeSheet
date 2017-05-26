<?php

namespace AdministrateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\Matiere;

class PersonnelType extends AbstractType {

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
            ))
            ->add('tel', 'text', array(
                "label" => "Téléphone :",
                'required' => false,
            ))
            ->add('roles', 'choice', array(
                'choices' => array(
                    'ROLE_ENSEIGNANT' => 'Enseignant',
                    'ROLE_RESPONSABLE' => 'Responsable',
                    'ROLE_SUPER_RESPONSABLE' => 'Super Responsable',
                    'ROLE_CFA' => 'CFA',
                    'ROLE_SECRETAIRE' => 'Secrétaire',
                    'ROLE_ADMIN' => 'Administrateur',
                ),
                'multiple' => true,
                'expanded' => true,
                "label" => "Rôle(s) :",
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