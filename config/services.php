<?php

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Slim\Views\Twig;

return function (ContainerInterface $container): void {
	$container->set(Twig::class, function() {
			return Twig::create(__DIR__.'/../resources/views', ['cache' => __DIR__.'/../var/twig']);
	});
	$container->set(EntityManagerInterface::class, function (ContainerInterface $container): EntityManagerInterface {

		$config = Setup::createAnnotationMetadataConfiguration(
	        [__DIR__.'/../src/Model'], true
	    );

	    $config->setMetadataDriverImpl(
	        new AnnotationDriver(new AnnotationReader, __DIR__.'/../src/Model')
	    );

	    $config->setMetadataCacheImpl(
	        new FilesystemCache(__DIR__.'/../var/doctrine')
	    );

	    return EntityManager::create(
	        [
	    		'driver' => 'pdo_mysql',
	    		'port' => 3306,
	    		'charset' => 'utf8'
	        ] + $container->get('dbConfig'),
	        $config
	    );
	});
};
