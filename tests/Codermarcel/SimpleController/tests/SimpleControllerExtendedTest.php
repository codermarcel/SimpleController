<?php

namespace Codermarcel\SimpleController\Tests;

use Codermarcel\SimpleController\SimpleController;
use Codermarcel\SimpleController\Tests\MyExampleController;
use Silex\WebTestCase;

class SimpleControllerExtendedTest extends BaseTests
{
	public function createApplication()
	{
		$app = require __DIR__.'/bootstrap/app.php';
		$app->mount('/', new MyExampleControllerExtend());
		return $app;
	}
}
