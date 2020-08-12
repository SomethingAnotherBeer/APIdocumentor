<?php 
namespace App\Models;

class Documents extends Model
{	
	private $user_id;
	public function __construct($connection,$user_id){
		parent::__construct($connection);
		$this->user_id = $user_id;
	}


	public function getDocuments(){
		$result = $this->connection->query("SELECT * FROM documents WHERE user_id = '$this->user_id'");
		if($result->rowCount()==0)return ['HTTP/1.1 200 OK','У вас пока нет документов'];
		return ['HTTP/1.1 200 OK',$this->fetchArrResponse($result)];
	}

	public function getDocument($id){
		$result = $this->connection->query("SELECT * FROM documents WHERE id = '$id' AND user_id = '$this->user_id'");
		if($result->rowCount()!=0){
			return ['HTTP/1.1 200 OK',$this->fetchArrResponse($result)];
		}
		else{
			return ['HTTP/1.1 400 Bad Request','Документ не найден'];
		}
		
	}

	public function createDocument($document){
		$this->connection->exec("INSERT INTO documents (user_id,title,description,text) VALUES ('$this->user_id','{$document['title']}','{$document['description']}','{$document['text']}')");
		return ['HTTP/1.1 201 Created','Документ успешно создан'];
	}

	public function deleteDocument($document){
		$query = $this->connection->exec("DELETE FROM documents WHERE id = '{$document['id']}' AND user_id = '$this->user_id'");
		if(!$query) return ['HTTP/1.1 400 Bad Request','Данный документ не существует'];
		return ['HTTP/1.1 200 OK','Документ удален'];
	}

	public function editDocument($document){

		$query = $this->connection->exec("UPDATE documents SET title = '{$document['title']}', description = '{$document['description']}',text = '{$document['text']}' WHERE id = '{$document['id']}' AND user_id = '$this->user_id'");
		if(!$query)return ['HTTP/1.1 400 Bad Request','Данный документ не существует или внесенные данные совпадают с таковыми в документе'];
		return ['HTTP/1.1 200 OK','Документ изменен'];
	}





	private function fetchArrResponse($query){
		$arr = [];
		while($row = $query->fetch(\PDO::FETCH_ASSOC)){
			$arr[]= $row;
		}
		return $arr;
	}
}




 ?>