<?php

namespace UtilisateurBundle\Controller;

use  Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\User_cours;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Entity\User;
use ConnexionBundle\Entity\Type;
use ConnexionBundle\Entity\Matiere;
use Symfony\Component\Validator\Constraints\DateTime;

class CoursController extends Controller
{
    /**
     * @param Cours|null $leCours
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signalerPresenceAction(Cours $leCours = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ETUDIANT'));
        $user = $this->getUser();

        // Si le cours est null et que c'est pas la bonne promotion et que le cours est valide, on retoune à la page visionner_cours_jour
        if(is_null($leCours) or $leCours->getEts()->getPromotion() != $user->getPromotion() or $leCours->getEstValide()){
            return $this->redirect($this->generateUrl("visionner_cours_jour"));
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

        return $this->redirect($this->generateUrl("visionner_cours_jour", array(
            'user' => $user
        )));
    }

    /**
     * @param Cours|null $leCours
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signalerAbsenceEnseignantAction(Cours $leCours = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_DELEGUE'));
        $user = $this->getUser();

        // Si la cours est null et que c'est pas la bonne promotion et que le cours est valide, on retoune à la page visionner_feuille_presence
        if(is_null($leCours) or $leCours->getEts()->getPromotion() != $user->getPromotion() or $leCours->getEstValide()){
            return $this->redirect($this->generateUrl("visionner_cours_jour"));
        }


        $leCours->setEnseignantAbsent(true);
        $leCours->setEstValide(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirect($this->generateUrl("visionner_cours_jour", array(
            'user' => $user
        )));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validerCoursAction(Cours $leCours = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ENSEIGNANT'));
        $user = $this->getUser();

        if(is_null($leCours)/* or $leCours->getEnseignant() != $user*/){
            $this->addFlash('error', "Vous ne pouvez pas traiter ce cours.");
            return $this->redirect($this->generateUrl("visionner_ets_jour"));
        }

        $leCours->setEstValide(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();


        return $this->redirect($this->generateUrl("visionner_ets_jour"));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerHistoriqueAbsenceAction()
    {

        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $user = $this->getUser();
        $lesAbsences = $this->container->get('absenceEtu')->absences($user);
        $totalAbsence = 0;
        if(count($lesAbsences)>=1)
        {
            foreach ($lesAbsences as $lAbsence) {
                $totalAbsence += 1.5;
            }
        }
        return $this->render('UtilisateurBundle:Default:historique_absence.html.twig', array(
            'user' => $user,
            'lesAbsences' => $lesAbsences,
            'totalHeureAbsence' => $totalAbsence
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerDetailsHeuresAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_RESPONSABLE', "ROLE_SUPER_RESPONSABLE", "ROLE_CFA"));

        $user = $this->getUser();

        $types = $this->getDoctrine()->getRepository('ConnexionBundle:Type')->findAll();
        $types = array_map(function($t){
            return $t->getLibelle();
        }, $types);

        $mois_scolaire = array(
            "09"  => 'Septe',
            "10"  => 'Octob',
            "11"  => 'Novem',
            "12"  => 'Décem',
            "01"  => 'Janvi',
            "02"  => 'Févri',
            "03"  => 'Mars',
            "04"  => 'Avril',
            "05"  => 'Mai',
            "06" => 'Juin',
            "07" => 'Juill'
        );

        if($user->hasRole('ROLE_SUPER_RESPONSABLE') or $user->hasRole('ROLE_CFA'))
        {
            $promotion_cible = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findAll();
        }
        else
        {
            $promotion_cible = $user->getPromotionResp();
        }

        $recap_heures_matiere = $this->container->get('recapHeuresMatiere')->getNbHeuresCours($promotion_cible, $mois_scolaire);

        //dump($recap_heures_matiere); die;

        return $this->render('UtilisateurBundle:Default:details_heures.html.twig', array(
            'user' => $user,
            'recapHeuresMatiere' => $recap_heures_matiere,
            'moisScolaire' => $mois_scolaire,
            'types' => $types
        ));
    }
}
