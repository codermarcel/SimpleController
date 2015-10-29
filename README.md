# SimpleController
Convinient and simple silex controller using reflection

#Installation

Run the following command:

```shell
composer require _name_
```

#Usage

## Setup

**Humanize**

```php
use _name_;

class MyExampleControllerExtend extends SimpleController
{
	/**
	 * GET example
	 */
	public function getTest()
	{
		return new Response('GET');
	}
}
```
