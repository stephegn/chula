<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class Loader implements ControllerProviderInterface {

	public function connect(Application $app) {
		$controllers = $app['controllers_factory'];


		$controllers->get('/', function($page) use ($app) {
			$filepath = $app['config']['content_location'] . $page;
			if(file_exists($filepath))
			{
				// TODO: do some fancy stuff that formats this all nicely
				return file_get_contents($filepath);
			}
			else
				$app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
		});

		return $controllers;

	}
}