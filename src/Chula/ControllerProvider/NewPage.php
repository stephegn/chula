<?php
namespace Chula\ControllerProvider;

use Chula\Tools\StringManipulation;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Chula\Tools\Encryption;

class NewPage implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];

    $form = $app['form.factory']->createBuilder('form')
      ->add('slug')
      ->add('content', 'textarea')
      ->getForm();

    $controllers->get('/page', function () use ($app, $form)
    {
      return $app['twig']->render('newPageForm.twig', array('form' => $form->createView()));
    });

    $controllers->post('/page', function (Request $request) use ($app, $form)
    {
      $form->bind($request);

      if ($form->isValid())
      {
        $data = $form->getData();

        $content = $data['content'];
        if ($app['config']['encrypt'])
        {
          $content = Encryption::encrypt($content);
        }
        $slug = StringManipulation::toSlug($data['slug']);

        // Ensure drafts folder has been created
        if (!file_exists($app['config']['draft_location']))
        {
          mkdir($app['config']['draft_location']);
        }

        // Default to a draft.
        if (!file_exists($app['config']['draft_location'] . $slug))
        {
          file_put_contents($app['config']['draft_location'] . $slug, $content, LOCK_EX);

          return $app->redirect($app['url_generator']->generate('admin'));
        }
        else
        {
          //@todo need a better flash system
          return $app['twig']->render('newPageForm.twig', array('form' => $form->createView(), 'messages' => array('That page already exists')));

        }
      }
    })->bind('admin_new');

    return $controllers;

  }
}