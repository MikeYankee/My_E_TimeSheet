<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

    /**
     * Fonction qui sert à ajouter une promotion
     * @param Request $request
     * @return ...
     */
    public function ajoutPromoAction(Request $request)
    {
        //Affichage de la vue ajout_promotion.html.twig
        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig');
        //Autorisation d'accès de ?? pour les admins
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        //$user contient ??
        $user = $this->getUser();

        // Check if promo don't exist to add this promo
        //$promos = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->find($promo);

        //$lesEnseignants contient les utilisateurs qui ont le rôle Enseignant
        $lesEnseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');

        //l'objet $form est créé avec ... ??
        $form = $this->createForm(new MatiereType($lesEnseignants), $matiere);

        //code qui vérifie et balance tout dans la bdd j'imagine ;)
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

        //Affichage de la vue ajout_promotion.html.twig
        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function ajoutEtudiantAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_utilisateur.html.twig');
    }

    public function ajoutMatiereAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_matiere.html.twig');
    }
}
