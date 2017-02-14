<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SignalerPresenceController extends Controller
{
    public function signalerPresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:signaler_presence.html.twig');
    }
}
