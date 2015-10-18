<?

	error_reporting (E_ALL); 
	include('config.php');
	
	function search_file($folderName, $fileName, &$str){ //куда-нубдь в другое место
		$dir = opendir($folderName);
		while (($file = readdir($dir)) !== false){ 
			if($file != "." && $file != ".." && $file != ".git"){ 
				if(is_file($folderName."/".$file)){
					if($file == $fileName) {
						$str=$folderName."/".$file;
					}
				} 
				if(is_dir($folderName."/".$file)) search_file($folderName."/".$file, $fileName, $str);
			} 
		}
		closedir($dir);
	}
	
	function __autoload($className) { //где прописать исключение если файла нет??? сделать независимой к регистру!
		search_file(".", ($className.'.php'), $path); //поиск файла во всех дерикториях, а если имя класса совпадает?
		if(file_exists($path)) require_once($path);
		else return false;
	}

	$a = new Router();
	$a->run();
	

?>