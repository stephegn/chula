<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

class HomePage implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];


        $controllers->get('/', function () use ($app)
        {

            if (isset($app['config']['homepage_type']) && $app['config']['homepage_type'] != 'list') {
                return $app['twig']->render('user_home.twig');
            }
            // grab all items in our content dir
            $pages  = array();
            if (file_exists($app['config']['location']['published'])) {
                $pages = array_diff(scandir($app['config']['location']['published']), array('..', '.'));
            }

            return $app['twig']->render('user_home.twig', array('pages' => $pages));


        })->bind('admin');

        return $controllers;
    }

}