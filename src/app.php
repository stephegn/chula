<?php
$app->get('/hello/{name}', function($name) use($app) { 
    return 'Hello '.$app->escape($name); 
}); 

