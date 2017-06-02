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
    public function validerCoursAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_ENSEIGNANT'));
        $user = $this->getUser();


        return $this->render('UtilisateurBundle:Default:validation_cours.html.twig', array(
            'user' => $user
        ));

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

        $this->denyAccessUnlessGranted(array('ROLE_RESPONSABLE'));

        $user = $this->getUser();

        $recap_heures_matiere = array();

        $mois_scolaire = array(
            1  => 'Septembre',
            2  => 'Octobre',
            3  => 'Novembre',
            4  => 'Décembre',
            5  => 'Janvier',
            6  => 'Février',
            7  => 'Mars',
            8  => 'Avril',
            9  => 'Mai',
            10 => 'Juin',
            11 => 'Juillet'
        );

        if($user->hasRole('ROLE_SUPER_ADMIN'))
        {
            $promotion_cible = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findAll();
        }
        else
        {
            $promotion_cible = $user->getPromotionResp();
        }

        foreach ($promotion_cible as $promotion)
        {
            $recap_heures_matiere[$promotion->getId()]["promotion"]= $promotion;
            $lesMatieres = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->findBy($promotion);

            foreach ($lesMatieres as $laMatiere)
            {
                $nbHeuresMaquettesCours = $laMatiere->getNbHeuresMaquetteCours();
                $nbHeuresMaquettesTD = $laMatiere->getNbHeuresMaquetteTD();
                $nbHeuresMaquettesExam = $laMatiere->getNbHeuresMaquetteExam();
                $nbHeuresMaquettesSoutenance = $laMatiere->getNbHeuresMaquetteSoutenance();

                $mois = new DateTime('2017/09/01');
                $mois = $mois->format("Y-m");

                for ($i=0;$i<11;$i++)
                {
                    $nbHeures = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->getNbHeures($mois,$promotion,$laMatiere);
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["matiere"] = $laMatiere;
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["nbHeures"]= $nbHeures;
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["nbHeuresMaquettesCours"]= $nbHeuresMaquettesCours;
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["nbHeuresMaquettesTD"]= $nbHeuresMaquettesTD;
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["nbHeuresMaquettesExam"]= $nbHeuresMaquettesExam;
                    $recap_heures_matiere[$promotion->getId()][$laMatiere->getId()]["nbHeuresMaquettesSoutenance"]= $nbHeuresMaquettesSoutenance;
                }
            }
        }

        return $this->render('UtilisateurBundle:Default:details_heures.html.twig', array(
            'user' => $user,
            'recapHeuresMatiere' => $recap_heures_matiere
        ));
    }
}
