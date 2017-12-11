<?php 
namespace App\controllers;


use App\models\Pedido;

class pedidosController
{

	public function index()
	{
		$message = "Hello i am a view";
		require __DIR__ . "/../views/indexView.php";
	}

	public function pedidoDescription()
	{
		$pedido = new Pedido();
		require __DIR__ . "/../views/indexView.php";
	}

}