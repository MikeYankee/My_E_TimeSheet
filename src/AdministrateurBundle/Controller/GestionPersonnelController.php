<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GestionPersonnelController extends Controller
{
    public function gestionPersonnelAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_utilisateur.html.twig');
    }
}
