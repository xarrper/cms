<?

	error_reporting (E_ALL); 
	include('config.php');
	
	function search_file($folderName, $fileName, &$str){ //куданубдь в другое место
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
	
	function __autoload($className) { //где прописать исключение если файла нет???
		search_file(".", mb_strtolower($className.'.php'), $path);
		if(file_exists($path)) require_once($path);
		else return false;
	}

	$a = new Router();
	$a->run();
	

?>