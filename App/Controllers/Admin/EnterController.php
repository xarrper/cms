<?
class EnterController {
	
	function __construct() {
		$this->userView = new AllView(); //сделать в классе родителя!
	}
	
	function action() {
		@session_start();
		if (isset($_SESSION['login']) and isset($_SESSION['password'])) {
			echo 'админ!';
			//header("Location: ".PATH."/admin.php"); 
		}
		else {
			$data['page_name']='Вход';
			$this->userView->show($data, 'EnterView.php');
		}
	}
}
?>