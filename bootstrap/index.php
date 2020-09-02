<?php

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container;

$dbConfig = require __DIR__ . '/../config/db.php';
$container->set('dbConfig', $dbConfig);

$servicesCallable = require __DIR__ . '/../config/services.php';
$servicesCallable($container);

$app = SlimAppFactory::create($container);

TwigMiddleware::createFromContainer($app, Twig::class);
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->run();
