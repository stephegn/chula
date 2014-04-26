<?php
/**
 * Created by PhpStorm.
 * User: qasim
 * Date: 06/04/2014
 * Time: 13:05
 */

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

class PublishDraft implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get(
          '/{draft}',
          function ($draft) use ($app) {

              // Move page from drafts folder to content location
              $path['draft']     = $app['config']['location']['draft'] . $draft;
              $path['published'] = $app['config']['location']['published'] . $draft;
              if (file_exists($path['draft'])) {
                  rename($path['draft'], $path['published']);
              }

              return $app->redirect($app['url_generator']->generate('admin'));
          }
        )->bind('admin_publish');

        return $controllers;

    }

}