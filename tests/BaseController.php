<?php

namespace Codermarcel\SimpleController\Tests;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait BaseController
{
	/**
	 * Responds to request to GET /
	 */
	public function getIndex()
	{
		return new Response('INDEX');
	}

	/**
	 * Responds to request to GET /test
	 */
	public function getTest()
	{
		return new Response('GET');
	}

	/**
	 * Responds to request to POST /test
	 */
	public function postTest()
	{
		return new Response('POST');
	}

	/**
	 * Responds to request to PUT /test
	 */
	public function putTest()
	{
		return new Response('PUT');
	}

	/**
	 * Responds to request to DELETE /test
	 */
	public function deleteTest()
	{
		return new Response('DELETE');
	}

	/**
	 * Responds to request to PATCH /test
	 */
	public function patchTest()
	{
		return new Response('PATCH');
	}

	/**
	 * Responds to request to OPTIONS /test
	 */
	public function optionsTest()
	{
		return new Response('OPTIONS');
	}

	/**
	 * Responds to request to ANYTHING on /test
	 */
	public function matchTest()
	{
		return new Response('MATCH');
	}

	/**
	 * Post with two parameters example
	 * Responds to request to POST /login{username}/{password}
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}

	/**
	 * Example of Parameter injection
	 * Responds to request to GET /injection
	 */
	public function getInjection(Application $app, Request $request)
	{
		$app['injection_test'] = true;
		return new Response($request->getRequestUri());
	}

	/**
	 * Responds to request to GET /bind-example
	 *
	 * {@link http://silex.sensiolabs.org/doc/providers/url_generator.html#usage}
	 */
	public function getBindExample(Application $app, $bind = 'bind_example')
	{
		//You can use ABSOLUTE_URL or ABSOLUTE_PATH
		return new Response($app['url_generator']->generate('bind_example', array(), UrlGeneratorInterface::ABSOLUTE_PATH));
	}

	/**
	 * Responds to request to GET /before-middleware
	 */
	public function getBeforeMiddleware()
	{
		return new Response('You Can\'t See Me');
	}

	/**
	 * Responds to request to GET /after-middleware
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
