<?php 
namespace App;

use App\Route;
use App\RouterInterface;

class Router implements RouterInterface
{
    private $routes = Array();
    
    /**
     * @param String $uri
     * @return
     */
    public function get()
    {

    }

    /**
     * @param String $uri
     * @return
     */
    public function post()
    {

    }

    /**
     * @param String $uri
     * @return
     */
    public function put()
    {

    }

    /**
     * @param String $uri
     * @return
     */
    public function delete()
    {

    }

    /**
     * Method executes all routes
     * 
     * @return
     */
    public function exec()
    {

    }

    public function __destruct()
    {
        $this->exec();
    }
}
