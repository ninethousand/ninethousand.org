<?php

namespace NineThousand\Bundle\NineThousandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('NineThousandNineThousandBundle:Default:index.html.twig', array());
    }
    
    public function supportAction()
    {
        return $this->render('NineThousandNineThousandBundle:Default:support.html.twig', 
               array(
                    'projects' => $this->container->getParameter('ninethousand.projects'),
               ));
    }
}
