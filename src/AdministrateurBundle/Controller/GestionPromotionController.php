<?php

namespace AdministrateurBundle\Controller;

use ConnexionBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdministrateurBundle\Form\MatiereType;
use AdministrateurBundle\Form\EtudiantType;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Entity\User;

class GestionPromotionController extends Controller
{
    public function listePromosAction()
    {
        return $this->render('AdministrateurBundle:Default:liste_promos.html.twig');
    }

    public function gestionPromoAction(Promotion $promotion)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirect($this->generateUrl("liste_promotions"));
        }

        $les_etudiants = $promotion->getLesEtudiants();
        $les_matieres = $promotion->getLesMatieres();


        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig', array(
            'lesEtudiants' => $les_etudiants,
            'lesMatieres' => $les_matieres,
        ));
    }

    public function ajoutPromoAction()
    {
        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig');
    }

    public function ajoutEtudiantAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $userManager = $this->container->get('fos_user.user_manager');
        $etudiant = $userManager->createUser();

        $form = $this->createForm(new EtudiantType(), $etudiant);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $username = substr($etudiant->getPrenom(),0,1)."".substr($etudiant->getNom(),0,strlen($etudiant->getNom()));

                $role = $request->get("role");
                if($role == "on"){
                    $etudiant->addRole("ROLE_ETUDIANT");
                }
                else{
                    $etudiant->addRole("ROLE_DELEGUE");
                    $etudiant->addRole("ROLE_ETUDIANT");
                }
                $etudiant->addRole($role);

                $etudiant->setUsername($username);
                $etudiant->setPlainPassword($username);
                $etudiant  ->setEnabled(true);

                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($etudiant, true);
                //$em->persist($etudiant);
                $em->flush();

                return $this->redirect($this->generateUrl("gerer_promotion"));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_etudiant.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeEtudiantAction()
    {
        $liste_etudiant = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ETUDIANT'));

        return $this->render('AdministrateurBundle:Default:liste_etudiant.html.twig', array(
            'liste_etudiant' => $liste_etudiant
        ));
    }

    public function ajoutMatiereAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirectToRoute("gerer_promotion", array('id' => $promotion->getId()));
        }

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT'));

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

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT'));
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
}
