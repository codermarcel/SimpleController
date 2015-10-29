<?php

namespace Codermarcel\SimpleController\Tests;

use Codermarcel\SimpleController\SimpleController;
use Codermarcel\SimpleController\Tests\MyExampleController;
use Silex\WebTestCase;

class SimpleControllerConstructorTest extends BaseTests
{
	public function createApplication()
	{
		$app = require __DIR__.'/bootstrap/app.php';
		$app->mount('/', new SimpleController('Codermarcel\SimpleController\Tests\MyExampleControllerConstruct'));
		return $app;
	}
}
