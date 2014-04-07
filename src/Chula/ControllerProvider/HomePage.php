<?php

namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;
use Chula\Tools\Encryption;

class HomePage implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];


        $controllers->get('/', function () use ($app)
        {

            if (isset($app['config']['homepage_type']) && $app['config']['homepage_type'] != 'list') {
                return $app['twig']->render('user_home.twig');
            }
            // grab all items in our content dir
            $pageNames  = array();
            if (file_exists($app['config']['location']['published'])) {
                $pageNames = array_diff(scandir($app['config']['location']['published']), array('..', '.'));
            }

            $pages = array();

            //@todo this should be in a service
            foreach ($pageNames as $page) {
                $content = file_get_contents($app['config']['location']['published'].'/'.$page);

                if ($app['config']['encrypt'])
                {
                    // Need to decrypt the content first if we're set to use encryption
                    $content = Encryption::decrypt($content);
                }

                $html = Markdown::defaultTransform($content);

                $pages[$page]['slug'] = $page;
                $pages[$page]['content'] = $html;
            }

            return $app['twig']->render('user_home.twig', array('pages' => $pages));


        })->bind('admin');

        return $controllers;
    }

}