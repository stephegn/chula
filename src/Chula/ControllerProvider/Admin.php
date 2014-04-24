<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Chula\Service\Page as PageService;

class Admin implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get(
            '/',
            function () use ($app) {

                // grab all items in our content dir

                $pageService = new PageService($app['config']);
                $pages = $pageService->getAllPagesFromType('published');
                $drafts = $pageService->getAllPagesFromType('draft');

                return $app['twig']->render('admin_home.twig', array('pages' => $pages, 'drafts' => $drafts));

            }
        )->bind('admin');

        return $controllers;
    }

}