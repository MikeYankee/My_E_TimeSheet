<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CreerFeuillePresenceController extends Controller
{
    public function creerFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:creation_ets.html.twig');
    }
}
