<?php 
namespace Router;

class Router
{

	private $routes;
	private $debug;
	private $url;
	private $path;

	/**
	 * Registra a url requisitada na página e o seu metodo.
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
		$this->debug = false;
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do metodo post.
	 * 
	 */
	public function post($url, $args)
	{

		$args = explode("@", $args);

		$this->routes[$url] = array(
			'controller' => $args[0], 
			'method' => $args[1], 
			'request_url' => explode("/", $url),

			'request_method' => 'POST'
		);
	}

	/**
	 * Cadastra uma rota do que pode ser acessada atravez do metodo get.
	 * 
	 */
	public function get($url, $args)
	{

		$args = explode("@", $args);

		$this->routes[$url] = array(
			'controller' => $args[0], 
			'method' => $args[1], 
			'request_url' => explode("/", $url),

			'request_method' => 'GET'
		);
	}

	/**
	 * O metodo __destruct é execultado para verificar se a url requisita está registrada nas 
	 * rotas e assim realizar a execulção do metodo da classe solicitada.
	 * 
	 */
	public function __destruct()
	{

		/**
		 * Percorre todas as rotas cadastradas no arquivo routes.php
		 * 
		 */		
		foreach ($this->routes as $route => &$attributes) {

			/**
			 * Verifica se o metodo da rota é igual ao método de acesso a página.
			 * 
			 */
			if($attributes['request_method'] == $this->url['request_method']){		
			
				/**
				 * Verifica se o tamanho do array da url é igual ao da página.
				 * 
				 */
				if(count($this->url['request_url']) == count($attributes['request_url'])){
											
					/**
					 * Percorre a url cadastrar.
					 * 
					 */
					for($i = 0;$i < count($attributes['request_url']); $i++){ 


						/**
						 * Verifica se os valores das url da página e da url cadastrada são
						 * iguais.
						 * 
						 */
						if($attributes['request_url'][$i] == $this->url['request_url'][$i]){

							/**
							 * Verifica se está no fim do loop que percore as urls
							 * 
							 */
							if($i == count($attributes['request_url'])-1){	

								$class = "App\\controllers\\{$attributes['controller']}";				
								call_user_func([new $class(), $attributes['method']], @$attributes['params']);		
							}
						}else{

							/**
							 * Verifica se a posição do array cadastrado é para receber um parametro
							 * 
							 */
							if(strstr($attributes['request_url'][$i], '{')){
								$nameParameter = str_replace(["{", "}"], '', $attributes['request_url'][$i]);
								$attributes['params'][$nameParameter] = $this->url['request_url'][$i];

								/**
								 * Verifica se está no fim do loop que percore as urls
								 * 
								 */
								if($i == count($attributes['request_url'])-1){

									$class = "App\\controllers\\{$attributes['controller']}";				
									call_user_func([new $class(), $attributes['method']], @$attributes['params']);
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
								unset($attributes['params']);

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
		 * Cado sejá necessario o debug das rotas basta deixar 'true' o atributo 'debug' dentro do
		 * metodo construtor da classe.
		 * 
		 */
		if($this->debug)
		{

			echo "<pre>";
			print_r($this->url);
			echo "<br><hr></br>";
			print_r($this->routes);
			echo "</pre>";
		}
	}
}