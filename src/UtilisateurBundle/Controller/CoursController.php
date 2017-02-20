<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CoursController extends Controller
{
    public function signalerPresenceAction()
    {
        return $this->render('UtilisateurBundle:Default:signaler_presence.html.twig');
    }

    public function validerCoursAction()
    {
        return $this->render('UtilisateurBundle:Default:validation_cours.html.twig');
    }

    public function visionnerHistoriqueAbsenceAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_absence.html.twig');
    }

    public function visionnerDetailsHeuresAction()
    {
        return $this->render('UtilisateurBundle:Default:details_heures.html.twig');
    }
}
