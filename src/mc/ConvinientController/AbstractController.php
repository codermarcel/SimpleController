<?php
namespace Mc\ConvinientController;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * Abstract Convinient-based Reflection Controller for Silex.
 * Based upon -> https://gist.github.com/igorw/4524636
 */
class AbstractController implements ControllerProviderInterface
{
	/**
	 * You might want to know about some of the arrays here..
	 */
    private $class;
    private $collection;
    private $whitelist_class = ['Silex\Application', 'Symfony\Component\HttpFoundation\Request'];
    private $custom_args = ['bind', 'priority'];
    private $middleware_methods = ['before', 'after', 'finish'];
    private $route_methods = ['get', 'post', 'put', 'delete', 'match'];

    function __construct($class = null)
    {
        $this->class = is_null($class) ? get_called_class() : $class;
    }

    /**
     * The magic happens in here
     */
    function connect(Application $app)
    {
        $this->collection = $app['controllers_factory'];
        $reflector = new \ReflectionClass($this->class);
        $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $methodName = $method->getName();

            if (!preg_match('/^(get|post|put|delete|match|before|after|finish)(.+)$/', $methodName, $matches)) {
                continue;
            }

            $parameters = $reflector->getMethod($methodName)->getParameters();
            $collection_class = $this->class . '::' . $matches[0];
            $collection_method = $matches[1];
            $collection_route = $this->adjustRoute($parameters, $matches[2]);

				if ($this->isMiddleware($collection_method))
                {
                    $this->addMiddleware($collection_method, $collection_class, $this->getPriorityValue($parameters));
                }else {
                    $this->addRoute($collection_method, $collection_class, $collection_route, $this->getBindValue($parameters));
                }
	        }

        return $this->collection;
    }

    /**
     * Checks whether or not the method is a middleware or not ( before|after|finish )
     *
     * @param mixed $method  the method to check
     * @return boolean true|false
     */
    private function isMiddleware($method)
    {
        if ($method === 'before' || $method === 'after' || $method === 'finish')
        {
            return true;
        }

        return false;
    }

    /**
     * Add a middleware to the collection
     *
     * for some reason passing the priority as the second argument doesn't change the execution
     * order and i am not sure why. http://silex.sensiolabs.org/doc/middlewares.html
     *
     * @param mixed $method  the method of the route 					 (example : get|post|put|delete|match)
     * @param mixed $class   the class and method name to call 			 (example : App\Controllers\ControllerName::postLogin)
     */
    private function addMiddleware($method, $class, $priority = null)
    {
        if (is_null($priority))
        {
            $this->collection->$method($class);
        }else {
            $this->collection->$method($class);
            //$this->collection->$method($class, $priority);
        }
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
     * @param mixed $parameters  the method parameters to check for the bind value/name
     */
    private function getBindValue($arguments)
    {
        return $this->getValue('bind', $arguments);
    }

    /**
     * Get the 'priority' value which is passed as a parameter to the controller method
     * @param mixed $parameters  the method parameters to check for the priority value
     */
    private function getPriorityValue($arguments)
    {
        return $this->getValue('priority', $arguments);
    }

    /**
     * Get the parameter value of a specified parameter name
     * @param mixed $parameters  the method parameters to check for the priority value
     */
    private function getValue($name, $arguments, $default = null)
    {
        foreach($arguments as $arg)
        {
            if ($arg->name === $arg)
            {
                return $arg->getDefaultValue();
            }
        }

        return $default;
    }

    /**
     * adjust the route based on the input arguments
	 *
	 * @param mixed $arguments  the arguments to check for
	 * @param mixed $path 		the path that needs to be adjusted to a route
	 *
	 * @return string 			the route that was generated based on the input arguments and path
     */
    private function adjustRoute($arguments, $path)
    {
        $path = lcfirst($path);
        $path = ('index' === $path) ? '' : $path;
        $path = '/'.$path;

        foreach($arguments as $arg)
        {
            $name = !is_null($arg->getClass()) ? $arg->getClass()->getName() : null;

            if (!in_array($name, $this->whitelist_class))
            {
                $path = $path . '/{' . $arg->name . '}';
            }
        }

        return $path;
    }

}
