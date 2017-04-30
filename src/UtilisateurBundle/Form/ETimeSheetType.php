<?php

namespace UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use UtilisateurBundle\Form\CoursType;

class ETimeSheetType extends AbstractType {

    public function __construct($horaires, $enseignants, $matieres, $type) {
        $this->horaires = $horaires;
        $this->enseignants = $enseignants;
        $this->matieres = $matieres;
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('lesCours', CollectionType::class, array(
            'entry_type' => new CoursType($this->horaires, $this->enseignants, $this->matieres, $this->type),
            'allow_add'    => true,
            'label' => ''
        ));
    }

    public function getName() {
        return 'ets';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\ETimeSheet',
        ));
    }

}