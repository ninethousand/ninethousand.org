<?php

namespace NineThousand\Bundle\NineThousandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProjectsController extends Controller
{
    
    public function indexAction()
    { 
        return $this->render('NineThousandNineThousandBundle:Projects:index.html.twig', 
                array(
                    'projects' => $this->container->getParameter('ninethousand.projects'),
                ));
    }
}