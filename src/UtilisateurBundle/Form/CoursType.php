<?php

namespace UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\Metiere;

class CoursType extends AbstractType {

    public function __construct($horaires, $enseignants, $matieres, $types) {
        $this->horaires = $horaires;
        $this->enseignants = $enseignants;
        $this->matieres = $matieres;
        $this->types = $types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('horaire', 'choice', array(
                'choices' => $this->horaires,
                'multiple' => false,
                'expanded' => false,
                "label" => false,
                'required' => true,
            ))
            ->add('matiere', 'entity', array(
                'class' => 'ConnexionBundle\Entity\Matiere',
                'choices' => $this->matieres,
                'multiple' => false,
                'expanded' => false,
                "label" => false,
                'required' => true,
            ))
            ->add('enseignant', 'entity', array(
                'class' => 'ConnexionBundle\Entity\User',
                'choices' => $this->enseignants,
                'multiple' => false,
                'expanded' => false,
                "label" => false,
                'required' => true,
            ))
            ->add('type', 'entity', array(
                'class' => 'ConnexionBundle\Entity\Type',
                'choices' => $this->types,
                'multiple' => false,
                'expanded' => false,
                "label" => false,
                'required' => true,
            ));
    }

    public function getName() {
        return 'cours';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\Cours',
        ));
    }

}