<?php

namespace ConnexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ConnexionBundle:Default:index.html.twig', array("maVar" => array("bananes"," fraise", "mangue")));
    }

    public function etudiantAction()
    {
        echo "etudiant";
    }

    public function enseignantAction()
    {
        echo "enseignant";
    }
}
