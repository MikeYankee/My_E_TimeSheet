<?php

namespace AdministrateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ConnexionBundle\Entity\Matiere;

class MatiereType extends AbstractType {

    public function __construct($enseignants) {
        $this->enseignants = $enseignants;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('libelle', 'text', array(
                "label" => "Libellé :"
            ))
            ->add('nbHeuresMaquetteCours', 'integer', array(
                "label" => "Nombre d'heures de cours :",
                'required' => true,
            ))
            ->add('nbHeuresMaquetteTD', 'integer', array(
                "label" => "Nombre d'heures de TD :",
                'required' => true,
            ))
            ->add('nbHeuresMaquetteSoutenance', 'integer', array(
                "label" => "Nombre d'heures de soutenance :",
                'required' => true,
            ))
            ->add('nbHeuresMaquetteExam', 'integer', array(
                "label" => "Nombre d'heures d'examen :",
                'required' => true,
            ))
            ->add('lesEnseignants', 'entity', array(
                'class' => 'ConnexionBundle\Entity\User',
                'choices' => $this->enseignants,
                'multiple' => true,
                'expanded' => false,
                "label" => "Enseignant(s) :",
                'required' => false,
            ));
    }

    public function getName() {
        return 'matiere';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\Matiere',
        ));
    }

}