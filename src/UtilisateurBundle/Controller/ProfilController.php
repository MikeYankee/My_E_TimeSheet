<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use ConnexionBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UtilisateurBundle\Form\UserType;


class ProfilController extends Controller
{
    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function profilAction(Request $request, User $user)
    {
        //$this->denyAccessUnlessGranted(array('ROLE_ADMIN'));

        /*if(is_null($user)){ //la matière n'existe pas
            return $this->redirectToRoute("liste_promotions");
        }*/
        
        $userManager = $this->container->get('fos_user.user_manager');
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $username = substr($user->getPrenom(), 0, 1) . "" . substr($user->getNom(), 0, strlen($user->getNom()));
                $user->setUsername($username);
                //$motdepasseactuel = $user->getPassword();
                //$nouveaumotdepasse = $request->get("nouveaumotdepasse");
                //$confirmationnouveaumotdepasse = $request->get("confirmationnouveaumotdepasse");
                //if ($motdepasseactuel == $user->password){
                    //if($nouveaumotdepasse == $confirmationnouveaumotdepasse){
                        //$user->setPlainPassword($nouveaumotdepasse);
                    //}
                //}
                $user ->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $userManager->updateUser($user, true);
                $em->flush();
                return $this->redirect($this->generateUrl("profil"));
            } else
                $this->addFlash('error', "Tous les champs doivent être complétés.");
        }
        return $this->render('UtilisateurBundle:Default:profil.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
