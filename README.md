# SimpleController
Convenient and simple silex controller using reflection
Inspired by https://gist.github.com/igorw/4524636
And http://laravel.com/docs/5.1/controllers#implicit-controllers

# Introduction

SimpleController is a convenient reflection based controller that
matches your controller methods to routes take a look at
[laravels implicit-controllers] (http://laravel.com/docs/5.1/controllers#implicit-controllers)
to see more info about it.



#Installation

Run the following command:

```shell
composer require codermarcel/simple-controller
```

#Setup

## Method - 1

**Extending the SimpleController**

```php
use Codermarcel\SimpleController\SimpleController;;

class MyExampleControllerExtended extends SimpleController
{
	/**
	 * Index example
	 */
	public function getIndex()
	{
		return echo 'Welcome!';
	}
}
```

**Mount the route**

```php
$app->mount('/', new App\Controllers\MyExampleControllerExtended());
```

## Method - 2

**Using a raw class**

```php
class MyExampleControllerRaw
{
	/**
	 * Index example
	 */
	public function getIndex()
	{
		return echo 'Welcome!';
	}
}
```

**Mount the route** (use the full namespace name for your controller class)

```php
$app->mount('/', new Codermarcel\SimpleController\SimpleController('App\Controllers\MyExampleControllerRaw'));
```

#Usage

**HTTP methods**

You can use any of the available HTTP methods that you can use with silex,
the following methods are available

- get
- post
- put
- delete
- match

Just prefix your controller method name with one of the http method names and SimpleController will
create the route for you like so:

References:

	[1] http://silex.sensiolabs.org/doc/usage.html#other-methods


```php
class MyExampleControllerRaw
{
	use Symfony\Component\HttpFoundation\Response;

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
}
```


**Route variables**

You can define variable parts in a route like this:

References:

    [1] http://silex.sensiolabs.org/doc/usage.html#route-variables

```php
class MyExampleControllerRaw
{
	/**
	 * Post with two parameters example
	 * Routes to /login{username}/{password}
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}
}
```

**Request and Application injection**

You can also ask for the current Request and Application objects like this:
Note for the Application and Request objects, SimpleController does the injection based on the type hinting and not on the variable name!

References:

    [1] http://silex.sensiolabs.org/doc/usage.html#route-variables

```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;

	/**
	 * Example of Parameter injection
	 * Routes to /injection
	 */
	public function getInjection(Application $app, Request $request)
	{
		$app['injection_test'] = true;
		return new Response($request->getRequestUri());
	}
}
```


**Named routes**

You can bind a route name to your routes by using the $bind parameter in your routes like so:

References:

    [1] http://silex.sensiolabs.org/doc/usage.html#named-routes

```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
}
```
