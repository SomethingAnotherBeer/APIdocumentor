<?php 
namespace App\Services;

class Route
{
	private $uri;
	private static $singletone_check_couter = 0;
	private $routes = [
		'/authorization'=>['controller'=>'Authorization','action'=>'authorize'],
		'/registration'=>['controller'=>'Registration','action'=>'regist'],
		'/documents/getdocuments'=>['controller'=>'Documents','action'=>'getDocuments'],
		'/documents/getdocument'=>['controller'=>'Documents','action'=>'getDocument'],
		'/documents/createdocument'=>['controller'=>'Documents','action'=>'createDocument'],
		'/documents/deletedocument'=>['controller'=>'Documents','action'=>'deleteDocument'],
		'/documents/editdocument'=>['controller'=>'Documents','action'=>'editDocument']
	];

	public function __construct(){
		if(self::$singletone_check_couter == 1) throw new \Exception("Класc Route может иметь только один экземпляр");
		self::$singletone_check_couter++;
	}

	public function __get($key){
		if(array_key_exists($key, $this->routes)){
			Messanger::display(['Content-Type: application/json','HTTP/1.1 200 OK'],json_encode($this->routes[$key]));
		}
	}

	public function getRoute($uri){
		$this->setRoute($uri);
		return $this->createControllerStringFromRoute($this->uri);

	}

	private function setRoute($uri){
		$this->uri = mb_strtolower($uri);
		$this->uri = $this->prepareUri($this->uri);

	}

	private function prepareUri($uri){
		$new_uri = '';
		for($i = 0;$i<strlen($uri);$i++){
			if($uri[$i]==='?')break;
			$new_uri.=$uri[$i];
		}
		return $new_uri;
	}

	private function createControllerStringFromRoute($uri){
		if($this->checkUri($uri)){
			$controller_string = 'App\\Controllers\\'.$this->routes[$uri]['controller'].'Controller';
			$action_string = $this->routes[$uri]['action'];
			return [$controller_string,$action_string];
		}
		else{
			Messanger::display(['Content-Type: application/json','HTTP/1.1 404 Not Found'],json_encode('Ресурс не найден',JSON_UNESCAPED_UNICODE));
			die();
		}
	}


	private function checkUri($uri){
		if(isset($this->routes[$uri]))return true;
		return false;
	}




}



 ?>