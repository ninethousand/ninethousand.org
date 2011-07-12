<?php

namespace NineThousand\Bundle\NineThousandBundle\Extension;

use Twig_Extension as Extension;
use Symfony\Component\Finder\Finder;

class GlobalVariables extends \Twig_Extension
{
    protected $posters;

    public function __construct()
    {
        $this->loadErrorPosters();
    }
    
    public function getNotfoundposter()
    {
        return $this->posters['404'];
    }
    
    public function getErrorposter()
    {
        return $this->posters['error'];
    }

    public function getGlobals()
    {
        return array(
            'errorposter'    => $this->posters['error'],
            'notfoundposter' => $this->posters['404'],
        );
    }

    public function getName()
    {
        return 'ninethousand_globals';
    }
    
    private function loadErrorPosters()
    {
        $dirs = new Finder();
        $dirs->directories()->in(__DIR__.'/../Resources/public/images/weberrors');
        foreach ($dirs as $dir) {
            $errors = array();
            $type = $dir->getFilename();
            $files = new Finder();
            $files->files()->in($dir->getRealpath());
            foreach($files as $file)
            {
                $errors[] = $file->getFilename();
            }
            $image = $errors[array_rand($errors)];
            $this->posters[$type] = $image;
            unset($files);
            unset($errors);
        }
    }
}