<?
require("section.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; //если секция не указано, то по умолчанию главная, т.е. 1.
$section = (Sections::isSection($section)) ? $section : 0;
admin($section);

function info($section) { 
	$data = Sections::getIdSection($section);
	return $data;
}
 
function tree($data,$parent_id) { //объеденить с деревом admin.php
	if(is_array($data) and isset($data[$parent_id])){
        $tree = '<ul>';
		foreach($data[$parent_id] as $d){
			$tree .= '<li><a href="/?section='.$d['id'].'">'.$d['name'].' #'.$d['id'];
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

function breadCrumbs($section) {
  $data = Sections::bread($section);
  $str="";
  for ($i=count($data)-1; $i>=0; $i--) {
	$str .="<a href='/?section=".$data[$i]['id']."'>".$data[$i]['name']."</a>/";
  }
  return $str;
}

function admin($section) { //загрузка представления
  $data = array();
  $data = info($section);
  $data['menu'] = menu($section);
  $data['bread'] = breadCrumbs($section);
  $data['page_name'] = 'Сайт';
  require("view/viewSite.php");
}
 
?>