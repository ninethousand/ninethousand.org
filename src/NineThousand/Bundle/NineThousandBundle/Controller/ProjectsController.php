<?php

namespace NineThousand\Bundle\NineThousandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProjectsController extends Controller
{
    
    public function indexAction()
    { 
        return $this->render('NineThousandNineThousandBundle:Projects:index.html.twig', 
                array(
                    'projects' => $this->container->getParameter('ninethousand.projects'),
                ));
    }
    
    public function projectAction($slug = null)
    { 
        $projects = $this->container->getParameter('ninethousand.projects');
        $id = null;
        foreach($projects as $key => $project) {
            if ($project['slug'] == $slug) {
                $id = $key;
                break;
            }
        }
        if (!$slug || !$id) {
            throw new NotFoundHttpException('Project page was not found.');
        }
        return $this->render('NineThousandNineThousandBundle:Project:index.html.twig', 
                array(
                    'project' => $projects[$key],
                ));
    }
    
    public function supportAction($slug = null)
    { 
        if (!$project = $this->getProjectFromSlug($slug)) {
            throw new NotFoundHttpException('Project support page was not found.');
        }
        return $this->redirect($project['issues_url']);
    }
    
    private function getProjectFromSlug($slug)
    {
        if (!$slug) return null;
        $projects = $this->container->getParameter('ninethousand.projects');
        foreach($projects as $key => $project) {
            if ($project['slug'] == $slug) {
                return $projects[$key];
                break;
            }
        }
        return null;
    }
}
