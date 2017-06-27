<?php

namespace AdministrateurBundle\Controller;

use ConnexionBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdministrateurBundle\Form\MatiereType;
use AdministrateurBundle\Form\PromotionType;
use AdministrateurBundle\Form\EtudiantType;
use AdministrateurBundle\Form\ConventionType;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Entity\User;
use ConnexionBundle\Entity\Convention;
use ConnexionBundle\Entity\Type;

/**
 * Class GestionPromotionController
 * @package AdministrateurBundle\Controller
 */
class GestionPromotionController extends Controller
{

    /**
     * @return Response
     */
    public function listePromosAction()
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        $lesPromotions = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findBy(array(), array('libelle' => 'ASC'));

        return $this->render('AdministrateurBundle:Default:liste_promos.html.twig', array(
            'lesPromotions' => $lesPromotions,
            'user' => $user
        ));
    }

    /**
     * @param Promotion|null $promotion
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function gestionPromoAction(Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirect($this->generateUrl("liste_promotions"));
        }

        $les_etudiants = $promotion->getLesEtudiants();
        $les_matieres = $promotion->getLesMatieres();
        $les_conventions = $promotion->getLesConventions();
        $les_responsables = $promotion->getLesResponsables();

        if(is_null($les_responsables)){
            $les_responsables = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_RESPONSABLE'));
        }

        return $this->render('AdministrateurBundle:Default:gestion_promo.html.twig', array(
            'lesEtudiants' => $les_etudiants,
            'lesMatieres' => $les_matieres,
            'promotion' => $promotion,
            //'lesResponsables' => $les_responsables,
            'lesConventions' => $les_conventions,
            'user' => $user
        ));
    }

    /**
     * Fonction qui sert à ajouter une promotion
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajoutPromoAction(Request $request)
    {
        //Autorisation d'accès pour les admins uniquement
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        //$user contient l'utilisateur qui est connecté
        $user = $this->getUser();

        // On vérifie que la promo n'existe pas déjà (nom unique)
        //$promos = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->find($promo);

        $lesResponsables = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_RESPONSABLE', 'ROLE_SUPER_RESPONSABLE'));
        //Pour la vérification des doublons
        $libellesPromotionsExistants = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findAll();

        $promotion = new Promotion();

        //l'objet $form est créé avec en paramètre le FormType de l'objet qu'on veut créer/modifier.. et l'objet qui sera inséré dans la BDD à la fin
        $form = $this->createForm(new PromotionType($lesResponsables), $promotion);

        //Code qui s'exécute à la réception du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) { //Si tous les champs sont valides
                foreach ($libellesPromotionsExistants as $libelle)
                {
                    if(strtolower($promotion->getLibelle()) == strtolower($libelle->getLibelle()))
                    {
                        dump("jj");die;
                        $this->addFlash('error', "La promotion " . $promotion->getLibelle() . " existe déjà !");
                        return $this->redirect($this->generateUrl("liste_promotions")); // Redirection après l'erreur
                    }
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($promotion); //signale la création d'un nouvel objet $matiere
                $em->flush(); //Insertion dans la BDD
                $this->addFlash('notice', "Promotion " . $promotion->getLibelle() . " ajoutée !");
                return $this->redirect($this->generateUrl("liste_promotions")); // Redirection après l'ajout
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        //Affichage de la vue ajout_promotion.html.twig avec le formulaire en paramètre
        return $this->render('AdministrateurBundle:Default:ajout_promotion.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));

    }

    /**
     * @param Request $request
     * @param Promotion|null $promotion
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajoutEtudiantAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        $userManager = $this->container->get('fos_user.user_manager');
        $etudiant = $userManager->createUser();

        //Pour la vérification des doublons
        $etudiantsExistants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findAll();

        $form = $this->createForm(new EtudiantType(), $etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /*foreach ($etudiantsExistants as $etudiantExistant)
                {
                    if(strtolower($etudiant->getNom()) == strtolower($etudiantExistant->getNom()) and strtolower($etudiant->getPrenom()) == strtolower($etudiantExistant->getPrenom()))
                    {
                        $this->addFlash('error', "L'étudiant " . $etudiant->getPrenom() . " " . $etudiant->getNom(). " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId()))); // Redirection après l'erreur
                    }
                }*/
                $username = substr(strtolower($etudiant->getPrenom()), 0, 1) . "" . substr(strtolower($etudiant->getNom()), 0, strlen(strtolower($etudiant->getNom())));

                $role = $request->get("role");
                if ($role == "on") {
                    $etudiant->addRole("ROLE_ETUDIANT");
                } else {
                    $etudiant->addRole("ROLE_DELEGUE");
                    $etudiant->addRole("ROLE_ETUDIANT");
                }
                $etudiant->setPromotion($promotion);
                $etudiant->setUsername($username);
                $etudiant->setPlainPassword($username);
                $etudiant->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($etudiant, true);
                //$em->persist($etudiant);
                $em->flush();
                $this->addFlash('notice', "Etudiant " . $etudiant->getPrenom() ." ". $etudiant->getNom() . " ajouté !");
                return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId())));
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_etudiant.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param User|null $etudiant
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modificationEtudiantAction(Request $request, User $etudiant = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        if(is_null($etudiant)){ //l'étudiant n'existe pas
            return $this->redirectToRoute("gerer_promotions");
        }
        $userManager = $this->container->get('fos_user.user_manager');

        //Pour la vérification des doublons
        $etudiantsExistants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findAll();

        $form = $this->createForm(new EtudiantType(), $etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /*foreach ($etudiantsExistants as $etudiantExistant)
                {
                    if(strtolower($etudiant->getNom()) == strtolower($etudiantExistant->getNom()) and strtolower($etudiant->getPrenom()) == strtolower($etudiantExistant->getPrenom()))
                    {
                        $this->addFlash('error', "L'étudiant " . $etudiant->getPrenom() . " " . $etudiant->getNom(). " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $etudiant->getPromotion()->getId()))); // Redirection après l'erreur
                    }
                }*/
                $username = substr($etudiant->getPrenom(), 0, 1) . "" . substr($etudiant->getNom(), 0, strlen($etudiant->getNom()));
                $role = $request->get("role");
                if ($role == "on") {
                    if ($etudiant->hasRole("ROLE_DELEGUE")){
                        $etudiant->removeRole("ROLE_DELEGUE");
                        $etudiant->addRole("ROLE_ETUDIANT");
                    }else {
                        $etudiant->addRole("ROLE_ETUDIANT");
                    }

                } else {
                    if(!$etudiant->hasRole("ROLE_DELEGUE")){
                        $etudiant->addRole("ROLE_DELEGUE");
                    }
                }
                $etudiant->setUsername($username);
                $etudiant->setPlainPassword($username);
                $etudiant->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($etudiant, true);
                $em->flush();
                $this->addFlash('notice', "Etudiant " . $etudiant->getPrenom() ." ". $etudiant->getNom() . " modifié !");
                return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $etudiant->getPromotion()->getId())));
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }
        return $this->render('AdministrateurBundle:Default:modification_etudiant.html.twig', array(
            'form' => $form->createView(),
            'etudiant' => $etudiant,
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param Promotion|null $promotion
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajoutMatiereAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if(is_null($promotion)){
            return $this->redirectToRoute("gerer_promotion", array('id' => $promotion->getId()));
        }

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT'));

        //Pour la vérification des doublons
        $matieresExistantes = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->findBy(array('promotion' =>$promotion));

        $matiere = new Matiere();
        $matiere->setPromo($promotion);

        $form = $this->createForm(new MatiereType($les_enseignants), $matiere);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                foreach ($matieresExistantes as $matiereExistante)
                {
                    if(strtolower($matiere->getLibelle()) == strtolower($matiereExistante->getLibelle()))
                    {
                        $this->addFlash('error', "La matière " . $matiere->getLibelle() . " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId()))); // Redirection après l'erreur
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($matiere);
                $em->flush();
                $this->addFlash('notice', "Matière " . $matiere->getLibelle() ." ajoutée !");
                return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId())));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_matiere.html.twig', array(
            'form' => $form->createView(),
            'matiere' => $matiere,
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param Matiere|null $matiere
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modificationMatiereAction(Request $request, Matiere $matiere = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        if(is_null($matiere)){ //la matière n'existe pas
            return $this->redirectToRoute("liste_promotions");
        }

        $les_enseignants = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT'));

        //Pour la vérification des doublons
        $matieresExistantes = $this->getDoctrine()->getRepository('ConnexionBundle:Matiere')->findBy(array('promotion' => $matiere->getPromotion()));

        $form = $this->createForm(new MatiereType($les_enseignants), $matiere);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                foreach ($matieresExistantes as $matiereExistante)
                {
                    if(strtolower($matiere->getLibelle()) == strtolower($matiereExistante->getLibelle()))
                    {
                        $this->addFlash('error', "La matière " . $matiere->getLibelle() . " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $matiere->getPromotion()->getId()))); // Redirection après l'erreur
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('notice', "Matière " . $matiere->getLibelle() ." modifiée !");
                return $this->redirectToRoute("gerer_promotion", array('id' => $matiere->getPromotion()->getId()));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:modification_matiere.html.twig', array(
            'form' => $form->createView(),
            'matiere' => $matiere,
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param Promotion|null $promotion
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modificationPromotionAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        if(is_null($promotion)){
            //return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $matiere->getPromotion()->getId())));
            //return $this->redirectToRoute("gerer_promotion", array('id' => $matiere->getPromotion()->getId()));
        }

        $les_responsables = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_RESPONSABLE'));

        //Pour la vérification des doublons
        $promotionsExistantes = $this->getDoctrine()->getRepository('ConnexionBundle:Promotion')->findAll();

        $form = $this->createForm(new PromotionType($les_responsables), $promotion);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /*foreach ($promotionsExistantes as $promotionExistante)
                {
                    if($promotion->getLibelle() == $promotionExistante->getLibelle())
                    {
                        $this->addFlash('error', "La promotion " . $promotion->getLibelle() . " existe déjà !");
                        return $this->redirectToRoute("liste_promotions"); // Redirection après l'erreur
                    }
                }*/

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('notice', "Promotion " . $promotion->getLibelle() ." modifiée !");
                return $this->redirectToRoute("liste_promotions");

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:modification_promotion.html.twig', array(
            'form' => $form->createView(),
            'promotion' => $promotion,
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param Promotion|null $promotion
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajoutConventionAction(Request $request, Promotion $promotion = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        // Si la promo est null, c'est qu'elle n'existe pas dans la BDD, on retoune à la page de gestion promo
        if (is_null($promotion)) {
            return $this->redirectToRoute("gerer_promotion", array('id' => $promotion->getId()));
        }

        $lesTypes = $this->getDoctrine()->getRepository('ConnexionBundle:Type')->findAll();

        //Pour la vérification des doublons
        $conventionsExistantes = $this->getDoctrine()->getRepository('ConnexionBundle:Convention')->findBy(array('promotion' => $promotion));

        $convention = new Convention();
        $convention->setPromotion($promotion);

        $form = $this->createForm(new ConventionType($lesTypes), $convention);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                foreach ($conventionsExistantes as $conventionExistante)
                {
                    if(strtolower($convention->getType()) == strtolower($conventionExistante->getType()))
                    {
                        $this->addFlash('error', "La convention " . $convention->getType() . " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId()))); // Redirection après l'erreur
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($convention);
                $em->flush();
                $this->addFlash('notice', "Convention " . $convention->getType() ." ajoutée !");
                return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $promotion->getId())));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:ajout_convention.html.twig', array(
            'form' => $form->createView(),
            'convention' => $convention,
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param Convention|null $convention
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modificationConventionAction(Request $request, Convention $convention = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        $user = $this->getUser();

        if(is_null($convention)){ //la convention n'existe pas
            return $this->redirectToRoute("liste_promotions");
        }

        $lesTypes = $this->getDoctrine()->getRepository('ConnexionBundle:Type')->findAll();
        $form = $this->createForm(new ConventionType($lesTypes), $convention);

        //Pour la vérification des doublons
        $conventionsExistantes = $this->getDoctrine()->getRepository('ConnexionBundle:Convention')->findBy(array('promotion' => $convention->getPromotion()));

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                foreach ($conventionsExistantes as $conventionExistante)
                {
                    if(strtolower($convention->getType()) == strtolower($conventionExistante->getType()))
                    {
                        $this->addFlash('error', "La convention " . $convention->getType() . " existe déjà !");
                        return $this->redirect($this->generateUrl("gerer_promotion", array('id' => $convention->getPromotion()->getId()))); // Redirection après l'erreur
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('notice', "Convention " . $convention->getType() ." modifiée !");
                return $this->redirectToRoute("gerer_promotion", array('id' => $convention->getPromotion()->getId()));

            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }

        return $this->render('AdministrateurBundle:Default:modification_convention.html.twig', array(
            'form' => $form->createView(),
            'convention' => $convention,
            'user' => $user
        ));
    }
}
