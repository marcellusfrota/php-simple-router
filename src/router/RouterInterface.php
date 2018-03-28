<?php 
namespace Router;

interface RouterInterface
{

	/**
	 * Métodos suportados pela aplicação
	 * 
	 */
	const METHOD_GET    = 'GET';
	const METHOD_POST   = 'POST';
	const METHOD_PUT    = 'PUT';
	const METHOD_DELETE = 'DELETE';

	public function post($url, $args);
	public function get($url, $args);
	public function delete($url, $args);
	public function put($url, $args);

}