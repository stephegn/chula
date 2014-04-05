<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;
use Chula\Tools\FileManager;


class Loader implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];


    $controllers->get('/', function ($page) use ($app)
    {

      $content = FileManager::getPageContent($page, $app['config']);

      if (is_null($content))
      {
        $app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
      }

      $html = Markdown::defaultTransform($content);

      // TODO: do some fancy stuff that formats this all nicely
      return $app['twig']->render('page.twig', array('content' => $html));
    });

    return $controllers;
  }
}

