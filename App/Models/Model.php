<?php 
namespace App\Models;

abstract class Model
{
	protected $connection;
	public function __construct($connection){
		$this->connection = $connection;
	}
}



 ?>