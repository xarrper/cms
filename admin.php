<?
 
require("section.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; //если секция не указано, то по умолчанию главная, т.е. 1.
info($section);
//!проверка сессии, АЛЕ!
 
function info($section) { //вывод инфы секции
	$data = Sections::getIdSection($section);
	require("viewAdmin.php");
}
 
function tree($section) { //вывод дерева
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Article Archive | Widget News";
  require( TEMPLATE_PATH . "/archive.php" );
}

function admin() { //загрузка представления
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Article Archive | Widget News";
  require( TEMPLATE_PATH . "/archive.php" );
}
 
?>