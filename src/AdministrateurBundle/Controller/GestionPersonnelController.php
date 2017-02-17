<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GestionPersonnelController extends Controller
{
    public function listePersonnelAction()
    {
        return $this->render('AdministrateurBundle:Default:liste_personnel.html.twig');
    }
}
