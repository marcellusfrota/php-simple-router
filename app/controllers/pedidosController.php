<?php 
namespace App\controllers;


use App\models\Pedido;

class pedidosController
{

	public function sampleIndex()
	{
		$message = "Hello i am a view";
		require __DIR__ . "/../views/indexView.php";
	}

	public function samplePedidoDescription()
	{
		$pedido = new Pedido();
		require __DIR__ . "/../views/indexView.php";
	}

	public function sampleRequest($request)
	{		
		require __DIR__ . "/../views/request.php";
	}

}