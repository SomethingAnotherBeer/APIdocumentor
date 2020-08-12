<?php 
namespace App;

class App
{
	public static function main(){
		try{
			$route = new Services\Route();
			$controller_params = $route->getRoute($_SERVER['REQUEST_URI']);
			Includes\DB::setConnection('localhost','your_db_name','root','your_password');
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