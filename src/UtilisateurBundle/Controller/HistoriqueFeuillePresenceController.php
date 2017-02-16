<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HistoriqueFeuillePresenceController extends Controller
{
    public function historiqueFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_ets.html.twig');
    }
}
