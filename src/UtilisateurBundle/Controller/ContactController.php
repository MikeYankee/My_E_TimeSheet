<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller
{
    public function contacterAction()
    {
        return $this->render('UtilisateurBundle:Default:contact.html.twig');
    }
}
