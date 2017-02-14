<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccueilController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AdministrateurBundle:Default:accueil.html.twig');
    }
}
