<?php 
namespace App\Controllers;
use App\Services;
use App\Includes;
use App\Models;
class DocumentsController extends HomeController
{
	private $document;
	private $document_model;
	public function __construct(){
		parent::__construct();
		$this->document_model = new Models\Documents(Includes\DB::getConnection(),$this->user_id);
		
	}


	public function getDocuments(){
		if($this->request_method !== 'GET')return 0;
		$response = $this->document_model->getDocuments();
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));
	}

	public function getDocument(){
		if($this->request_method != 'GET')return 0;
		if(!isset($_GET['id']))return 0;
		$id = intval($_GET['id']);
		$response = $this->document_model->getDocument($id);
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode([$response[1]],JSON_UNESCAPED_UNICODE));

	}

	public function createDocument(){
		if($this->request_method !== 'POST')return 0;
		$this->request_body = $this->getParams();
		if(!$this->checkParams($this->request_body,['title','description','text'])) {
			$this->setHeaders(['HTTP/1.1 400 Bad Request']);
			Services\Messanger::display($this->headers,json_encode("Ошибка параметров: Ожидаемые параметры отличны от фактических",JSON_UNESCAPED_UNICODE));
			return 0;
		}
		$response = $this->document_model->createDocument($this->request_body);
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));
	}

	public function deleteDocument(){
		if($this->request_method !== 'DELETE')return 0;
		$this->request_body = $this->getParams();
		if(!$this->checkParams($this->request_body,['id'])){
			$this->setHeaders(['HTTP/1.1 400 Bad Request']);
			Services\Messanger::display($this->headers,json_encode('Ошибка параметров: Ожидаемые параметры отличны от фактических',JSON_UNESCAPED_UNICODE));
			return 0;
		}
		$response = $this->document_model->deleteDocument($this->request_body);
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));
	}

	public function editDocument(){
		if($this->request_method!== 'PUT')return 0;
		$this->request_body = $this->getParams();
		if(!$this->checkParams($this->request_body,['id','title','description','text'])){
			$this->setHeaders(['HTTP/1.1 400 Bad Request']);
			Services\Messanger::display($this->headers,json_encode('Ошибка параметров: Ожидаемые параметры отличны от фактических',JSON_UNESCAPED_UNICODE));
			return 0;
		}
		$response = $this->document_model->editDocument($this->request_body);
		$this->setHeaders([$response[0]]);
		Services\Messanger::display($this->headers,json_encode($response[1],JSON_UNESCAPED_UNICODE));
	}
}





 ?>