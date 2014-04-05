<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Chula\Tools\FileManager;

class DeletePage implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
                            
            $controllers->get('/{page}', function($page) use($app) {
              FileManager::deletePage($page, $app['config']);

              return $app->redirect($app['url_generator']->generate('admin'));
            })->bind('admin_delete');
            
           
            return $controllers;

    }
}