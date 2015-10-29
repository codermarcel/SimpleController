<?php

namespace SimpleController\Tests;

use SimpleController\SimpleController;
use SimpleController\Tests\MyExampleController;
use Silex\WebTestCase;

class SimpleControllerConstructorTest extends BaseTests
{
	public function createApplication()
	{
		$app = require __DIR__.'/bootstrap/app.php';
		$app->mount('/', new SimpleController('SimpleController\Tests\MyExampleControllerConstruct'));
		return $app;
	}
}
