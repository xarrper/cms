<?
 
require("section.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; //���� ������ �� �������, �� �� ��������� �������, �.�. 1.
info($section);
//!�������� ������, ���!
 
function info($section) { //����� ���� ������
	$data = Sections::getIdSection($section);
	require("viewAdmin.php");
}
 
function tree($section) { //����� ������
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Article Archive | Widget News";
  require( TEMPLATE_PATH . "/archive.php" );
}

function admin() { //�������� �������������
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Article Archive | Widget News";
  require( TEMPLATE_PATH . "/archive.php" );
}
 
?>