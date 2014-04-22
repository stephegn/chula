<?php
require_once __DIR__.'/bootstrap.php';


use Symfony\Component\HttpFoundation\Request;

foreach ($app['config']['location'] as $path) {
  if (!is_dir($path)) {
    $app->abort(500, "There was an issue loading the content. Is your content location correct?");
  }
}

$app->mount('/', new Chula\ControllerProvider\HomePage());

$app->mount(
  '/' . $app['config']['admin_path'],
  new Chula\ControllerProvider\Admin()
);

$app->mount(
  '/{page}',
  new Chula\ControllerProvider\Loader()
);

$app->mount(
  '/' . $app['config']['admin_path'] . '/new',
  new Chula\ControllerProvider\NewPage()
);

$app->mount(
  '/' . $app['config']['admin_path'] . '/delete',
  new Chula\ControllerProvider\DeletePage()
);

$app->mount(
  '/' . $app['config']['admin_path'] . '/edit',
  new Chula\ControllerProvider\EditPage()
);

$app->mount(
  '/' . $app['config']['admin_path'] . '/publish',
  new Chula\ControllerProvider\PublishDraft()
);


$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('admin_login.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

$app->run(); 

