<?php

namespace PNC\PatrimoineBatiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PNCPatrimoineBatiBundle:Default:index.html.twig', array('name' => $name));
    }
}
