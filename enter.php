<?
@session_start();
require("config.php");
if (isset($_SESSION['login']) and isset($_SESSION['password'])) {
	header("Location: ".PATH."/admin.php"); 
}
else {
	$data['page_name']='Вход';
	require("view/viewEnter.php");
}
?>