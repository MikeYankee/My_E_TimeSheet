<?php

namespace UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\User;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    "label" => "Nom :",
                    'required' => false,
            ))
            ->add('prenom', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Prénom :",
                'required' => false,
            ))
            ->add('email', 'email',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Adresse E-Mail :",
                'required' => false,
            ))
            ->add('tel', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Téléphone :",
                'required' => false,
            ))
            ->add('promotion', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Promotion :",
                'required' => false,
            ))
            ->add('motdepasseactuel', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Mot de passe actuel :",
                'required' => false,
            ))
            ->add('nouveaumotdepasse', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Nouveau mot de passe :",
                'required' => false,
            ))
            ->add('confirmationnouveaumotdepasse', 'text',
                array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                "label" => "Confirmez nouveau mot de passe :",
                'required' => false,
            ))
            ->add('Modifier', 'submit',
                array('attr' => array(
                    'class' => 'btn btn-primary')
            ))

            ->add('Annuler', 'reset',
                array('attr' => array(
                    'class' => 'btn btn-default')
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