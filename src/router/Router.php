<?php 
namespace Router;

use Router\Route;
use Router\RouterInterface;

class Router implements RouterInterface
{

	protected $routes;
	protected $url;
	protected $debug;

	/**
	 * Registra a url requisitada na página.
	 * @param $debugValue
	 */
	public function __construct($debug = false)
	{
		$path = "/";
		$this->url['request_method'] = self::METHOD_GET;

		if(isset($_SERVER['PATH_INFO'])){
			$path = $_SERVER['PATH_INFO'];		
		}

		if(isset($_SERVER['REQUEST_METHOD'])){
			$this->url['request_method'] = $_SERVER['REQUEST_METHOD'];		
		}
		
		$this->url['request_url'] = explode("/", parse_url($path, PHP_URL_PATH));

		$this->routes = array();
		$this->debug = $debug;
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método post.
	 * @return void
	 */
	public function post($url, $args)
	{
		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_POST);
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método get.
	 * @return void
	 */
	public function get($url, $args)
	{
		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_GET);
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método delete.
	 * @return void
	 */
	public function delete($url, $args)
	{
		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_DELETE);
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método put.
	 * @return void
	 */
	public function put($url, $args)
	{
		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_PUT);
	}

	/**
	 * Verifica se o método da rota é igual ao método de acesso a página.
	 * @return boolean
	 */
	public function checkMethods($routeCreated, $routeRequested)
	{	
		if($this->validMethod($routeCreated) && $this->validMethod($routeRequested)){
			if($routeCreated->getRequestMethod() == $routeRequested['request_method']){
				return true;
			}
		}

		return false;
	}

	/**
	* Verifica se o tamanho do array da url é igual ao da página.
	* @return boolean
	*/
	public function checkQuantity($routeCreated, $routeRequested)
	{	
		if(count($routeCreated->getRequestUrl()) == count($routeRequested['request_url'])){
			return true;
		}

		return false;
	}

	/**
	 * Verifica os métodos das rotas
	 * @return boolean
	 */
	public function validMethod($route)
	{
		if (is_array($route)) {
			if($route['request_method'] == self::METHOD_GET 
				|| $route['request_method'] == self::METHOD_POST){
			return true;
		}

			return false;
		}

		if($route->getRequestMethod() == self::METHOD_GET 
			|| $route->getRequestMethod() == self::METHOD_POST){
			return true;
		}

		return false;
	}


	/**
	 * Percorre o array que contem cada 'membro' da rota e os compara com a rota requisitada.
	 * @return void
	 */
	public function analyzeRoute($route)
	{	
		for($i = 0;$i < count($route->getRequestUrl()); $i++){ 
			if($route->getRequestUrl()[$i] == $this->url['request_url'][$i]){
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
					$route->setParam($nameParameter, $this->url['request_url'][$i]);

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
	 * Caso seja necessário o debug das rotas basta deixar 'true' o atributo 'debug' dentro do
	 * método construtor da classe.
	 * @return void
	 */
	private function debug()
	{
		echo "<pre>";
		echo "<br><hr></br>";
		print_r($this->url);
		echo "<br><hr></br>";
		print_r($this->routes);	
		echo "<br><hr></br>";
		print_r($_SERVER);
		echo "</pre>";
	}
	
	/**
	 * O método __destruct é executado para verificar se a url requisita está registrada nas 
	 * rotas e assim realizar a execução do método da classe solicitada.
	 */
	public function __destruct()
	{	
		foreach ($this->routes as &$route) {
			if($this->checkMethods($route, $this->url) && $this->checkQuantity($route, $this->url)){	

				$this->analyzeRoute($route);					
			}							
		}
	}
}
