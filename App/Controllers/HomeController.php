<?php 
namespace App\Controllers;
use App\Services;
use App\Includes;
abstract class HomeController extends MainController
{	protected $user_id;
	public function __construct(){
		parent::__construct();
		if(isset($_SERVER['HTTP_AUTHORIZATION'])){
			$authentification= new Services\Authentification(Includes\DB::getConnection(),$_SERVER['HTTP_AUTHORIZATION']);
			$auth_id = $authentification->auth();
		}
		else{
			$this->setHeaders(['HTTP/1.1 401 Unauthorized']);
			Services\Messanger::display($this->headers,json_encode("Доступ запрещен",JSON_UNESCAPED_UNICODE));
			die();
		}
		if($auth_id==false){
			$this->setHeaders(['HTTP/1.1 401 Unauthorized']);
			Services\Messanger::display($this->headers,json_encode("Доступ запрещен",JSON_UNESCAPED_UNICODE));
			die();
		}
		else{
			$this->user_id = $auth_id;
		}
		
	}
}



 ?>