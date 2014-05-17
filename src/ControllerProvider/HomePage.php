<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Chula\Service\Page as PageService;

class HomePage implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get(
            '/',
            function () use ($app) {

                if (isset($app['config']['homepage_type']) && $app['config']['homepage_type'] != 'list') {
                    return $app['twig']->render('user_home.twig');
                }

                $pageService = new PageService($app['config']);
                $pages = $pageService->getAllPagesFromType('published');

                return $app['twig']->render('user_home.twig', array('pages' => $pages));


            }
        )->bind('home');

        return $controllers;
    }

}