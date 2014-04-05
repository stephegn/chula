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

      $filepath = $app['config']['content_location'] . $page;
      if (file_exists($filepath))
      {
        $content = file_get_contents($filepath);

        if ($app['config']['encrypt'])
        {
          // Need to decrypt the content first if we're set to use encryption
          $content = Encryption::decrypt($content);
        }

        $html = Markdown::defaultTransform($content);

        // TODO: do some fancy stuff that formats this all nicely
        return $app['twig']->render('page.twig', array('content' => $html));
      }
      else
      {
        $app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
      }
    });

    return $controllers;
  }
}

