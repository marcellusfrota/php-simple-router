<?php 

use PHPUnit\Framework\TestCase;
use App\Route;

final class RouterTest extends TestCase
{    
    public function routeCreationTest()
	{
        $route = new Route;
		$this->assertTrue($route instanceof Route);
    }
}
