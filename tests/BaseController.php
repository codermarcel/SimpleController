<?php

namespace Codermarcel\SimpleController\Tests;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait BaseController
{
	/**
	 * Index example
	 * Routes to /
	 */
	public function getIndex()
	{
		return new Response('INDEX');
	}

	/**
	 * GET example
	 * Routes to /test
	 */
	public function getTest()
	{
		return new Response('GET');
	}

	/**
	 * Post example
	 * Routes to /test
	 */
	public function postTest()
	{
		return new Response('POST');
	}

	/**
	 * Put example
	 * Routes to /test
	 */
	public function putTest()
	{
		return new Response('PUT');
	}

	/**
	 * Delete example
	 * Routes to /test
	 */
	public function deleteTest()
	{
		return new Response('DELETE');
	}

	/**
	 * Match example
	 * Routes to /test
	 */
	public function matchTest()
	{
		return new Response('MATCH');
	}

	/**
	 * Post with two parameters example
	 * Routes to /login{username}/{password}
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}

	/**
	 * Example of Parameter injection
	 * Routes to /injection
	 */
	public function getInjection(Application $app, Request $request)
	{
		$app['injection_test'] = true;
		return new Response($request->getRequestUri());
	}

	/**
	 * Example of binding a name to a route
	 * Routes to /bind-example
	 *
	 * {@link http://silex.sensiolabs.org/doc/providers/url_generator.html#usage}
	 */
	public function getBindExample(Application $app, $bind = 'bind_example')
	{
		//You can use ABSOLUTE_URL or ABSOLUTE_PATH
		return new Response($app['url_generator']->generate('bind_example', array(), UrlGeneratorInterface::ABSOLUTE_PATH));
	}

	/**
	 * Route that triggers the before middleware
	 * Routes to /before-middleware
	 */
	public function getBeforeMiddleware()
	{
		return new Response('You Can\'t See Me');
	}

	/**
	 * Route that triggers the after middleware
	 * Routes to /after-middleware
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
