<?php

$app = new Silex\Application();

$app['debug'] = true;
$app['session.test'] = true;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
unset($app['exception_handler']);

return $app;
