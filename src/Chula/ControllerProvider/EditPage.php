<?php
namespace Chula\ControllerProvider;

use Chula\Form\PageType;
use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditPage implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $form = $app['form.factory']->create(new PageType());

        $controllers->get(
            '/{slug}/{status}',
            function ($slug, $status) use ($app, $form) {

                $pageService = new PageService($app['config']);
				try {

					$page = $pageService->getPageFromSlugAndType($slug, $status);
				} catch (FileNotFoundException $e) {

					return new Response('That page does not exist', 404);
				}

                $form->get('slug')->setData($page->getSlug());
                $form->get('content')->setData($page->getContent());

                return $app['twig']->render('admin_edit_page.twig', array('form' => $form->createView()));
            }
        )->bind('admin_edit');

        $controllers->post(
            '/{slug}/{status}',
            function ($slug, $status, Request $request) use ($app, $form) {

                $form->bind($request);

                if ($form->isValid()) {
                    $data = $form->getData();

                    $pageService = new PageService($app['config']);
                    try {

                        $oldPage = $pageService->getPageFromSlugAndType($slug, $status);
                    } catch (FileNotFoundException $e) {

                        return new Response('That page does not exist', 404);
                    }
                    $newPage = clone($oldPage);
                    $newPage->setSlug($data['slug']);
                    $newPage->setContent($data['content']);

                    try {

                        $pageService->savePage($newPage, $oldPage);
                    } catch (\Exception $e) {

                        return new Response($e->getMessage(), 500);
                    }

                    return $app->redirect($app['url_generator']->generate('admin'));
                }
                return $app['twig']->render('admin_edit_page.twig', array('form' => $form->createView()));
            }
        );

        return $controllers;

    }
}