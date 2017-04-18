<?php

class Route {

	static function start(){

		$controller = 'home';
		$action = 'index';

		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if ( !empty($routes[1]) ){
			$controller = explode('?', $routes[1]);
			$controller = $controller[0];
		}

		if ( !empty($routes[2]) ){
			$action = $routes[2];
		}

		$model = 'Model_'.$controller;
		$controller = 'Controller_'.$controller;

		$model_file = strtolower($model).'.php';
		$model_path = "app/models/".$model_file;
		if(file_exists($model_path)) {
			include "app/models/".$model_file;
		}

		$controller_file = strtolower($controller).'.php';
		$controller_path = "app/controllers/".$controller_file;

		if(file_exists($controller_path)){
			include "app/controllers/".$controller_file;
		} else {
			Route::ErrorPage404();
		}

		$controller = new $controller;
		
		if(method_exists($controller, $action)){
			$controller->$action();
		} else {
			Route::ErrorPage404();
		}
	}

	function ErrorPage404(){

        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }
    
}
