<?php

namespace Melk\TreeBuilderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MelkTreeBuilderBundle:Default:index.html.twig', array('name' => $name));
    }
}
