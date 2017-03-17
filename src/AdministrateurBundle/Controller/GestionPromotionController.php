<?php

namespace AdministrateurBundle\Controller;

use ConnexionBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdministrateurBundle\Form\MatiereType;
use ConnexionBundle\Entity\Promotion;

class GestionPromotionController extends Controller
{
    public function listePromosAction()
    {
        return $this->render('AdministrateurBundle:Default:liste_promos.html.twig');
    }

    public function gestionPromoAction(/*une promo*/)
    {
        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig');
    }

    public function ajoutPromoAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig');
    }

    public function ajoutEtudiantAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_utilisateur.html.twig');
    }

    public function ajoutMatiereAction(Request $request, Promotion $promo)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        // Check if promo exist to add matiere
        //$promos = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->find($promo);

        $lesEnseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');

        $matiere = new Matiere();
        $matiere->setPromo($promo);

        $form = $this->createForm(new MatiereType($lesEnseignants), $matiere);


        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($matiere);
                $em->flush();

                return $this->redirect($this->generateUrl("gerer_promotion"));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_matiere.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
