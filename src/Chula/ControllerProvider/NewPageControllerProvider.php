<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;

class NewPageControllerProvider implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];

            $controllers->get('/hello/{name}', function($name) use($app) { 
                    return 'Hello '.$app->escape($name); 
            }); 
            return $controllers;

    }
}