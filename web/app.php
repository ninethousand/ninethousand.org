<?php

umask(0002);

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
//require_once __DIR__.'/../app/bootstrap_cache.php.cache';
//require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

// Enforce ZF APPLICATION_ENV convention
if (! defined('APPLICATION_ENV')) {;
    // If on production machine, hostname will contain "collegedegrees.com"
    $default = strpos('.collegedegrees.com', php_uname('h'))
             ? 'production'
             : 'development';

    // Use existing APPLICATION_ENV or default
    define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: $default);
}

// Convert application environment to Symfony-friendly version
$env = (APPLICATION_ENV === 'staging'     ? 'stage'
     : (APPLICATION_ENV === 'testing'     ? 'test'
     : (APPLICATION_ENV === 'development' ? 'dev'
     : 'prod')));

$kernel = new AppKernel($env, $env !== 'prod');
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
