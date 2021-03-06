<?php

namespace Codermarcel\SimpleController\tests;

class SimpleControllerExtendedTest extends BaseTests
{
    public function createApplication()
    {
        $app = require __DIR__.'/bootstrap/app.php';
        $app->mount('/', new MyExampleControllerExtend());

        return $app;
    }
}
