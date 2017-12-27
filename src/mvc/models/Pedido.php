<?php 
namespace App\models;

class Pedido
{

	private $name;
	private $value;

	public function __construct()
	{

		$this->name = "Hello";
		$this->value = "no value...";
	}

	public function __toString()
	{

		return "Name: {$this->name} <br> Value: {$this->value}";
	}
}