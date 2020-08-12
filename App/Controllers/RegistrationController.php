<?php 
namespace App\Controllers;
use App\Includes;
use App\Services;

class RegistrationController extends AuthController
{	private $errors = [];
	public function regist(){
		if($this->request_method != 'POST')return 0;
		$this->request_body = $this->getParams();
		if(!$this->checkParams($this->request_body,['login','password','email','name'])){
			$this->setHeaders(['HTTP/1.1 400 Bad Request']);
			Services\Messanger::display($this->headers,json_encode("Ошибка передачи: Ожидаемый запрос отличается от фактического",JSON_UNESCAPED_UNICODE));
			return 0;
		}
		$this->checkLogin($this->request_body['login']);
		$this->checkPassword($this->request_body['password']);
		$this->checkEmail($this->request_body['email']);

		if(count($this->errors)!=0){
			$this->setHeaders(['HTTP/1.1 Bad Request']);
			Services\Messanger::display($this->headers,json_encode($this->errors,JSON_UNESCAPED_UNICODE));
			return 0;
		}


		$registration = new Services\Registration(Includes\DB::getConnection(),$this->request_body);
		$response = $registration->regist();
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));
	}

	private function checkLogin($login){
		if(strlen($login)<3) $this->errors[] = 'Недопустимая длина логина';
		for($i = 0;$i<strlen($login);$i++){
			if(!in_array(ord($login[$i]), $this->permissible_symbols)){
				$this->errors[] = 'Некорректный логин';
				return 0;
			}
		}
		
	}

	private function checkPassword($password){
		if(strlen($password)<6)$this->errors[] = 'Недопустимая длина пароля';
		for($i = 0;$i<strlen($password);$i++){
			if(!in_array(ord($password[$i]), $this->permissible_symbols)){
				$this->errors[] = 'Некорректный пароль';
				return 0;
			}
		}

	
	}

	private function checkEmail($email){
		if(count(explode('@',$email))!=2)$this->errors[] = 'Значение не является email';
		for($i = strlen($email)-1;$i>0;$i--){
			if($email[$i]==='.')break;
			if($i < strlen($email)-3)return 0;
		}
		$this->permissible_symbols[] = ord('@');
		$this->permissible_symbols[] = ord('.');
		for ($i = 0;$i<strlen($email);$i++){
			if(!in_array(ord($email[$i]), $this->permissible_symbols)){
				$this->errors[] = 'Некорректный email';
				return 0;
			}
		}
	
	}




	
	}










 ?>