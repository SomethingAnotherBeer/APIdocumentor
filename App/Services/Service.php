<?php 
namespace App\Services;

abstract class Service
{	protected $connection;
	protected $request_data;
	public function __construct($connection){
		$this->connection = $connection;
	}
	protected  function setLog($message){
		
	}
}




 ?>