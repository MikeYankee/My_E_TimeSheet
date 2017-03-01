<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FeuillePresenceController extends Controller
{
    public function creerFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:creation_ets.html.twig');
    }

    public function historiqueFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_ets.html.twig');
    }

    public function visionnerFeuillePresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:visionner_ets.html.twig');
    }

    public function visionnerHistoriqueAbsencesPromosAction()
    {
        return $this->render('UtilisateurBundle:Default:recap_absences.html.twig');
    }

    public function visionnerHistoriqueFacture()
    {
        return $this->render('UtilisateurBundle:Default:historique_facture.html.twig');
    }

}
