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