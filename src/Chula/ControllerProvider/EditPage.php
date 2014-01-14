<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Chula\Tools\Encryption;

class EditPage implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
                    
            $form = $app['form.factory']->createBuilder('form')
                ->add('slug')
                ->add('content', 'textarea')
                ->getForm();
                            
            $controllers->get('/{page}', function($page) use($app, $form) {
                    $filepath = $app['config']['content_location'] . $page;
					if (file_exists($filepath)) {
						$file = ($app['config']['encrypt']) ? Encryption::decrypt(file_get_contents($filepath)) : file_get_contents($filepath);
					}
					
					$form->get('slug')->setData($page);
					$form->get('content')->setData($file);
                   
                    return $app['twig']->render('newPageForm.twig', array('form' => $form->createView()));
            })->bind('admin_edit'); 
            
            $controllers->post('/{page}', function(Request $request) use ($app, $form) {
                $form->bind($request);

                if ($form->isValid()) {
                    $data = $form->getData();
                    $content = ($app['config']['encrypt']) ? Encryption::encrypt($data['content']) : $data['content'];

                    file_put_contents($app['config']['content_location'].$data['slug'], $content, LOCK_EX);
                    return $app->redirect($app['url_generator']->generate('admin'));   
                }
            });
            return $controllers;

    }
}