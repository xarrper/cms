<?
class Sections {

	public $id = null;
	public $text = null;
	public $name = null;
	
	function __construct($id=null, $name=null, $text=null) { //норм конструктор сделать
		$this->id = $id;
		$this->name = $name;
		$this->text = $text;
	}
	
	private function connect() { //try
		//$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); //где вас хранить,!? ребяяят?
	}
	
	public function a() {
		return $str = 100;
	}
	
	public function b() {
		$str = $this->a();
		return $str;
	}
	
	public function getIdSection($id) { 
		try
		{	
			$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); //в отдельный метод!!
			
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
	
	private function tree(&$rs,$parent)
	{
		$out = array();
		if (!isset($rs[$parent])) {
			return $out;
		}
		foreach ($rs[$parent] as $row) {
			$chidls = $this->tree($rs, $row['id']);
			if ($chidls) $row['childs'] = $chidls;
			$out[] = $row;
		}
		return $out;
	}
	
	public function getIdSectionMenu($id) { //хз
		$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root','');
		$stmt = $DBH->query("SELECT * FROM sections");
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		$rs2 = array();
		while($row = $stmt->fetch()) {
			$rs2[$row['parent_id']][] = $row;
		}
		$rs2 = $this->tree($rs2 ,$id);
		return $rs2;
	}
	
	public function updateSection($data) { //здесь же и перенос статьи!(нужно указать ключ родителя!)
		try
		{	
			$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); //в отдельный метод!!
			
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
		catch(PDOException $e)
		{
			die("Error: ".$e->getMessage());
		}
	}
	
	public function insertSection($data) { 
		try
		{	
			$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); //в отдельный метод!!
			
			$stmt = $DBH->prepare("INSERT INTO sections (parent_id, name, text) VALUES (:parent_id, :name, :text)");
			$stmt->bindParam(':parent_id', $parent_id);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':text', $text);
			$parent_id = $data['parent_id'];
			$name = $data['name'];
			$text = $data['text'];
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			die("Error: ".$e->getMessage());
		}
	}
	
	public function deleteSection($id) { 
		try
		{	
			$DBH = new PDO('mysql:host=127.0.0.1;dbname=cms','root',''); //в отдельный метод!!
			
			$stmt = $DBH->prepare("DELETE FROM sections where id=:id");//$DBH->exec("DELETE FROM sections where id=:id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			
		}
		catch(PDOException $e)
		{
			die("Error: ".$e->getMessage());
		}
	}
}
//$a = new Sections();
//print_r($a->getIdSectionMenu(0));
//print_r($t);
/*
//$t= $a->getIdSection(1);
//print_r($t);
$data = array( //убрать старую версию
    "parent_id" => 3,
    "name" => "раздел№6",
	"text" => "текст раздела №6",
);

$a->deleteSection(7);
*/

?>