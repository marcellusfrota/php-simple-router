<?php 
namespace Router;

use Router\Route;
use Router\RouterInterface;

class Router implements RouterInterface
{

	protected $routes;
	protected $url;
	protected $path;

	private $debug;

	/**
	 * Registra a url requisitada na página e o seu método.
	 * @param $debugValue - Pode ser definido na hora de instanciar o objeto no arquivo
	 * routes.php
	 * 
	 */
	public function __construct($debugValue = false)
	{

		$this->path = "/";

		if(isset($_SERVER['PATH_INFO']))
		{
			$this->path = $_SERVER['PATH_INFO'];
		}
		
		$this->url['request_url'] = explode("/", parse_url($this->path, PHP_URL_PATH));
		$this->url['request_method'] = $_SERVER['REQUEST_METHOD'];

		$this->routes = array();

		/**
		 * Para visualizar todas as suas rotas cadastradas e a requisição da tora mãe
		 * basta alterar o debug para 'true'
		 * 
		 */
		$this->debug = $debugValue;
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método post.
	 * 
	 */
	public function post($url, $args)
	{

		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_POST);

	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do método get.
	 * 
	 */
	public function get($url, $args)
	{

		$args = explode("@", $args);
		$uri = explode("/", $url);
		$this->routes[$url] = new Route($args[0], $args[1], $uri, self::METHOD_GET);

	}

    /**
	 * Cao sejá necessario o debug das rotas basta deixar 'true' o atributo 'debug' dentro do
	 * método construtor da classe.
	 * 
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
	 * Verifica se o método da rota é igual ao método de acesso a página.
	 * @return boolean
	 * 
	 */
    private function checkMethod($routeCreated, $routeRequested)
    {

    	if($routeCreated->getRequestMethod() == $routeRequested['request_method'])
    	{
    		return true;
    	}

    	return false;
    }

    /**
     * Verifica se o tamanho do array da url é igual ao da página.
     * @return boolean
     * 
     */
    private function checkQuantity($routeCreated, $routeRequested)
    {

    	if(count($routeCreated->getRequestUrl()) == count($routeRequested['request_url']))
    	{
    		return true;
    	}

    	return false;
    }

    private function analyzeRoute($route)
    {

    	for($i = 0;$i < count($route->getRequestUrl()); $i++){ 

			/**
			 * Verifica se os valores das url da página e da url cadastrada são
			 * iguais.
			 * 
			 */
			if($route->getRequestUrl()[$i] == $this->url['request_url'][$i]){

				/**
				 * Verifica se está no fim do loop que percore as urls
				 * 
				 */
				if($i == count($route->getRequestUrl())-1){	

					$class = "App\\controllers\\{$route->getController()}";				
					call_user_func([new $class(), $route->getMethod()], @$route->getParam());	

					if($this->debug){

						$this->debug();	
					}
				}
			}else{

				/**
				 * Verifica se a posição do array cadastrado é para receber um parametro
				 * 
				 */
				if(strstr($route->getRequestUrl()[$i], '{')){

					$nameParameter = str_replace(["{", "}"], '', $route->getRequestUrl()[$i]);
					$route->setParam($nameParameter, $this->url['request_url'][$i]);

					/**
					 * Verifica se está no fim do loop que percore as urls
					 * 
					 */
					if($i == count($route->getRequestUrl())-1){

						$class = "App\\controllers\\{$route->getController()}";				
						call_user_func([new $class(), $route->getMethod()], @$route->getParam());


						if($this->debug){

							$this->debug();	
						}	
					}

				/**
				 * Execulta o break caso o valor dos arrays na posição x seja 
				 * divergentes e não seja prepara para receber um parâmetro
				 * 
				 */
			}else{

					/**
					 * Limpa os parametros adicionados na rota.
					 * 
					 */
					$route->unsetParms();

					/**
					 * Para a verificação de toda a url.
					 * 
					 */
					break;
				}								 							
			}
		}
	}

	/**
	 * Método que execulta a bateria de funções que verifica a rota,
	 * Criado também para os testes
	 * 
	 */
	private function run()
	{

		/**
		 * Percorre todas as rotas cadastradas no arquivo routes.php
		 * 
		 */		
		foreach ($this->routes as &$route) {

			if($this->checkMethod($route, $this->url) && $this->checkQuantity($route, $this->url)){	

				/**
				 * Percorre a url cadastrar.
				 * 
				 */
				$this->analyzeRoute($route);					
				
			}							
		}
	}

	/**
	 * O método __destruct é execultado para verificar se a url requisita está registrada nas 
	 * rotas e assim realizar a execulção do método da classe solicitada.
	 * 
	 */
	public function __destruct()
	{

		$this->run();
	}
}