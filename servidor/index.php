<?php
	require_once 'vendor/autoload.php';

	$app = new \Slim\Slim();
	$app->get("/hola/:nombre", function($nombre) use($app){
		echo "Hola ".$nombre;
		var_dump($app->request->params());
	});

	function pruebaMiddle(){
		echo "Soy un Middleware";
	}

	$uri="/api_restful/index.php/api/ejemplo";

	$app->get("/pruebas(/:uno(/:dos))", 'pruebaMiddle', function($uno=NULL,$dos=NULL){
		echo $uno."<br/>";
		echo $dos."<br/>";
	})->conditions(array(
		"uno"=>"[a-zA-Z]*",
		"dos"=>"[0-9]"	
	));

	$app->group("/api", function() use($app,$uri){
		$app->group("/ejemplo", function() use($app,$uri){
			$app->get("/hola/:nombre", function($nombre){
				echo "Hola ".$nombre;
			})->name("Hola");
			$app->get("/dime-tu-apellido/:apellido", function($apellido){
				echo "Apellido ".$apellido;
			});
			$app->get("/mandame-a-hola", function() use($app,$uri){
				//$app->redirect($uri."/hola/luis");
				$app->redirect($app->urlFor("Hola",array("nombre"=>"Luis")));
			});
		});
	});

	$app->run();
?>