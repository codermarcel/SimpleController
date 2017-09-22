<?php

namespace Codermarcel\SimpleController\tests;

use Codermarcel\SimpleController\SimpleController;

class SimpleControllerConstructorTest extends BaseTests
{
    public function createApplication()
    {
        $app = require __DIR__.'/bootstrap/app.php';
        $app->mount('/', new SimpleController('Codermarcel\SimpleController\Tests\MyExampleControllerConstruct'));

        return $app;
    }
}
