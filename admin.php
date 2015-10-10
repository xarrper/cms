<?
 
require("section.php");

$section = isset( $_GET['section'] ) ? $_GET['section'] : 1; //���� ������ �� �������, �� �� ��������� �������, �.�. 1.
menu($section);
//!�������� ������, ���!
 
function info($section) { //����� ���� ������
	$data = Sections::getIdSection($section);
	require("viewAdmin.php");
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
 
function menu($section) { //����� ������
  
  $data = Sections::getIdSectionMenu($section);
	//print_r($data);
	echo tree($data,0);
  //require("viewAdmin.php");
}

function admin() { //�������� �������������
  info($section);
  tree($section);
  require("viewAdmin.php");
}
 
?>