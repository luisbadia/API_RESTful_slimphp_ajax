<?php
	require_once 'vendor/autoload.php';

	$app = new \Slim\Slim();

	$db= new mysqli("localhost","root","mysql","api_restful");

	$app->get("/productos", function() use($db,$app){
		$query=$db->query("Select * from productos;");
		$productos=array();
		while ($fila=$query->fetch_assoc()) {
			$productos[]=$fila;
		}
		echo json_encode($productos);
	});

	$app->post("/productos", function() use($db,$app){
		$query="INSERT INTO productos VALUES (NULL,'{$app->request->post("name")}','{$app->request->post("description")}','{$app->request->post("price")}');";
		$insert=$db->query($query);
		if($insert){
			$result=array("status"=>"true","message"=>"Producto creado correctamente");
		}
		else{
			$result=array("status"=>"false","message"=>"Producto no creado correctamente");
		}
		echo json_encode($result);
	});

	$app->put("/productos/:id", function($id) use($db,$app){
		$query="UPDATE productos SET name='{$app->request->post("name")}', description='{$app->request->post("description")}','{$app->request->post("price")}' where id={$id};";
		$update=$db->query($query);
		if($update){
			$result=array("status"=>"true","message"=>"Producto actualizado correctamente");
		}
		else{
			$result=array("status"=>"false","message"=>"Producto no actualizado correctamente");
		}
		echo json_encode($result);
	});

	$app->delete("/productos/:id", function($id) use($db,$app){
		$query="delete from productos where id={$id};";
		$delete=$db->query($query);
		if($delete){
			$result=array("status"=>"true","message"=>"Producto eliminado correctamente");
		}
		else{
			$result=array("status"=>"false","message"=>"Producto no eliminado correctamente");
		}
		echo json_encode($result);
	});

	$app->run();