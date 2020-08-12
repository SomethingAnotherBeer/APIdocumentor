<?php 
namespace App\Controllers;
abstract class MainController
{
	protected $request_body;
	protected $request_method;
	protected $headers = [];
	public function __construct(){
		$this->headers[] = 'Content-Type: application/json';
		$this->request_method = $_SERVER['REQUEST_METHOD'];
	}

	protected function getParams(){
		return $request = json_decode(file_get_contents("php://input"),true);
		
	}

	protected function checkParams($request, array $needle){
		if(!is_array($request))return 0;
		if(empty($needle))return 0;
		foreach ($needle as $key){
			if(!array_key_exists($key, $request))return 0;
		}
		return true;
	}

	protected function setHeaders(array $headers){
		foreach($headers as $header){
			$this->headers[] = $header;
		}
	}

	
}



 ?>