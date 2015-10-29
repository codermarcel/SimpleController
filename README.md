# SimpleController
Convinient and simple silex controller using reflection

#Installation

Run the following command:

```shell
composer require _name_
```

#Usage

## Setup

**Extending the SimpleController**

```php
use _name_;

class MyExampleController extends SimpleController
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
