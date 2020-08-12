<?php 
namespace App;

class App
{
	public static function main(){
		try{
			$route = new Services\Route();
			$controller_params = $route->getRoute($_SERVER['REQUEST_URI']);
			Includes\DB::setConnection('localhost','test11','root','12345qqqwww');
			$controller = new $controller_params[0];
			$controller->{$controller_params[1]}();


		}

		catch(\Exception $e){
			echo $e->getMessage();
			die();
		}
	}
}


 ?>