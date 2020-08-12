<?php 
namespace App\Services;

class Authorization extends Service
{	
	private $token;

	public function __construct($connection,$request_data){
		parent::__construct($connection);
		$this->request_data = $request_data;
	}

	public function authorize(){
		if($this->connection->query("SELECT * FROM users WHERE login = '{$this->request_data['login']}' AND password = '{$this->request_data['password']}'")->rowCount()==0)return ['HTTP/1.1 200 OK','Данный пользователь не сушествует'];
		$user_id = $this->connection->query("SELECT id FROM users WHERE login = '{$this->request_data['login']}' AND password = '{$this->request_data['password']}'");
		$user_id = $user_id->fetchColumn();

		while(!$this->checkUserToken($user_id)){
			$this->connection->exec("DELETE FROM tokens WHERE user_id = '$user_id'");
		}

		$token = $this->generateToken();
		while (!$this->checkToken($token)){
			$token = $this->generateToken();
		}
		$this->setToken($token);

		$this->insertToken($user_id,$token);
		return ['HTTP/1.1 201 Created','Ваш токен авторизации: '.$this->getToken()];


	}


	private function generateToken(){
		$token = '';
		$end = rand(20,35);
		for($i = 0;$i<=$end;$i++){
			$symbols_group = rand(1,2);
			if($symbols_group == 1){
				$token .= chr(rand(48,57));
			}
			else{
				$token .= chr(rand(97,122));
			}
		}
		return $token;
	}

	private function checkToken($token){
		$check_token = $this->connection->query("SELECT * FROM tokens WHERE token_key ='$token'");
		if($check_token->rowCount()!=0)return false;
		return true;
	}

	private function checkUserToken($id){
		$check_user_token = $this->connection->query("SELECT * FROM tokens WHERE user_id = '$id'");
		if($check_user_token->rowCount()!=0){
			return false;
		}
		return true;
	}

	private function insertToken($user_id,$token){
		$this->connection->exec("INSERT INTO tokens (user_id,token_key) VALUES ('$user_id','$token')");
		
	}

	private function getToken(){
		return $this->token;
	}

	private function setToken($token){
		$this->token = $token;
	}

}



 ?>