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
	 * 
	 */
	public function __construct()
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
		$this->debug = false;
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
	 * O método __destruct é execultado para verificar se a url requisita está registrada nas 
	 * rotas e assim realizar a execulção do método da classe solicitada.
	 * 
	 */
	public function __destruct()
	{

		/**
		 * Percorre todas as rotas cadastradas no arquivo routes.php
		 * 
		 */		
		foreach ($this->routes as &$route) {

			/**
			 * Verifica se o método da rota é igual ao método de acesso a página.
			 * 
			 */
			if($route->getRequestMethod() == $this->url['request_method']){		
			
				/**
				 * Verifica se o tamanho do array da url é igual ao da página.
				 * 
				 */
				if(count($this->url['request_url']) == count($route->getRequestUrl())){
											
					/**
					 * Percorre a url cadastrar.
					 * 
					 */
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
								$route->unsetParm();

								/**
								 * Para a verificação de toda a url.
								 * 
								 */
								break;
							}								 							
						}
					}
				}
			}							
		}

		/**
		 * Cao sejá necessario o debug das rotas basta deixar 'true' o atributo 'debug' dentro do
		 * método construtor da classe.
		 * 
		 */
		if($this->debug)
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
	}
}