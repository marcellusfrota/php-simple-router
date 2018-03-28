<?php 
namespace Router;

use Router\Route;
use Router\RouterInterface;

class Router implements RouterInterface
{

	/**
	 * Array of rotated objects.
	 * @var array
	 */
	private $routes;

	/**
	 * Requested route.
	 * @var object
	 */
	private $requestedRoute;

	/**
	 * Control application debug.
	 * @var boolean
	 */
	private $debug;

	/**
	 * Register the requested url on the page.
	 * @param $debugValue
	 */
	public function __construct($debug = false)
	{
		$path = "/";
		$this->requestedRoute = new Route();
		
		if(isset($_SERVER['PATH_INFO'])){
			$path = $_SERVER['PATH_INFO'];
		}

		if(isset($_SERVER['REQUEST_METHOD'])){
			$this->requestedRoute->setRequestMethod($_SERVER['REQUEST_METHOD']);
		}
		
		$this->requestedRoute->setRequestUrl(explode("/", parse_url($path, PHP_URL_PATH)));

		$this->routes = array();
		$this->debug = $debug;
	}

	/**
	 * Register a route that can be accessed through the post method.
	 * @return void
	 */
	public function post($url, $args)
	{
		$this->registerRoute($url, $args, self::METHOD_POST);
	}

	/**
	 * Register a route that can be accessed through the get method.
	 * @return void
	 */
	public function get($url, $args)
	{
		$this->registerRoute($url, $args, self::METHOD_GET);
	}

	/**
	 * Register a route that can be accessed through the delete method.
	 * @return void
	 */
	public function delete($url, $args)
	{
		$this->registerRoute($url, $args, self::METHOD_DELETE);
	}

	/**
	 * Register a route that can be accessed through the put method.
	 * @return void
	 */
	public function put($url, $args)
	{
		$this->registerRoute($url, $args, self::METHOD_PUT);
	}

	/**
	 * Register a route.
	 * @return void
	 */
	private function registerRoute($url, $args, $method)
	{
		$uri = explode("/", $url);
		$args = explode("@", $args);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, $method);
	}

	/**
	 * Verifies that the route method is the same as the page access method.
	 * @return boolean
	 */
	private function checkMethods($routeCreated)
	{	
		if($this->validMethod($routeCreated) && $this->validMethod($this->requestedRoute)){
			if($routeCreated->getRequestMethod() == $this->requestedRoute->getRequestMethod()){
				return true;
			}
		}

		return false;
	}

	/**
	* Checks if the size of the url array is the same as the page size.
	* @return boolean
	*/
	private function checkQuantity($routeCreated)
	{	
		if(count($routeCreated->getRequestUrl()) == count($this->requestedRoute->getRequestUrl())){
			return true;
		}

		return false;
	}

	/**
	 * Check route methods.
	 * @return boolean
	 */
	private function validMethod($route)
	{		
		if($route->getRequestMethod() == self::METHOD_GET 
			|| $route->getRequestMethod() == self::METHOD_POST
			|| $route->getRequestMethod() == self::METHOD_DELETE
			|| $route->getRequestMethod() == self::METHOD_PUT){

			return true;
		}

		return false;
	}

	/**
	 * It traverses the array that contains each 'member' of the route and compares them with the requested route.
	 * @return void
	 */
	private function analyzeRoute($route)
	{	
		for($i = 0;$i < count($route->getRequestUrl()); $i++){ 
			if($route->getRequestUrl()[$i] == $this->requestedRoute->getRequestUrl()[$i]){
				if($i == count($route->getRequestUrl())-1){	
					$class = "App\\controllers\\{$route->getController()}";				
					call_user_func([new $class(), $route->getMethod()], @$route->getParam());	

					if($this->debug){
						$this->debug();	
					}
				}
			}else{

				if(strstr($route->getRequestUrl()[$i], '{')){
					$nameParameter = str_replace(["{", "}"], '', $route->getRequestUrl()[$i]);
					$route->setParam($nameParameter, $this->requestedRoute->getRequestUrl()[$i]);

					if($i == count($route->getRequestUrl())-1){
						$class = "App\\controllers\\{$route->getController()}";				
						call_user_func([new $class(), $route->getMethod()], @$route->getParam());

						if($this->debug){
							$this->debug();	
						}							
					}
				}else{

					$route->unsetParms();
					break;
				}								 							
			}
		}
	}

	/**
	 * If it is necessary to debug the routes, just leave the 'debug' attribute 'true' within the
	 * class constructor method.
	 * @return void
	 */
	private function debug()
	{
		echo "<pre>";
		echo "<br><hr></br>";
		print_r($this->requestedRoute);
		echo "<br><hr></br>";
		print_r($this->routes);	
		echo "<br><hr></br>";
		print_r($_SERVER);
		echo "</pre>";
	}
	
	/**
	 * The __destruct method is executed to check if the url requests are registered in the
	 * routes and thus carry out the execution of the requested class method.
	 */
	public function __destruct()
	{	
		foreach ($this->routes as &$route) {
			if($this->checkMethods($route) && $this->checkQuantity($route)){	

				$this->analyzeRoute($route);					
			}							
		}
	}
}
