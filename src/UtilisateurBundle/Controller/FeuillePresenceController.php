<?php

namespace UtilisateurBundle\Controller;

use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ConnexionBundle\Entity\ETimeSheet;
use UtilisateurBundle\Form\ETimeSheetType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FeuillePresenceController extends Controller
{
    public function creerFeuillePresenceAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_DELEGUE'));

        $delegue = $this->getUser();
        $date = new \DateTime();
        $les_ets = $this->getDoctrine()->getRepository('ConnexionBundle:ETimeSheet')->findBy(array('date' => $date, 'promotion' => $delegue->getPromotion()));

        if(isset($les_ets[0])){ //L'ETS est déja crée pour cette journée
            return $this->redirectToRoute("signaler_presence");
        }

        $les_horaires = array('8:30','10:00','10:15','11:45','12:00','13:00','14:30','14:45','16:15','16:30','18:00');
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($ets);

            foreach ($ets->getLesCours() as $cours) {
                $cours->setEts($ets);
                //$ets->setLesCours($cours);
            }
            $em->flush();
        }

        return $this->render('UtilisateurBundle:Default:creation_ets.html.twig', array(
            'form' => $form->createView()
        ));
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
        return $this->render('UtilisateurBundle:Default:visionner_ets.html.twig');
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
