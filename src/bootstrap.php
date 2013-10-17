<?php
use Silex\Provider\FormServiceProvider;
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 
$app->register(new Whoops\Provider\Silex\WhoopsServiceProvider);

$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));