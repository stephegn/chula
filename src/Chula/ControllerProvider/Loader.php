<?php

namespace Chula\ControllerProvider;

use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use \Michelf\Markdown;

class Loader implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get('/', function ($slug) use ($app) {

            $pageService = new PageService($app['config']);
            $page = $pageService->getPageFromSlugAndType($slug, 'published');

            if ($page == null) {
                $app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
            }

            return $app['twig']->render('user_page.twig', array('content' => $page->getHtmlContent()));

        });

        return $controllers;
    }
}

