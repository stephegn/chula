<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class NewPage implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
                    
            $form = $app['form.factory']->createBuilder('form')
                ->add('slug')
                ->add('content', 'textarea')
                ->getForm();
                            
            $controllers->get('/page', function() use($app, $form) {
                    
                    
                   
                    return $app['twig']->render('newPageForm.twig', array('form' => $form->createView()));
            }); 
            
            $controllers->post('/page', function(Request $request) use ($app, $form) {
                $form->bind($request);

                if ($form->isValid()) {
                    $data = $form->getData();

                    file_put_contents('../content/pages/'.$data['slug'], $data['content'], LOCK_EX);
                    return 'Saved!';
                }
            });
            return $controllers;

    }
}