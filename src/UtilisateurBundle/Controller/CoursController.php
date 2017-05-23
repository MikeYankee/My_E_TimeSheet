<?php

namespace UtilisateurBundle\Controller;

use  Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\User_cours;
use ConnexionBundle\Entity\User;

class CoursController extends Controller
{
    public function signalerPresenceAction(Cours $leCours = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ETUDIANT'));
        $user = $this->getUser();

        // Si le cours est null et que c'est pas la bonne promotion et que le cours est valide, on retoune à la page visionner_feuille_presence
        if(is_null($leCours) or $leCours->getEts()->getPromotion() != $user->getPromotion() or $leCours->getEstValide()){
            return $this->redirect($this->generateUrl("visionner_feuille_presence"));
        }

        foreach($leCours->getLesEtudiants() as $user_cours)
        {
            if ($user == $user_cours->getLEtudiant())
            {
                $user_cours->setEtudiantPresent(true);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl("visionner_feuille_presence"));
    }

    public function signalerAbsenceEnseignantAction(Cours $leCours = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_DELEGUE'));
        $user = $this->getUser();

        // Si la cours est null et que c'est pas la bonne promotion et que le cours est valide, on retoune à la page visionner_feuille_presence
        if(is_null($leCours) or $leCours->getEts()->getPromotion() != $user->getPromotion() or $leCours->getEstValide()){
            return $this->redirect($this->generateUrl("visionner_feuille_presence"));
        }


        $leCours->setEnseignantAbsent(true);
        $leCours->setEstValide(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirect($this->generateUrl("visionner_feuille_presence"));
    }

    public function validerCoursAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_ENSEIGNANT'));
        $user = $this->getUser();


        return $this->render('UtilisateurBundle:Default:validation_cours.html.twig');

    }

    public function visionnerHistoriqueAbsenceAction()
    {

        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $user = $this->getUser();
        $lesAbsences = $this->container->get('absenceEtu')->absences($user);
        $totalAbsence = 0;
        foreach ($lesAbsences as $lAbsence)
        {
            $totalAbsence += 1.5;
        }

        return $this->render('UtilisateurBundle:Default:historique_absence.html.twig', array(
            'user' => $user,
            'lesAbsences' => $lesAbsences,
            'totalHeureAbsence' => $totalAbsence
        ));
    }

    public function visionnerDetailsHeuresAction()
    {
        return $this->render('UtilisateurBundle:Default:details_heures.html.twig');
    }
}
