<?php

namespace Chula\ControllerProvider;

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
                $pages = array();
                $drafts = array();
                if (file_exists($app['config']['location']['published'])) {
                    $pages = array_diff(scandir($app['config']['location']['published']), array('..', '.'));
                }
                if (file_exists($app['config']['location']['draft'])) {
                    $drafts = array_diff(scandir($app['config']['location']['draft']), array('..', '.'));
                }

                return $app['twig']->render('admin_home.twig', array('pages' => $pages, 'drafts' => $drafts));

            }
        )->bind('admin');

        return $controllers;
    }

}