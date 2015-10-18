<?
class UserController {
	
	private $id;
	
	function action($id=null) {
		$this->id = $id;
		echo $id;
		echo 'пользователь';
	}
}
?>