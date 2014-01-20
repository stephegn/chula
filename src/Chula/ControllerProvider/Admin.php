<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;

class Admin implements ControllerProviderInterface {

    public function connect(Application $app) {
	$controllers = $app['controllers_factory'];


	$controllers->get('/', function() use ($app) {
	
			// grab all items in our content dir
			if(!file_exists($app['config']['content_location']))
			{
				$app->abort(500, "Those monkeys couldn't find the page you were after, hard luck.");
			}
		    $pages = array_diff(scandir($app['config']['content_location']), array('..', '.'));

			
			return $app['twig']->render('admin_home.twig', array('pages' => $pages));
		   
		})->bind('admin');

	return $controllers;
    }

}