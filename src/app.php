<?php
require_once __DIR__.'/bootstrap.php';

$app->mount(
		'/'.$app['config']['admin_path'],
		new Chula\ControllerProvider\Admin()
	);
$app->mount(
		'/{page}', 
		new Chula\ControllerProvider\Loader()
	);
	

$app->mount(
		'/'.$app['config']['admin_path'].'/new',
		new Chula\ControllerProvider\NewPage()
	);
	

$app->mount(
		'/'.$app['config']['admin_path'].'/delete',
		new Chula\ControllerProvider\DeletePage()
	);


$app->get('/', function() use ($app)
{
	return 'HELLOOOOO';
});

$app->run(); 

