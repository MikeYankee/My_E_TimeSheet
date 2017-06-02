<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contacterAction()
    {
        $user = $this->getUser();
        return $this->render('UtilisateurBundle:Default:contact.html.twig', array(
            'user' => $user
        ));
    }
}
