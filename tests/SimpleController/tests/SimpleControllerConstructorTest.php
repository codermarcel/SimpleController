<?php
/*
 * This file is part of the Money package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
