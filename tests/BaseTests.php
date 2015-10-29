<?php

namespace Codermarcel\SimpleController\Tests;

use Codermarcel\SimpleController\SimpleController;
use Codermarcel\SimpleController\Tests\MyExampleController;
use Silex\WebTestCase;

abstract class BaseTests extends WebTestCase
{
	/**
	 * Test the index
	 */
	public function testIndex()
	{
		$client = $this->createClient();
		$crawler = $client->request('GET', '/');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('INDEX', $result);
	}

	/**
	 * Test the GET method
	 */
	public function testGetMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('GET', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('GET', $result);
	}

	/**
	 * Test the POST method
	 */
	public function testPostMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('POST', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('POST', $result);
	}

	/**
	 * Test the PUT method
	 */
	public function testPutMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('PUT', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('PUT', $result);
	}

	/**
	 * Test the DELETE method
	 */
	public function testDeleteMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('DELETE', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('DELETE', $result);
	}

	/**
	 * Test the PATCH method
	 */
	public function testPatchMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('PATCH', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('PATCH', $result);
	}

	/**
	 * Test the OPTIONS method
	 */
	public function testOptionsMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('OPTIONS', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('OPTIONS', $result);
	}

	/**
	 * Test the MATCH method
	 */
	public function testMatchMethod()
	{
		$client = $this->createClient();
		$crawler = $client->request('MATCH', '/test');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('MATCH', $result);
	}

	/**
	 * Test the route binding
	 */
	public function testBind()
	{
		$client = $this->createClient();
		$crawler = $client->request('GET', '/bind-example');
		$result = $client->getResponse()->getContent();
		$this->assertEquals('/bind-example', $result);
	}

	/**
	 * Test route with two parameters
	 */
	public function testParameters()
	{
		$username = 'marcel';
		$password = 'secret_password';
		$client = $this->createClient();
		$crawler = $client->request('POST', "/login/$username/$password");
		$result = $client->getResponse()->getContent();
		$this->assertEquals(sprintf('Trying to log in with username: %s and password: %s', $username, $password), $result);
	}

	/**
	 * Test route with two parameters
	 */
	public function testInjection()
	{
		$client = $this->createClient();
		$crawler = $client->request('GET', '/injection');
		$result = $client->getResponse()->getContent();

		$this->assertTrue($this->app['injection_test']);
		$this->assertEquals('/injection', $result);

		$this->app['injection_test'] = null;
	}

	/**
	 * Test the before middleware
	 */
	public function testBeforeMiddleware()
	{
		$mycleint = $this->createClient();
		$crawler = $mycleint->request('GET', '/before-middleware');
		$result = $mycleint->getResponse()->getContent();
		$this->assertEquals('YOU SHALL NOT PASS', $result);
	}

	/**
	 * Test the after middleware
	 */
	public function testAfterMiddleware()
	{
		$mycleint = $this->createClient();
		$crawler = $mycleint->request('GET', '/after-middleware');
		$result = $mycleint->getResponse()->getContent();
		$this->assertEquals('route content | after-middleware content', $result);
	}
}
