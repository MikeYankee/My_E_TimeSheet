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

    public function ajoutMatiereAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirect($this->generateUrl("gerer_promotion"));
        }

        $lesEnseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');

        $matiere = new Matiere();
        $matiere->setPromo($promotion);

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
    public function modificationMatiereAction(Request $request, Matiere $matiere = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        if(is_null($matiere)){
            return $this->redirect($this->generateUrl("gerer_promotion"));
        }

        $lesEnseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole('ROLE_ENSEIGNANT');
        $form = $this->createForm(new MatiereType($lesEnseignants), $matiere);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
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
