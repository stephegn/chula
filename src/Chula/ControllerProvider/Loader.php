<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;

class Loader implements ControllerProviderInterface {

    public function connect(Application $app) {
	$controllers = $app['controllers_factory'];


	$controllers->get('/', function($page) use ($app) {
		    $filepath = $app['config']['content_location'] . $page;
		    if (file_exists($filepath)) {
			$html = Markdown::defaultTransform(file_get_contents($filepath));
			// TODO: do some fancy stuff that formats this all nicely
			return $app['twig']->render('page.twig', array('content' => $html));
		    }
		    else
			$app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
		});

	return $controllers;
    }

}