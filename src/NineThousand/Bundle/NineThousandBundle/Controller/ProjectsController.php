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
        $slug = str_replace('-', '_', $slug);
        $projects = $this->container->getParameter('ninethousand.projects');
        $found = false;
        foreach($projects as $key => $project) {
            if ($project['slug'] == $slug) {
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            throw new NotFoundHttpException('Project page was not found.');
        }
        
        $client = $this->container->get('compredux.' . $slug);
        $client->request();
        $client->initHeaders();
        if (!$client->isType('html')) {
            echo $client->getContent();
            exit();
        }
        
        $projects[$key]['headscript'] = $client->getContent('head script');
        $pattern = "/".addcslashes('GitHub.nameWithOwner || "','|')."/";
        $replacement = 'GitHub.nameWithOwner || "' . $client->getController() ;
        $projects[$key]['headscript'] = preg_replace($pattern , $replacement , $projects[$key]['headscript'] );
        
        $projects[$key]['bodyscript'] = $client->getContent('body script');
        $projects[$key]['headlink'] = $client->getContent('head link');
        $projects[$key]['content'] =  $client->getContent(
            array(
                '#slider',
                '#guides',
                '#toc', 
                '#files', 
                '#issues_next',
            ), 
            array(
                '.big-actions',
        ));
        
        

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
