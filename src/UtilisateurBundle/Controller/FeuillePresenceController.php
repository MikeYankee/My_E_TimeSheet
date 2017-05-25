<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ConnexionBundle\Entity\ETimeSheet;
use UtilisateurBundle\Form\ETimeSheetType;
use Symfony\Component\HttpFoundation\Request;
class FeuillePresenceController extends Controller
{
    public function creerFeuillePresenceAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_DELEGUE'));

        $delegue = $this->getUser();
        $les_ets = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->getEtsDuJour();

        if(isset($les_ets[0])){ //L'ETS est déja crée pour cette journée
            $this->addFlash('error', "La feuille du jour est déjà créée");
            return $this->redirectToRoute("signaler_presence");
            //TODO : si existe, rediriger vers la page de modif de l'ets
        }

        $les_horaires = array('8:30'=>'8:30','10:00'=>'10:00','10:15'=>'10:15','11:45'=>'11:45','12:00'=>'12:00','13:00'=>'13:00','14:30'=>'14:30','14:45'=>'14:45','16:15'=>'16:15','16:30'=>'16:30','18:00'=>'18:00');
        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT'));

        $les_matieres = $delegue->getPromotion()->getLesMatieres();
        $les_types = $this->getDoctrine()->getRepository('ConnexionBundle:Type')->findAll();

        $ets = new ETimeSheet();
        $promo = $delegue->getPromotion();
        $ets->setPromotion($promo);
        //$promo->setLesETS($ets);

        $form = $this->createForm(new ETimeSheetType($les_horaires, $les_enseignants, $les_matieres, $les_types), $ets);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On récupère tous les horaires des cours
            $horaires = array();
            foreach ($ets->getLesCours() as $cours) {
                $horaires[] = $cours->getHoraire();
            }
            $horaires_uniques = array_unique($horaires); // on enlève les doublons

            //On compare la taille des deux tableaux pour savoir s'il y a eu des doublons supprimés
            if(count($horaires) == count($horaires_uniques)){ //pas de doublons
                $em = $this->getDoctrine()->getManager();
                $em->persist($ets);

                foreach ($ets->getLesCours() as $cours) {
                    $cours->setEts($ets);
                }
                $em->flush();
            }
            else{
                $this->addFlash('error', "Il ne peut pas y avoir plusieurs cours à la même heure.");
            }
            return $this->redirect($this->generateUrl("signaler_presence"));
        }

        return $this->render('UtilisateurBundle:Default:creation_ets.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function historiqueFeuillePresenceAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $user = $this->getUser();
        $lesEts = $this->container->get('ets')->validees($user->getPromotion());

        //echo $user->getPromotion()->getLibelle(); die;

        /*foreach ($lesEts as $lEts)
        {
            echo $lEts; die;
        }*/

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

        $lesCours = null;
        $lesCoursNonValide = array();
        if(isset($lEts[0])) { //L'ETS iexste ?
            $lesCours = $lEts[0]->getLesCours();

            foreach ($lesCours as $leCours) {
                if (!$leCours->getEstValide()) {
                    $lesCoursNonValide[] = $leCours;
                }
            }
        }
        return $this->render('UtilisateurBundle:Default:signaler_presence.html.twig', array(
            'user' => $user,
            'lesCours' => $lesCoursNonValide
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
