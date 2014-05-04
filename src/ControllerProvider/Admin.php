<?php

namespace Chula\ControllerProvider;

use Chula\Tools\FileManipulation;
use Silex\Application;
use Silex\ControllerProviderInterface;

class Admin implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get(
          '/',
          function () use ($app) {

              // grab all items in our content dir
              $pages  = array();
              $drafts = array();
              if (file_exists($app['config']['location']['published'])) {
                  $pages = FileManipulation::listDirByDate($app['config']['location']['published']);
              }
              if (file_exists($app['config']['location']['draft'])) {
                  $drafts = FileManipulation::listDirByDate($app['config']['location']['draft']);
              }

              return $app['twig']->render('admin_home.twig', array('pages' => $pages, 'drafts' => $drafts));

          }
        )->bind('admin');

        return $controllers;
    }

}