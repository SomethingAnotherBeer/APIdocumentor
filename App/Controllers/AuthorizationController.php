<?php 
namespace App\Controllers;
use App\Includes;
use App\Services;

class AuthorizationController extends ServiceController
{
	public function authorize(){
		if($this->request_method != 'POST')return 0;
		$this->request_body = $this->getParams();
		if(!$this->checkParams($this->request_body,['login','password'])){
			$this->setHeaders(['HTTP/1.1 Bad Request']);
			Services\Messanger::display($this->headers,json_encode('Ошибка передачи: Ожидаемый запрос отличается от фактического',JSON_UNESCAPED_UNICODE));
			return 0;
		}
		$authorization = new Services\Authorization(Includes\DB::getConnection(),$this->request_body);
		$response = $authorization->authorize();
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));


	}

	
}



 ?>