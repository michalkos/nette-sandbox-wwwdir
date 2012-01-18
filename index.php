<?php

// uncomment this line if you must temporarily take down your site for maintenance
// require 'app/templates/maintenance.phtml';

// define an array of application parameters appended to configurator
$params = array();

// force a development mode for the domain
// usefull if you are working the the framework on a shared network
// if(strpos($_SERVER['HTTP_HOST'], '.mydomain.com') !== false) $params['forceDevelopmentMode'] = true;

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/app');

// absolute filesystem path to the system dir
define('SYS_DIR', WWW_DIR . '/system');

// absolute filesystem path to the libraries
define('LIBS_DIR', SYS_DIR . '/libs');

// load bootstrap file
require APP_DIR . '/bootstrap.php';
