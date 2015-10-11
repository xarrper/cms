<?
require("section.php");
require("../config.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; 
$section = (Sections::isSection($section)) ? $section : 0;
$action = isset( $_GET['action'] ) ? $_GET['action'] : 1; 

go();

function go() { //из бд, норм проверка и отдельный класс
	@session_start();
	if (!isset($_SESSION['login'])) {
		if ((isset( $_POST['login'] ))and(isset( $_POST['password'] ))) {
			if (($_POST['login']==LOGIN)and(md5(md5($_POST['password']))==PASSWORD)) { 
				$_SESSION['login']= $_POST['login'];
				$_SESSION['password']= PASSWORD;
			}
			else header("Location: ".PATH."/enter.php");
		}
		else header("Location: ".PATH."/enter.php");
	}
}

function exits(){
  @session_start();
  session_destroy(); 
  header("Location: ".PATH);
}

switch ($action) {
  case 'exit':
    exits();
    break;
  case 'act':
	act($section);
    break;
  default:
    admin($section);
}
 
function info($section) { 
	$data = Sections::getIdSection($section);
	return $data;
}
 
function tree($data,$parent_id) { //объеденить с деревом index.php
	if(is_array($data) and isset($data[$parent_id])){
        $tree = '<ul>';
		foreach($data[$parent_id] as $d){
			$tree .= '<li><a href="/admin.php?section='.$d['id'].'">'.$d['name'].' #'.$d['id'];
			$tree .=  tree($data,$d['id']);
			$tree .= '</a></li>';
		}
        $tree .= '</ul>';
    }
    else return null;
	return $tree;
}	
 
function menu($section) { 
	$data = Sections::getIdSectionMenu($section);
	return tree($data,0);
}

function admin($section) { 
	$data = array();
	$data = info($section);
	$data['nameB']='edit';
	$data['valueB']='Изменить';
	$data['buttonDelet']='<input type="submit" name="delete" value="Удалить"></p>';
	$data['nameAct'] = 'Добавить раздел';
	$data['idAct'] = 0;
	if($section==0) {
		$data['id']=0;
		$data['nameB']='add';
		$data['valueB']='Добавить';
		$data['buttonDelet'] = "";
		$data['nameAct'] = 'Редактировать раздел';
		$data['idAct'] = 1;
	}
	$data['menu'] = menu($section);
	$data['page_name'] = 'Админ';
	require("view/viewAdmin.php");
}

function act($section) {
	$data = array();
	$data['parent_id'] = $_POST['parent_id'];
	$data['name'] = $_POST['name'];
	$data['text'] = $_POST['text'];
	if(isset($_POST['edit'])) {
		$data['id'] = $section;
		if (!(Sections::isSection($data['parent_id']))) $data['parent_id'] = 0;
		Sections::updateSection($data);	
		header("Location: ".PATH."/admin.php?section=".$section); 
	}
	else if(isset($_POST['delete'])) {
		Sections::deleteSection($section);	
		header("Location: ".PATH."/admin.php");
	}
	else if(isset($_POST['add'])) {
		if (!(Sections::isSection($data['parent_id']))) $data['parent_id'] = 0;
		Sections::insertSection($data);	
		header("Location: ".PATH."/admin.php?section=".$data['parent_id']);
	}
	else header("Location: ".PATH."/admin.php?section=".$section);
}
 
?>