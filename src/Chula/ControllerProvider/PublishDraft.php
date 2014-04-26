<?php
/**
 * Created by PhpStorm.
 * User: qasim
 * Date: 06/04/2014
 * Time: 13:05
 */

namespace Chula\ControllerProvider;

use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PublishDraft implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get(
            '/{draft}',
            function ($draft) use ($app) {

                $pageService = new PageService($app['config']);
                try {

                    $page = $pageService->getPageFromSlugAndType($draft, 'draft');
                } catch (FileNotFoundException $e) {
                    return new Response('That page does not exist', 404);
                }
                try {

                    $pageService->publishPage($page);
                } catch (\Exception $e) {
                    return new Response('An error occurred', 500);
                }

                return $app->redirect($app['url_generator']->generate('admin'));
            }
        )->bind('admin_publish');

        return $controllers;

    }

}