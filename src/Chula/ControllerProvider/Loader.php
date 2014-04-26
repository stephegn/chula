<?php

namespace Chula\ControllerProvider;

use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Loader implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get(
            '/',
            function ($slug) use ($app) {

                $pageService = new PageService($app['config']);
				try {

					$page = $pageService->getPageFromSlugAndType($slug, 'published');
				} catch (FileNotFoundException $e) {
					$app->abort(404, "Those monkeys couldn't find the page you were after, hard luck.");
				}

                return $app['twig']->render('user_page.twig', array('page' => $page));

            }
        )->bind('load_page');

        return $controllers;
    }
}
