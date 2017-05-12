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
        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $lesEts = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->findAll();
        $user = $this->getUser();

        return $this->render('UtilisateurBundle:Default:historique_ets.html.twig', array(
            'user' => $user,
            'lesEts' => $lesEts
        ));
    }

    public function visionnerFeuillePresenceAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_ETUDIANT'));

        $user = $this->getUser();
        $lEts = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->getEtsDuJour();

        if(isset($lEts[0])){ //L'ETS existe ?
            $lesCours = $lEts[0]->getLesCours();
        }

        return $this->render('UtilisateurBundle:Default:signaler_presence.html.twig', array(
            'user' => $user,
            'lesCours' => $lesCours
        ));

    }

    public function visionnerHistoriqueAbsencesPromosAction()
    {
        return $this->render('UtilisateurBundle:Default:recap_absences.html.twig');
    }

    public function visionnerHistoriqueFactureAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_facture.html.twig');
    }

}
