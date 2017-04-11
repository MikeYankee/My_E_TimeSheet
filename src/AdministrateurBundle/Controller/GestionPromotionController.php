<?php

namespace AdministrateurBundle\Controller;

use ConnexionBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdministrateurBundle\Form\MatiereType;
use AdministrateurBundle\Form\PromotionType;
use ConnexionBundle\Entity\Promotion;

class GestionPromotionController extends Controller
{
    public function listePromosAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $lesPromotions = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findAll();
        return $this->render('AdministrateurBundle:Default:liste_promos.html.twig', array(
            'lesPromotions' => $lesPromotions,
        ));
    }

    public function gestionPromoAction(Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirect($this->generateUrl("liste_promotions"));
        }

        $les_etudiants = $promotion->getLesUtilisateurs();
        $les_matieres = $promotion->getLesMatieres();


        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig', array(
            'lesEtudiants' => $les_etudiants,
            'lesMatieres' => $les_matieres,
        ));
    }

    /**
     * Fonction qui sert à ajouter une promotion
     * @param Request $requestx
     * @return ...
     */
    public function ajoutPromoAction(Request $request)
    {
        //Autorisation d'accès pour les admins uniquement
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        //$user contient l'utilisateur qui est connecté
        $user = $this->getUser();

        // On vérifie que la promo n'existe pas déjà (nom unique)
        //$promos = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->find($promo);

        //$lesResponsables contient les utilisateurs qui ont le rôle Responsable

        $lesResponsables = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_RESPONSABLE');

        //Objet promotion
        $promotion = new Promotion();

        //l'objet $form est créé avec en paramètre le FormType de l'objet qu'on veut créer/modifier.. et l'objet qui sera inséré dans la BDD à la fin
        $form = $this->createForm(new PromotionType($lesResponsables), $promotion);

        //Code qui s'exécute à la réception du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) { //Si tous les champs sont valides
                $em = $this->getDoctrine()->getManager();
                $em->persist($promotion); //signale la création d'un nouvel objet $matiere
                $em->flush(); //Insertion dans la BDD

                return $this->redirect($this->generateUrl("liste_promotions")); // Redirection après l'ajout

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        //Affichage de la vue ajout_promotion.html.twig avec le formulaire en paramètre

        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig', array(

            'form' => $form->createView(),

        ));

    }

    public function ajoutEtudiantAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_utilisateur.html.twig');
    }

    public function ajoutMatiereAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirectToRoute("gerer_promotion", array('id' => $promotion->getId()));
        }

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');

        $matiere = new Matiere();
        $matiere->setPromo($promotion);

        $form = $this->createForm(new MatiereType($les_enseignants), $matiere);


        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($matiere);
                $em->flush();

                return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId())));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_matiere.html.twig', array(
            'form' => $form->createView(),
            'matiere' => $matiere
        ));
    }

    public function modificationMatiereAction(Request $request, Matiere $matiere = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        if(is_null($matiere)){ //la matière n'existe pas
            return $this->redirectToRoute("liste_promotions");
        }

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');
        $form = $this->createForm(new MatiereType($les_enseignants), $matiere);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute("gerer_promotion", array('id' => $matiere->getPromotion()->getId()));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:modification_matiere.html.twig', array(
            'form' => $form->createView(),
            'matiere' => $matiere
        ));
    }

    public function modificationPromotionAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        if(is_null($promotion)){
            //return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $matiere->getPromotion()->getId())));
            //return $this->redirectToRoute("gerer_promotion", array('id' => $matiere->getPromotion()->getId()));
        }

        $les_responsables = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_RESPONSABLE');
        $form = $this->createForm(new PromotionType($les_responsables), $promotion);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute("liste_promotions");

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:modification_promotion.html.twig', array(
            'form' => $form->createView(),
            'promotion' => $promotion
        ));
    }
}
