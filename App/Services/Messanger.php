<?php 
namespace App\Services;

class Messanger 
{
	public static function display(array $headers,$message){
		foreach($headers as $header){
			header($header);
		}
		echo $message;
	}
}



 ?>