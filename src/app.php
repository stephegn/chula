<?php
require_once __DIR__.'/bootstrap.php';

$app->mount(
	'/{page}', 
	new Chula\ControllerProvider\Loader()
	);

$app->mount(
	'/new',
	new Chula\ControllerProvider\NewPageControllerProvider()
	);

$app->get('/', function() use ($app)
{
	return 'HELLOOOOO';
});

$app->run(); 

