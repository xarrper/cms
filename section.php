<?
class Sections {

	public $id = null;
	public $text = null;
	public $name = null;
	
	function __construct($id=null, $name=null, $text=null) { 
		$this->id = $id;
		$this->name = $name;
		$this->text = $text;
	}
	
	private function connect() { 
		try {
			return $DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); 
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
	
	public function isSection($id) { 
		$data = self::getIdSection($id);
		if (!isset($data['id'])) return false;
		return true;
	}
	
	public function getIdSection($id) { 
		try
		{	
			$DBH = self::connect();
			$stmt = $DBH->prepare("SELECT * FROM sections WHERE id=?");
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $data[0];
		}
		catch(PDOException $e)
		{
			die("Error: ".$e->getMessage());
		}
	}
	
	private function listSection() { 
		try {	
			$DBH = self::connect();
			$stmt = $DBH->query("SELECT * FROM sections");
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$data = array();
			while($row = $stmt->fetch()) {
				$data[] = $row;
			}
			return $data;
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
	
	private function masParents($id) {
		$data = self::listSection();
		$str = '('.$id;
		while($id!=0) {
			for ($i=0; $i<count($data); $i++) {
				if($data[$i]['id']==$id) {
					$id = $data[$i]['parent_id'];
					$str .= ','.$id;
					break;
				}
			}
		}
		$str .= ')';
		return $str;
	}
	
	private function masChilds($data, $id, &$m) {
		$m[] = $id;
		for ($i=0; $i<count($data); $i++) {
			if($data[$i]['parent_id']==$id) {
				$child_id = $data[$i]['id'];
				$m[] = $child_id;
				self::masChilds($data, $child_id, $m);
			}
		}
		return $m;
	}
	
	public function bread($id) {
		$data = self::listSection();
		$mas = array();
		$mas_d = array();
		while($id!=0) {
			for ($i=0; $i<count($data); $i++) {
				if($data[$i]['id']==$id) {
					$id = $data[$i]['parent_id'];
					$mas_d['id'] = $data[$i]['id'];
					$mas_d['name'] = $data[$i]['name'];
					$mas[] = $mas_d;
					break;
				}
			}
		}
		return $mas;
	}
	
	public function getIdSectionMenu($id) { 
		$strParent = self::masParents($id);
		$DBH = self::connect();
		$stmt = $DBH->query("SELECT * FROM sections WHERE  `parent_id` IN ".$strParent);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = array();
		while($row = $stmt->fetch()) {
			$data[$row['parent_id']][$row['id']] =  $row;
		}
		return $data;
	}
	
	public function updateSection($data) { //обновление данных и перенос статьи
		try {	
			$DBH = self::connect();
			$stmt = $DBH->prepare("UPDATE sections set parent_id = :parent_id, name = :name, text = :text where id=:id");
			$stmt->bindParam(':parent_id', $parent_id);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':text', $text);
			$stmt->bindParam(':id', $id);
			$parent_id = $data['parent_id'];
			$name = $data['name'];
			$text = $data['text'];
			$id = $data['id'];
			$stmt->execute();
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
	
	public function insertSection($data) { 
		try {	
			$DBH = self::connect();
			$stmt = $DBH->prepare("INSERT INTO sections (parent_id, name, text) VALUES (:parent_id, :name, :text)");
			$stmt->bindParam(':parent_id', $parent_id);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':text', $text);
			$parent_id = $data['parent_id'];
			$name = $data['name'];
			$text = $data['text'];
			$stmt->execute();
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
	
	public function deleteSection($id) { 
		try {	
			$data = self::listSection();
			$mas = array();
			$mas = self::masChilds($data, $id, $mas);
			$mas = array_unique($mas);
			$mas = array_values($mas);
			$str = '('.$mas[0];
			for ($i=1; $i<count($mas); $i++) {
				$str .= ','.$mas[$i];
			}
			$str .= ')';
			$DBH = self::connect();
			$stmt = $DBH->query("DELETE FROM sections WHERE  `parent_id` IN ".$str);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
}
?>