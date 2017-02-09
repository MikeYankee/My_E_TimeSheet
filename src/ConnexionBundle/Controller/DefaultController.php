<?php

namespace ConnexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ConnexionBundle:Default:index.html.twig');
    }


    public function signalerPresenceAction()
    {
        return $this->render('ConnexionBundle:Default:signaler_presence.html.twig');
    }

    public function enseignantAction()
    {
        echo "enseignant";
    }
}
