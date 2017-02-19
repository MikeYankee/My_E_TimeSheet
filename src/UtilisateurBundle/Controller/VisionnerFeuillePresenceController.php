<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VisionnerFeuillePresenceController extends Controller
{
    public function visionnerFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:visionner_ets.html.twig');
    }
}
