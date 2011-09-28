<?php

namespace NineThousand\Bundle\NineThousandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;


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
        if ($client->hasErrors() && ($error = $client->getErrors())) {
           if (false !== strpos($error, '404')) {
               throw new NotFoundHttpException('Compredux request returned 404. Try refresh?');
           } else {
               throw new HttpException('Compredux request returned error');
           }
        }
        $client->initHeaders();

        if (!$client->isType('html') && !$client->hasErrors()) {
            echo $client->getContent();
            exit();
        }
        $projects[$key]['header'] = $projects[$key]['title'];
        if (null != ($title = $client->getContent('.title-actions-bar h1'))) {
            $projects[$key]['title'] = trim(str_replace('/', '|', strip_tags($title)));
            $projects[$key]['header'] = trim($title);
        }

        if (null != ($description = $client->getContent(array('#repository_description > p'), array('span','a')))) {
            $projects[$key]['description'] = trim($description);
        }
        
        $projects[$key]['headscript'] = $client->getContent('head script');
        $pattern = "/".addcslashes('GitHub.nameWithOwner || "','|')."/";
        $replacement = 'GitHub.nameWithOwner || "' . $client->getController() ;
        $projects[$key]['headscript'] = preg_replace($pattern , $replacement , $projects[$key]['headscript'] );
        $projects[$key]['bodyscript'] = $client->getContent('body script');
        $projects[$key]['headlink'] = $client->getContent('head link');
        $projects[$key]['content'] =  trim($client->getContent(
            array(
                '#slider',
                '#guides',
                '#toc', 
                '#file',
                '.profilecols',
                '#issues_next',
            ), 
            array(
                '.big-actions',
        )));

        if (empty($projects[$key]['content'])) {
               throw new NotFoundHttpException('Compredux was successful but no content was collected.');
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
