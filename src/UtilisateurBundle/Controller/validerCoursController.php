<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ValiderCoursController extends Controller
{
    public function validerCoursAction()
    {
        return $this->render('UtilisateurBundle:Default:validation_cours.html.twig');
    }
}
