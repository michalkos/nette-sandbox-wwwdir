<?php

/**
 * Application bootstrap file.
 */
use Nette\Diagnostics\Debugger,
	Nette\Application\Routers\Route;

// Load Nette Framework
$params['sysDir'] = SYS_DIR;
require LIBS_DIR . '/Nette/loader.php';

// Enable Nette Debugger for error visualisation & logging
Debugger::$logDirectory = SYS_DIR . '/log';
Debugger::$email = 'my@email.tld';
Debugger::$maxLen = 512;
Debugger::$maxDepth = 3;

// Set a development mode for the domain
// Usefull if you are working with the framework on a shared network
/*Debugger::$productionMode = strpos($_SERVER['HTTP_HOST'], '.mydomain.com') !== false
    ? Debugger::DEVELOPMENT // set a development mode
    : Debugger::DETECT; // detect the mode */

Debugger::enable();

// Configure application
$configurator = new Nette\Config\Configurator;
$configurator->addParameters($params);
$configurator->setTempDirectory(SYS_DIR . '/temp');

// Enable RobotLoader - this will load all classes automatically
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Force Development mode
if(isset($params['forceDevelopmentMode']) && $params['forceDevelopmentMode'] === true) {
	$configurator->setProductionMode(FALSE);
}

// Create Dependency Injection container from config.neon file
$configurator->addConfig(APP_DIR . '/config/config.neon');
$container = $configurator->createContainer();

// Opens already started session
if ($container->session->exists()) {
    $container->session->setExpiration('+30 days');
	$container->session->start();
}

// Setup router
$router = $container->router;
$router[] = new Route('index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY);
$router[] = new Route('<presenter>[/<action>][/<id>][.html]', 'Homepage:default');

// Configure and run the application!
$application = $container->application;
$application->catchExceptions = $container->parameters['productionMode'];
$application->errorPresenter = 'Error';
$application->run();
