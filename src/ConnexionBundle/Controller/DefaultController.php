<?php

namespace ConnexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //$db=$this->get('doctrine.dbal.default_connection');//on récupére un objet Doctrine\DBAL\Connection

        //$rows=$db->fetchAll('SELECT * FROM user');

        //print_r($rows);
        return $this->render('ConnexionBundle:Default:index.html.twig');
    }
}
