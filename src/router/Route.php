<?php 
namespace Router;

class Route
{

    /**
     * Controller que a rota irá invocar
     * @var string
     */
    private $controller;
    
    /**
     * Método do controller que irá ser chamado
     * @var string
     */
    private $method;
    
    /**
     * Url cadastrada
     * @var string[]
     */
    private $request_url;
    
    /**
     * Método dessa rota
     * @var string
     */
    private $request_method;
    
    /**
     * Array que contem todos os parâmetros
     * @var string[]
     */
    private $param;

    /**
     * @param $controller
     * @param $method
     * @param $request_url
     * @param $request_method
     */
    public function __construct($controller, $method, $request_url, $request_method)
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
