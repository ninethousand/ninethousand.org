<?php

$_SERVER['KERNEL_DIR'] = '../../../../../../../../app';

/*
    You can use the bootstrap but the point of doing this in its own file
    is that if the application is not working, then its possible that the 
    image wont work because whats breaking the application might be in whatever 
    is loaded in the bootstrap.
    
    Therefore, I find it is better to load only the Universal Classloader thereby 
    only loading the exact files which are required. And to be honest I may as well 
    be loading the individual components with require rather than this messyness with 
    the autoloader, however i want to make sure that if symfony component dependencies change, 
    then I will be saved by the namespaces rather than loading explicit class files
*/

//bootstrap application
//include ($_SERVER['KERNEL_DIR'].'/bootstrap.php.cache');

//load autoloader
require_once $_SERVER['KERNEL_DIR'].'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();

$loader->registerNamespaces(array(
    'Symfony' => array($_SERVER['KERNEL_DIR'].'/../vendor/symfony/src'),
));
$loader->register();


use Symfony\Component\Finder\Finder;

$posters = array();
$location = __DIR__.'/error';

if (isset($_GET['code']) && is_dir(__DIR__.'/'.$_GET['code'])) {
    $location = __DIR__.'/'.$_GET['code'];
}

$files = new Finder();
$files->files()->in($location);
foreach($files as $file)
{
    $posters[] = $file->getFilename();
}
$image = $posters[array_rand($posters)];
$fullpath = $location.'/'.$image;
$info = getimagesize($fullpath);
$type = image_type_to_mime_type($info[2]);

header('Content-Type: '.$type);
readfile($fullpath);



