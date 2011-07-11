<?php

namespace NineThousand\Bundle\NineThousandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('NineThousandNineThousandBundle:Default:index.html.twig', array());
    }
}
