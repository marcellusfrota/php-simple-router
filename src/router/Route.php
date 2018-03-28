<?php 
namespace Router;

class Route
{

    /**
     * Controller that the route will invoke.
     * @var string
     */
    private $controller;
    
    /**
     * Controller method that will be called.
     * @var string
     */
    private $method;
    
    /**
     * Url registered.
     * @var string[]
     */
    private $request_url;
    
    /**
     * Route method.
     * @var string
     */
    private $request_method;
    
    /**
     * Array that contains all parameters.
     * @var string[]
     */
    private $param;

    /**
     * @param $controller
     * @param $method
     * @param $request_url
     * @param $request_method
     */
    public function __construct($controller = null, $method = null, $request_url = null, $request_method = null)
    {
        $this->controller     = $controller;
        $this->method         = $method;
        $this->request_url    = $request_url;
        $this->request_method = $request_method;
        $this->param          = null;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getRequestUrl()
    {
        return $this->request_url;
    }

    public function setRequestUrl($request_url)
    {
        $this->request_url = $request_url;
    }

    public function getRequestMethod()
    {
        return $this->request_method;
    }

    public function setRequestMethod($request_method)
    {
        $this->request_method = $request_method;
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam($nameParameter, $param)
    {
        $this->param[$nameParameter] = $param;
    }

    public function unsetParms()
    {
      $this->param = null;
  }
}
