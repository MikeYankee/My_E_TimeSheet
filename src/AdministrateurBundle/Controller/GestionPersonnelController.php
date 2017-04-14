<?php
namespace AdministrateurBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdministrateurBundle\Form\PersonnelType;
use ConnexionBundle\Entity\User;
class GestionPersonnelController extends Controller
{
    public function listePersonnelAction()
    {
        $liste_personnel = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT', 'ROLE_CFA', 'ROLE_SECRETAIRE', 'ROLE_RESPONSABLE', 'ROLE_ADMIN'));
        return $this->render('AdministrateurBundle:Default:liste_personnel.html.twig', array(
            'liste_personnel' => $liste_personnel
        ));
    }
    public function ajoutPersonnelAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));
        $userManager = $this->container->get('fos_user.user_manager');
        $personnel = $userManager->createUser();
        $form = $this->createForm(new PersonnelType(), $personnel);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $username = substr($personnel->getPrenom(),0,1)."".substr($personnel->getNom(),0,strlen($personnel->getNom()));
                $personnel->setUsername($username);
                $personnel->setPlainPassword($username);
                $personnel  ->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($personnel, true);
                //$em->persist($personnel);
                $em->flush();
                return $this->redirect($this->generateUrl("gerer_personnel"));
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }
        return $this->render('AdministrateurBundle:Default:ajout_personnel.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modificationPersonnelAction(Request $request, User $le_personnel = null)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN'));
        if(is_null($le_personnel)){ //la matière n'existe pas
            return $this->redirectToRoute("liste_promotions");
        }
        $userManager = $this->container->get('fos_user.user_manager');
        $form = $this->createForm(new PersonnelType(), $le_personnel);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $username = substr($le_personnel->getPrenom(),0,1)."".substr($le_personnel->getNom(),0,strlen($le_personnel->getNom()));
                $le_personnel->setUsername($username);
                $le_personnel->setPlainPassword($username);
                $le_personnel  ->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($le_personnel, true);
                $em->flush();
                return $this->redirect($this->generateUrl("gerer_personnel"));
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }
        return $this->render('AdministrateurBundle:Default:modification_personnel.html.twig', array(
            'form' => $form->createView()
        ));
    }
}