<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;

class Admin implements ControllerProviderInterface {

    public function connect(Application $app) {
	$controllers = $app['controllers_factory'];


	$controllers->get('/', function() use ($app) {
	
			//grab all items in our content dir
			if(!file_exists($app['config']['content_location']))
			{
				$app->abort(500, "Those monkeys couldn't find the page you were after, hard luck.");
			}
		    $pages = scandir($app['config']['content_location']);
			
			//Remove the first two items in the array. These are always '.' and '..'
			array_shift($pages);
			array_shift($pages);
			
			return $app['twig']->render('admin.twig', array('pages' => $pages));
		   
		})->bind('admin');

	return $controllers;
    }

}