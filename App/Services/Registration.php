<?php 
namespace App\Services;

class Registration extends Service
{	
	public function __construct($connection,$request_data){
		parent::__construct($connection);
		$this->request_data = $request_data;
	}

	public function regist(){
		if($this->connection->query("SELECT * FROM users WHERE login = '{$this->request_data['login']}'")->rowCount()!=0)return ['HTTP/1.1 200 OK','Пользователь с данным логином уже существует в системе'];
		if($this->connection->query("SELECT * FROM users WHERE email = '{$this->request_data['email']}'")->rowCount()!=0)return ['HTTP/1.1 200 OK','Пользователь с данным логином уже существует в системе'];

		try{
			$this->connection->exec("INSERT INTO users (login,password,email,name,is_banned) VALUES ('{$this->request_data['login']}','{$this->request_data['password']}','{$this->request_data['email']}','{$this->request_data['name']}',0)");
			return ['HTTP/1.1 201 Created','Пользователь успешно зарегистрирован в системе'];
		}
		catch (\PDOException $pdoerror){
			$pdoerror->getMessage();
			die();
		}



	}


}


 ?>