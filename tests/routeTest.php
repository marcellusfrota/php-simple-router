<?php 

use PHPUnit\Framework\TestCase;

class routeTest extends TestCase
{

	public function testCheckMethods()
	{
		$router = new Router\Router;
		$routeCreated = new Router\Route('myController', 'myMethod', ['/', 'foo' , 'bar'], 'GET');

		$routeRequested['request_url'] = ['/', 'foo', 'bar'];
		$routeRequested['request_method'] = 'GET';

		$this->assertEquals(true, $router->checkMethods($routeCreated, $routeRequested));			
	}

	public function testCheckQuantityUrl()
	{
		$router = new Router\Router;
		$routeCreated = new Router\Route('myController', 'myMethod', ['/', 'foo' , 'bar'], 'GET');

		$routeRequested['request_url'] = ['/', 'foo', 'bar'];
		$routeRequested['request_method'] = 'GET';

		$this->assertEquals(true, $router->checkQuantity($routeCreated, $routeRequested));
	}

	public function testValidMethods()
	{
		$router = new Router\Router;
		$routeCreated = new Router\Route('myController', 'myMethod', ['/', 'foo' , 'bar'], 'GET');

		$routeRequested['request_url'] = ['/', 'foo', 'bar'];
		$routeRequested['request_method'] = 'POST';

		$this->assertEquals(true, $router->validMethod($routeCreated));
		$this->assertEquals(true, $router->validMethod($routeRequested));
	}



}