<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;

class Admin implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];


    $controllers->get('/', function () use ($app)
    {

      // grab all items in our content dir
      $pages  = array();
      $drafts = array();
      if (file_exists($app['config']['content_location']))
      {
        $pages = array_diff(scandir($app['config']['content_location']), array('..', '.'));
      }
      if (file_exists($app['config']['draft_location']))
      {
        $drafts = array_diff(scandir($app['config']['draft_location']), array('..', '.'));
      }

      return $app['twig']->render('admin.twig', array('pages' => $pages, 'drafts' => $drafts));

    })->bind('admin');

    return $controllers;
  }

}