<?php
namespace Chula\ControllerProvider;

use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeletePage implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get(
            '/{slug}/{status}',
            function ($slug, $status) use ($app) {

                $pageService = new PageService($app['config']);
				try {

					$page = $pageService->getPageFromSlugAndType($slug, $status);
				} catch (FileNotFoundException $e) {

					return new Response('That page does not exist', 404);
				}

                try {

                    $pageService->deletePage($page);
                } catch (FileNotFoundException $e) {

                    return new Response('That file does not exist', 404);
                } catch (\Exception $e) {

                    return new Response('An error occurred', 500);
                }

                return $app->redirect($app['url_generator']->generate('admin'));
            }
        )->bind('admin_delete');


        return $controllers;

    }
}