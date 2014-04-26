<?php
namespace Chula\ControllerProvider;

use Chula\Exception\PageExistsException;
use Chula\Form\PageType;
use Chula\Service\Page as PageService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class NewPage implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $form = $app['form.factory']->create(new PageType());

        $controllers->get(
            '/page',
            function () use ($app, $form) {


                return $app['twig']->render('admin_edit_page.twig', array('form' => $form->createView()));
            }
        );

        $controllers->post(
            '/page',
            function (Request $request) use ($app, $form) {
                $form->bind($request);

                if ($form->isValid()) {
                    $data = $form->getData();

					$pageService = new PageService($app['config']);

					//Set content as empty string and then use setter is a hack for getting this to encrypt.
					//Needs changing!
					$page = new \Chula\Model\Page($data['slug'], '', 'draft', $app['config']['encrypt']);
					$page->setContent($data['content']);

					try {
						$pageService->savePage($page);

						return $app->redirect($app['url_generator']->generate('admin'));

					} catch (PageExistsException $e) {

						return $app['twig']->render(
							'admin_edit_page.twig',
							array('form' => $form->createView(), 'messages' => array($e->getMessage()))
						);
					}
                }
            }
        )->bind('admin_new');
        return $controllers;

    }
}