<? 
	//print_r($data);
	$mysql=mysql_connect("127.0.0.1","root","") OR DIE("Не могу создать соединение ");
mysql_query('SET names "utf8"');
mysql_select_db("cms",$mysql) or die(mysql_error());
	$result=mysql_query("SELECT * FROM  sections");
/*
	if   (mysql_num_rows($result) > 0){
		$cats = array();
		while($cat =  mysql_fetch_assoc($result)){
			$cats_ID[$cat['id']][] = $cat;
			$cats[$cat['parent_id']][$cat['id']] =  $cat;
		}
	}*/
	
	if   (mysql_num_rows($result) > 0){
		$cats = array();
		while($cat =  mysql_fetch_assoc($result)){
			$cats[] =  $cat;
		}
	}
print_r($cats);
function mass_parents($cats,$id) {
	$mas = array();
	$mas[] = $id;
	//$mas[] = $cats[$id]['id_parent'];
	//print_r($mas);
	//echo count($cats);
	while($id!=0) {
		for ($i=0; $i<count($cats); $i++) {
			if($cats[$i]['id']==$id) {
				$id = $cats[$i]['parent_id'];
				$mas[] = $id;
				break;
			}
		}
		//$mas[] = $cats[$id]['id_parent']
	}
	print_r($mas);
}
	mass_parents($cats,5); echo '<br><br>';/*
	function build_tree($cats,$parent_id,$only_parent = false){
    if(is_array($cats) and isset($cats[$parent_id])){
        $tree = '<ul>';
        if($only_parent==false){
            foreach($cats[$parent_id] as $cat){
                $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
                $tree .=  build_tree($cats,$cat['id']);
                $tree .= '</li>';
            }
        }elseif(is_numeric($only_parent)){
            $cat = $cats[$parent_id][$only_parent];
            $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
            $tree .=  build_tree($cats,$cat['id']);
            $tree .= '</li>';
        }
        $tree .= '</ul>';
    }
    else return null;
    return $tree;
}
	echo build_tree($cats,0);
	function find_parent ($tmp, $cur_id){
    if($tmp[$cur_id][0]['parent_id']!=0){
        return find_parent($tmp,$tmp[$cur_id][0]['parent_id']);
    }
    return (int)$tmp[$cur_id][0]['id'];
}*/
//echo build_tree($cats,0,find_parent($cats_ID,1));
?>
