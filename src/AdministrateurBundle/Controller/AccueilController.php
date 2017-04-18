<?php

namespace AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccueilController extends Controller
{
    public function accueilAction()
    {

        $user = $this->getUser();
        return $this->render('AdministrateurBundle:Default:accueil.html.twig', array(
            'user' => $user
        ));
    }
}
