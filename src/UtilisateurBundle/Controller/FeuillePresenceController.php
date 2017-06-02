<?php

namespace UtilisateurBundle\Controller;

use ConnexionBundle\Entity\User_cours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ConnexionBundle\Entity\ETimeSheet;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Tests\JsonResponseTest;
use UtilisateurBundle\Form\ETimeSheetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FeuillePresenceController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creerFeuillePresenceAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_DELEGUE'));

        $user = $this->getUser();

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

                    foreach ($user->getPromotion()->getLesEtudiants() as $etu) {
                        $user_cours = new User_cours($etu, $cours);
                        $em->persist($user_cours);
                    }
                }

                $em->flush();
            }
            else{
                $this->addFlash('error', "Il ne peut pas y avoir plusieurs cours à la même heure.");
            }
            return $this->redirect($this->generateUrl("signaler_presence"));
        }

        return $this->render('UtilisateurBundle:Default:creation_ets.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerCoursJourAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $user = $this->getUser();
        $lEts = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->getEtsDuJour();

        $lesCours = null;
        $lesCoursNonValide = array();
        if(isset($lEts[0])) { //L'ETS existe ?
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerETSJourAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_USER'));

        $user = $this->getUser();
        $lEts = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->getEtsDuJour();

        $lesCours = null;
        $lesCoursNonValide = array();
        $etudiantsPresents = array();
        $etudiantsAbsents = array();
        $nbMaxEtudiants = count($user->getPromotion()->getLesEtudiants());
        if(isset($lEts[0])) { //L'ETS existe ?
            $lesCours = $lEts[0]->getLesCours();
            foreach ($lesCours as $leCours) {
                if (!$leCours->getEstValide()) {
                    $lesCoursNonValide[] = $leCours;

                }
                foreach ($leCours->getLesEtudiants() as $lEtudiant)
                {
                    if ($lEtudiant->getEtudiantPresent() == 1)
                    {
                        $etudiantsPresents[] = $lEtudiant->getLEtudiant();
                    }
                    else
                    {
                        $etudiantsAbsents[] = $lEtudiant->getLEtudiant();
                    }

                }
            }
        }

        return $this->render('UtilisateurBundle:Default:visionner_ets.html.twig', array(
            'user' => $user,
            'lesCours' => $lesCours,
            'etudiantsPresents' => $etudiantsPresents,
            'etudiantsAbsents' => $etudiantsAbsents,
            'nbMaxEtudiants' => $nbMaxEtudiants
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerHistoriqueAbsencesPromosAction()
    {
        return $this->render('UtilisateurBundle:Default:recap_absences.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visionnerHistoriqueFactureAction()
    {
        return $this->render('UtilisateurBundle:Default:historique_facture.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEnseignantPourMatiereAction(Request $request){
            $id = $request->get('id');

            $matiere = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->find($id);

            $lesEns = $matiere->getLesEnseignants();
            $return = array();
            foreach ($lesEns as $ens) {
                $return[] = array('id' => $ens->getId(),'nom' => $ens->getPrenom()." ".$ens->getNom());
            }

            return new JsonResponse(array('data' => json_encode($return)));


    }

}
