<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GestionPromotionController extends Controller
{
    public function listePromosAction()
    {
        return $this->render('AdministrateurBundle:Default:liste_promos.html.twig');
    }

    public function gestionPromoAction(/*une promo*/)
    {
        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig');
    }

    public function ajoutEtudiantAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_utilisateur.html.twig');
    }

    public function ajoutMatiereAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_matiere.html.twig');
    }
}
