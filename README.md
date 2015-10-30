#SimpleController

Convenient and simple silex controller using reflection </br>

#Introduction

SimpleController is a convenient reflection based controller that
matches your controller methods to routes. </br>


#Installation

Run the following command:

```shell
composer require codermarcel/simple-controller
```

# Setup

## Method - 1

### Extending the SimpleController

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

### Mount the route

```php
$app->mount('/', new App\Controllers\MyExampleControllerExtended());
```

## Method - 2

### Using a raw class

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

### Mount the route

**Note** use the full namespace name for your controller class

```php
$app->mount('/', new Codermarcel\SimpleController\SimpleController('App\Controllers\MyExampleControllerRaw'));
```

#Usage

## HTTP methods

The method names should begin with the HTTP verb they respond to followed by the title case version of the URI. </br>
The following methods are available :

- get
- post
- put
- delete
- patch
- options
- match

```php
class MyExampleControllerRaw
{
	/**
	 * Responds to request to GET /
	 */
	public function getIndex()
	{
		//
	}

	/**
	 * Responds to request to GET /test
	 */
	public function getTest()
	{
		//
	}

	/**
	 * Responds to request to POST /test
	 */
	public function postTest()
	{
		//
	}

	/**
	 * Responds to request to PUT /test
	 */
	public function putTest()
	{
		//
	}

	/**
	 * Responds to request to DELETE /test
	 */
	public function deleteTest()
	{
		//
	}

	/**
	 * Responds to request to PATCH /test
	 */
	public function patchTest()
	{
		//
	}

	/**
	 * Responds to request to OPTIONS /test
	 */
	public function optionsTest()
	{
		//
	}

	/**
	 * Responds to request to MATCH /test
	 */
	public function matchTest()
	{
		//
	}
}
```


### Route variables

You can define variable parts in a route like this:


```php
class MyExampleControllerRaw
{
	/**
	 * Post with two parameters example
	 * Responds to request to POST /login{username}/{password}
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}
}
```

### Request and Application injection

You can also ask for the current Request and Application objects like this:</br>
**Note** for the Application and Request objects, SimpleController does the injection based on the type hinting and not on the variable name! </br>


```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;

	/**
	 * Example of Parameter injection
	 * Responds to request to GET /injection
	 */
	public function getInjection(Application $app, Request $request)
	{
		$app['injection_test'] = true;
		return new Response($request->getRequestUri());
	}
}
```


### Named routes

You can bind a route name to your routes by using the $bind parameter in your routes like this:


```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

	/**
	 * Example of binding a name to a route
	 * Responds to request to GET /bind-example
	 *
	 * {@link http://silex.sensiolabs.org/doc/providers/url_generator.html#usage}
	 */
	public function getBindExample(Application $app, $bind = 'bind_example')
	{
		//Example usage of the bind_example route
		//You can use ABSOLUTE_URL or ABSOLUTE_PATH
		return new Response($app['url_generator']->generate('bind_example', array(), UrlGeneratorInterface::ABSOLUTE_PATH));
	}
}
```


## Middleware

"Silex allows you to run code, that changes the default Silex behavior, at different stages during the handling of a request through middlewares: </br>
</br>
[…] </br>
Route middlewares are triggered when their associated route is matched." </br>
</br>
For more information about middleware, please go to the [silex website] (http://silex.sensiolabs.org/doc/middlewares.html#middlewares) </br>

```php
class MyExampleControllerRaw
{
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;

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
```

## Credits
SimpleController was inspired by </br>
Inspired by https://gist.github.com/igorw/4524636 </br>
And http://laravel.com/docs/5.1/controllers#implicit-controllers </br>

## References:

	[1] http://silex.sensiolabs.org/doc/usage.html#other-methods
	[2] http://silex.sensiolabs.org/doc/middlewares.html#middlewares
    [3] http://silex.sensiolabs.org/doc/usage.html#route-variables
    [4] http://silex.sensiolabs.org/doc/usage.html#named-routes
