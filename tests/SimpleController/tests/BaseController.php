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

use Silex\Application;
use SimpleController\SimpleController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait BaseController
{
	/**
	 * GET example
	 */
	public function getTest()
	{
		return new Response('GET');
	}

	/**
	 * Post example
	 */
	public function postTest()
	{
		return new Response('POST');
	}

	/**
	 * Put example
	 */
	public function putTest()
	{
		return new Response('PUT');
	}

	/**
	 * Delete example
	 */
	public function deleteTest()
	{
		return new Response('DELETE');
	}

	/**
	 * Match example
	 */
	public function matchTest()
	{
		return new Response('MATCH');
	}

	/**
	 * Index example
	 */
	public function getIndex()
	{
		return new Response('INDEX');
	}

	/**
	 * Example of binding a name to a route
	 * {@link http://silex.sensiolabs.org/doc/providers/url_generator.html#usage}
	 */
	public function getBindExample(Application $app, $bind = 'bind_example')
	{
		//You can use ABSOLUTE_URL or ABSOLUTE_PATH
		return new Response($app['url_generator']->generate('bind_example', array(), UrlGeneratorInterface::ABSOLUTE_PATH));
	}

	/**
	 * Post with two parameters example
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}

	/**
	 * Route that triggers the before middleware
	 */
	public function getBeforeMiddleware()
	{
		return new Response('You Can\'t See Me');
	}

	/**
	 * Route that triggers the after middleware
	 */
	public function getAfterMiddleware()
	{
		return new Response('route content');
	}

	/**
	 * Before middleware example
	 *
	 * {@link http://silex.sensiolabs.org/doc/middlewares.html#before-middleware}
	 */
	public function beforeMiddleware(Request $request)
	{
		if ($request->getRequestUri() === '/before-middleware')
		{
			return new Response('YOU SHALL NOT PASS');
		}
	}

	/**
	 * After middleware example
	 *
	 * {@link http://silex.sensiolabs.org/doc/middlewares.html#after-middleware}
	 */
	public function afterSomeRandomNameThatDoesntMatter(Request $request, Response $response)
	{
		if ($request->getRequestUri() === '/after-middleware')
		{
			return new Response($response->getContent() . ' | after-middleware content');
		}
	}
}
