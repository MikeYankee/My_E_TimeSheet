<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GestionPersonnelController extends Controller
{
    public function listePersonnelAction()
    {
        $liste_personnel = $this->getDoctrine()->getRepository('ConnexionBundle:User')->findByRole(array('ROLE_ENSEIGNANT', 'ROLE_CFA', 'ROLE_SECRETAIRE', 'ROLE_RESPONSABLE', 'ROLE_ADMIN'));

        return $this->render('AdministrateurBundle:Default:liste_personnel.html.twig', array(
            'liste_personnel' => $liste_personnel
        ));
    }
}
