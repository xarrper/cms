<?
 
require("section.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; //если секция не указано, то по умолчанию главная, т.е. 1.
$action = isset( $_GET['action'] ) ? $_GET['action'] : 1; //если действие не указано, то ничего

switch ($action) {
  case 'new':
    //newArticle();
    break;
  case 'act':
	act();
    break;
  default:
    admin($section);
}

//!проверка сессии, АЛЕ!
 
function info($section) { //вывод инфы секции
	$data = Sections::getIdSection($section);
	return $data;
	//require("viewAdmin.php");
}
 
function tree($data,$parent_id) {
	if(is_array($data) and isset($data[$parent_id])){
        $tree = '<ul>';
		foreach($data[$parent_id] as $d){
			$tree .= '<li>'.$d['name'].' #'.$d['id'];
			$tree .=  tree($data,$d['id']);
			$tree .= '</li>';
		}
        $tree .= '</ul>';
    }
    else return null;
	return $tree;
}	
 
function menu($section) { //вывод дерева
  
  $data = Sections::getIdSectionMenu($section);
	//print_r($data);
	return tree($data,0);
  //require("viewAdmin.php");
}

function admin($section) { //загрузка представления
  $data = array();
  $data = info($section);
  $data['menu'] = menu($section);
  require("viewAdmin.php");
}

function act() {
	if(isset($_POST['delete'])) echo 'удалить';
	if(isset($_POST['edit'])) echo 'изменить';
	//header Location//
}
 
?>