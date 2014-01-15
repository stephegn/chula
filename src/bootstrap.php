<?php
use Silex\Provider\FormServiceProvider;
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 


$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$env = getenv('APP_ENV') ?: 'prod';

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/config/$env.json"));

if($env != 'prod')
	$app->register(new Whoops\Provider\Silex\WhoopsServiceProvider);

$app['twig']->addGlobal('admin_path', $app['config']['admin_path']);

$app->register(new Silex\Provider\SessionServiceProvider());

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/'.$app['config']['admin_path'],
        'form' => array('login_path' => '/login', 'check_path' => '/'.$app['config']['admin_path'].'/login_check'),
        'users' => $app['config']['users'],
        'logout' => array('logout_path' => '/'.$app['config']['admin_path'].'/logout')
    ),
);

$app->register(new Silex\Provider\SecurityServiceProvider(array(
    'security.firewalls' => $app['security.firewalls'],
    'security.access_rules' => array(
        array('^/admin-kit', 'ROLE_ADMIN')
    )
)));
