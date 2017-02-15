<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProfilController extends Controller
{
    public function profilAction()
    {
        return $this->render('UtilisateurBundle:Default:profil.html.twig');
    }
}
