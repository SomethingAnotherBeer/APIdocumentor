<?php 
namespace App\Controllers;

abstract class AuthController extends ServiceController
{
	protected $permissible_symbols = [];

	public function __construct(){
		parent::__construct();
		for($i = 48;$i<=57;$i++){
			$this->permissible_symbols[] = $i;
		}
		for($i = 97;$i<=122;$i++){
			$this->permissible_symbols[] = $i;
		}
	}
}




 ?>