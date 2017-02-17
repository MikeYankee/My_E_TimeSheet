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

    public function gestionPromoAction()
    {
        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig');
    }
}
