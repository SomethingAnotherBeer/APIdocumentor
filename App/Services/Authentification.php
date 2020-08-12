<?php 
namespace App\Services;

class Authentification extends Service
{
	public function __construct($connection,$request_data){
		parent::__construct($connection);
		$this->request_data = $request_data;
	}

	public function auth(){
		$user_id = $this->connection->query("SELECT user_id FROM tokens WHERE token_key = '$this->request_data'");
		if($user_id->rowCount()==1)return $user_id->fetchColumn();
		return false;
		
	}
}



 ?>