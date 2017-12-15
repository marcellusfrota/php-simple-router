<?php 
namespace Router;

interface RouterInterface
{

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	public function post($url, $args);
	public function get($url, $args);

}