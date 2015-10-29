# SimpleController
Convenient and simple silex controller using reflection
Inspired by https://gist.github.com/igorw/4524636

# Introduction

SimpleController is a conv

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
	
	/**
	 * Index example
	 */
	public function getIndex()
	{
		return echo 'Welcome!';
	}
}
```
