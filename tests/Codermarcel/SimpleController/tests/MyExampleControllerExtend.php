<?php

namespace Codermarcel\SimpleController\Tests;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Codermarcel\SimpleController\SimpleController;
use Codermarcel\SimpleController\Tests\BaseController;

class MyExampleControllerExtend extends SimpleController
{
	use BaseController;
}
