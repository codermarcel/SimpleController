# SimpleController
Convinient and simple silex controller using reflection
Inspired by https://gist.github.com/igorw/4524636

#Installation

Run the following command:

```shell
composer require codermarcel/simple-controller
```

#Setup

SimpleController has two simple methods to use.
You can either extend the SimpleController class, or use a raw class and mount it using the SimpleController class
See below for more details

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

