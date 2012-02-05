<?php

/**
 * Application bootstrap file.
 */
use Nette\Diagnostics\Debugger,
	Nette\Application\Routers\Route,
	Nette\Config\Configurator;

// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';

// Configure application
$configurator = new Configurator;

// Set a development mode for the domain
// Usefull if you are working with the framework on a shared network
/*if(strpos($_SERVER['HTTP_HOST'], '.mydomain.com') !== false) {
	$configurator->setProductionMode(FALSE);
}*/

// Enable debugger
Debugger::$maxLen = 512;
Debugger::$maxDepth = 3;
$configurator->enableDebugger(SYS_DIR . '/log');

// Append the parameters
$configurator->addParameters(array('sysDir' => SYS_DIR));

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(SYS_DIR . '/temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(APP_DIR . '/config/config.neon'/*,
	// Load the config based on production mode
	$configurator->productionMode ? Configurator::PRODUCTION : Configurator::DEVELOPMENT
*/);
$container = $configurator->createContainer();

// Setup router
$router = $container->router;
$router[] = new Route('index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY);
$router[] = new Route('<presenter>[/<action>][/<id>][.html]', 'Homepage:default');

// Configure and run the application!
$application = $container->application;
$application->catchExceptions = $configurator->productionMode;
$application->errorPresenter = 'Error';
$application->run();
