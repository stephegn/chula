<?php
namespace Chula\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;

class DeletePage implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get(
            '/{page}/{status}',
            function ($page, $status) use ($app) {

                if (!isset($app['config']['location'][$status])) {
                    return new Response('That status does not exist', 404);
                }
                $path = $app['config']['location'][$status] . $page;

                if (file_exists($path)) {
                    unlink($path);
                }

                return $app->redirect($app['url_generator']->generate('admin'));
            }
        )->bind('admin_delete');


        return $controllers;

    }
}