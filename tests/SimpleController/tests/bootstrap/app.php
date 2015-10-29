<?php
$app = new Silex\Application();

$app['debug'] = true;
$app['session.test'] = true;
unset($app['exception_handler']);
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

return $app;
