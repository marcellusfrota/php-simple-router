<?php 
namespace App\models;

class Pedido
{

	private $name;
	private $value;

	public function __construct()
	{

		$this->name = "My name";
		$this->value = 0;
	}

	public function __toString()
	{

		return "Name: {$this->name} <br> Value: {$this->value}";
	}
}