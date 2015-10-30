#SimpleController

SimpleController is a convenient reflection based controller for the [php micro-framework silex]
(http://silex.sensiolabs.org/)
SimpleController makes it easy for you to use controllers in your silex applications and matches your controller methods to routes automatically</br>


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
	 * Responds to requests to GET /
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

If you don't want to extend the SimpleController class, then you can use a raw class as well.


```php
class MyExampleControllerRaw
{
	/**
	 * Responds to requests to GET /
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

The method names should begin with the HTTP verb they respond to followed by the route name. </br>
The following methods are available :

- get
- post
- put
- delete
- patch
- options
- match

#### below are some examples

```php
class MyExampleControllerRaw
{
	/**
	 * Responds to requests to GET /
	 */
	public function getIndex()
	{
		//
	}

	/**
	 * Responds to requests to GET /test
	 */
	public function getTest()
	{
		//
	}

	/**
     * Responds to requests to GET /show/{id}
     */
    public function getShow($id)
    {
        //
    }

    /**
     * Responds to requests to GET /admin-profile
     */
    public function getAdminProfile()
    {
        //
    }

    /**
     * Responds to requests to POST /profile
     */
    public function postProfile()
    {
        //
    }

}
```

### Organizing Controllers

"When your application starts to define too many controllers, you might want to group them logically:"

"mount() prefixes all routes with the given prefix and merges them into the main Application. So, / will map to the main home page, /blog/ to the blog home page, and /forum/ to the forum home page."

For more information on Organizing Controllers, please take a look at the offical [silex documentation] (http://silex.sensiolabs.org/doc/organizing_controllers.html#organizing-controllers)

#### Example 1

```php
$app->mount('/', new App\Controllers\MyExampleControllerExtended());
```

```php
use Codermarcel\SimpleController\SimpleController;;

class MyExampleControllerExtended extends SimpleController
{
	/**
	 * Responds to request to GET /
	 */
	public function getIndex()
	{
		//
	}

	/**
	 * Responds to request to GET /login-page
	 */
	public function getLoginPage()
	{
		//
	}
}
```

#### Example 2

```php
$app->mount('/user', new App\Controllers\MyExampleControllerExtended());
```

```php
use Codermarcel\SimpleController\SimpleController;;

class MyExampleControllerExtended extends SimpleController
{
	/**
	 * Responds to request to GET /user/
	 */
	public function getIndex()
	{
		//
	}

	/**
	 * Responds to request to GET /user/home-page
	 */
	public function getHomePage()
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
	 * Responds to requests to POST /login{username}/{password}
	 */
	public function postLogin($username, $password)
	{
		return sprintf('Trying to log in with username: %s and password: %s', $username, $password);
	}
}
```

### Request and Application injection

You can also ask for the current Request and Application objects like this:</br>

**Note** silex does the injection based on the type hinting and not on the variable name! </br>


```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;

	/**
	 * Responds to requests to GET /injection
	 */
	public function getInjection(Application $app, Request $request)
	{
		//
	}
}
```


### Named routes

You can bind a route name to your routes by using the $bind parameter in your routes like this:

For more information on named route and the UrlGeneratorServiceProvider please take a look at the [offical silex documentation] (http://silex.sensiolabs.org/doc/providers/url_generator.html#urlgeneratorserviceprovider)

```php
class MyExampleControllerRaw
{
	use Silex\Application;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

	/**
	 * Responds to requests to GET /bind-example
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

< Silex allows you to run code, that changes the default Silex behavior, at different stages during the handling of a request through middlewares: </br>
< […] </br>
< Route middlewares are triggered when their associated route is matched. </br>

For more information about middlewares, please take a look at the offical [silex documentation] (http://silex.sensiolabs.org/doc/middlewares.html#middlewares) </br>

**Note** You can typehint the Request, Response or Application object and **silex** will inject them for you.

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
	public function afterSomeRandomNameThatDoesntMatter(Request $request, Response $response, Application $app)
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
https://gist.github.com/igorw/4524636 </br>
And http://laravel.com/docs/5.1/controllers#implicit-controllers </br>
