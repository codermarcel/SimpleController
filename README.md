# SimpleController
Convinient and simple silex controller using reflection

#Installation

Run the following command:

```shell
composer require codermarcel/simple-controller
```

#Usage

## Setup - 1

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
$app->mount('/', new MyExampleControllerExtended());
```

## Setup - 2

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

**Mount the route**

```php
use SimpleController\SimpleController;

$app->mount('/', new SimpleController('MyExampleControllerRaw'));
```
