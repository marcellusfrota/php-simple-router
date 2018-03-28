<?php 
namespace Router;

interface RouterInterface
{

	/**
	 * Application-supported methods
	 */
	const METHOD_GET    = 'GET';
	const METHOD_POST   = 'POST';
	const METHOD_PUT    = 'PUT';
	const METHOD_DELETE = 'DELETE';

	/**
	 * Method post
	 */
	public function post($url, $args);

	/**
	 * Method get
	 */
	public function get($url, $args);

	/**
	 * Method delete
	 */
	public function delete($url, $args);

	/**
	 * Method put
	 */
	public function put($url, $args);

}