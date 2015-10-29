<?php
namespace SimpleController;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * Convinient and simple silex controller using reflection
 * Inspired by -> {@link https://gist.github.com/igorw/4524636}
 */
class SimpleController implements ControllerProviderInterface
{
	/**
	 * Supported SimpleController methods
     * @var const
	 */
    const ROUTE_METHOD_GET = 'get';
    const ROUTE_METHOD_POST = 'post';
    const ROUTE_METHOD_PUT = 'put';
    const ROUTE_METHOD_DELETE = 'delete';
    const ROUTE_METHOD_MATCH = 'match';
    const MIDDLEWARE_METHOD_BEFORE = 'before';
    const MIDDLEWARE_METHOD_AFTER = 'after';

    private $app;
    private $class;
    private $collection;
    private $whitelist = ['bind' ,'Silex\Application', 'Symfony\Component\HttpFoundation\Request'];

    /**
     * @param stdClass $class
     * @return void
     */
    function __construct($class = null)
    {
        $this->class = is_null($class) ? get_called_class() : $class;
    }

    /**
     * The magic happens in here
     * @return void
     */
    function connect(Application $app)
    {
        $this->collection = $app['controllers_factory'];
        $reflector = new \ReflectionClass($this->class);
        $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method)
        {
            $methodName = $method->getName();

            if (!preg_match('/^(get|post|put|delete|match|before|after)(.+)$/', $methodName, $matches)) {
                continue;
            }

            $parameters = $reflector->getMethod($methodName)->getParameters();
            $collection_class = $this->class . '::' . $matches[0];
            $collection_method = $matches[1];
            $collection_route = $this->adjustRoute($parameters, $matches[2]);

			if ($this->isMiddleware($collection_method))
            {
                $this->collection->$collection_method($collection_class);
            }else {
                $this->addRoute($collection_method, $collection_class, $collection_route, $this->getBindValue($parameters));
            }
	    }

        return $this->collection;
    }

    /**
     * Checks whether or not the method is a middleware or not ( before|after )
     *
     * @param mixed $method  the method to check
     * @return boolean true|false
     */
    private function isMiddleware($method)
    {
        if ($method === self::MIDDLEWARE_METHOD_BEFORE || $method === self::MIDDLEWARE_METHOD_AFTER)
        {
            return true;
        }

        return false;
    }

    /**
     * Add a route to the collection
     *
     * @param mixed $method  the method of the route 					 (example : get|post|put|delete|match)
     * @param mixed $class   the class and method name to call 			 (example : App\Controllers\ControllerName::postLogin)
     * @param mixed $path    the path that silex will route to 			 (example : login/{username}/{password})
     * @param mixed $bind    the name that should be bound to the route  (example : login)
     *
     * @return void
     */
    private function addRoute($method, $class, $path, $bind = null)
    {
        if (is_null($bind))
        {
            $this->collection->$method($path, $class);
        }else {
            $this->collection->$method($path, $class)->bind($bind);
        }
    }

    /**
     * Get the 'bind' name which is passed as a parameter to the controller method
     * @param mixed $parameters  the method parameters to check for the bind name
     * @return string
     */
    private function getBindValue($arguments)
    {
        return $this->getValue('bind', $arguments);
    }

    /**
     * Get the parameter value of a specified parameter name
     * @param mixed $parameters  the method parameters to check for the priority value
     * @return mixed string|$default
     */
    private function getValue($name, $arguments, $default = null)
    {
        foreach($arguments as $arg)
        {
            if ($arg->name === $name)
            {
                return $arg->getDefaultValue();
            }
        }

        return $default;
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    private function getSnakeCase($value, $delimiter = '_')
    {
        if (! ctype_lower($value)) {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value));

            $value = preg_replace('/\s+/', '', $value);
        }

        return $value;
    }

    /**
     * Adjust the route based on the input arguments
	 *
	 * @param mixed $arguments  the arguments to check for
	 * @param mixed $path 		the path that needs to be adjusted to a route
	 * @return string 			the route that was generated based on the input arguments and path
     */
    private function adjustRoute($arguments, $path)
    {
        $path = $this->getSnakeCase($path, '-');
        $path = ('index' === $path) ? '' : $path;
        $path = '/'.$path;

        foreach($arguments as $arg)
        {
            $name = !is_null($arg->getClass()) ? $arg->getClass()->getName() : $arg->getName();

            if (!in_array($name, $this->whitelist))
            {
                $path = $path . '/{' . $arg->name . '}';
            }
        }

        return $path;
    }
}
