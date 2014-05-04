<?php

namespace Chula\ControllerProvider;

use Chula\Tools\Encryption;
use Michelf\Markdown;
use Silex\Application;
use Silex\ControllerProviderInterface;

class Loader implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get(
          '/',
          function ($page) use ($app) {

              $filepath = $app['config']['location']['published'] . $page;
              if (file_exists($filepath)) {
                  $content = file_get_contents($filepath);

                  if ($app['config']['encrypt']) {
                      // Need to decrypt the content first if we're set to use encryption
                      $content = Encryption::decrypt($content);
                  }

                  $html = Markdown::defaultTransform($content);

                  $date = filectime($filepath);

                  // TODO: do some fancy stuff that formats this all nicely
                  return $app['twig']->render('user_page.twig', array('content' => $html, 'slug' => $page, 'date' => $date));
              } else {
                  $app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
              }
          }
        );

        return $controllers;
    }
}

