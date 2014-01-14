<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class DeletePage implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
                            
            $controllers->get('/{page}', function($page) use($app) {
                    $filepath = $app['config']['content_location'] . $page;
					unlink($filepath);

					return $app->redirect($app['url_generator']->generate('admin'));            
			})->bind('admin_delete'); 
            
           
            return $controllers;

    }
}