<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VisionnerHistoriqueAbsenceController extends Controller
{
    public function visionnerHistoriqueAbsenceAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_absence.html.twig');
    }
}
