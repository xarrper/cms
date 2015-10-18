<?
//просмотреть slim. на завтра. и railis-routing - разобрать
error_reporting (E_ALL); 
class Router {
	
	private $routes; //шаблоны 
	
	function __construct() {
		$routes = new Route();
		$this->routes = $routes->getRoute();
	}
	
	function getURI() { //получение пути
		$uri = rtrim($_SERVER["REQUEST_URI"], '/'); 
		
		$here = realpath(rtrim(dirname($_SERVER["SCRIPT_FILENAME"]), '/')); //абсолютный путь к скрипту 'K:/home/cms.local/www/index.php'
		$here = str_replace("\\", "/", $here . "/"); //наверное для какиехто других систем
		// узнать абсолютный путь к корню документа
		$document_root = str_replace("\\", "/", realpath($_SERVER["DOCUMENT_ROOT"]) . "/"); //где содержиться весь проджект 'K:/home/cms.local/www'

		//т.е. нужно, если файл router.php находиться не в корненвом каталоге! универсальный классик. 
		//https://www.cms.local/view/router.php = router.php, или https://www.cms.local/router.php = router.php
		if (strpos($here, $document_root) !== false) { 
			$relative_path = rtrim("/" . str_replace($document_root, "", $here), '/');
			$path_route = urldecode(str_replace($relative_path, "", $uri)); //если русские символы
			$path_route = trim($path_route, '/');
			$path_route = ((empty($path_route))or(is_numeric($path_route))) ? rtrim("home/".$path_route, '/') : $path_route; //по умолчанию, запихнуть в конфиг
			return $path_route;
		}
		$uri = ((empty($uri))or(is_numeric($uri))) ? rtrim("home/".$uri, '/') : $uri;
		return urldecode($uri);
	}
	
	function run() { //обработка и переход в нужный контроллер.
		$uri = $this->getURI();

		foreach($this->routes as $key => $value) {
			if (preg_match($key, $uri)) {
				$path = preg_replace($key, $value, $uri);
				list ($controller,$method) = $segments = explode ('/',$path);	
				$parameters = array_slice ($segments,2);				
				if (class_exists($controller)) {
					$controller = new $controller();
					if (method_exists($controller, $method)) {
						call_user_func_array(array($controller, $method), $parameters);
						exit; //нуженль?
					} 
					else {
						$this->error(404, "Action " . $controller . "." . $method . "() not found");
					}
				} 
				else {
					$this->error(404, "No such controller: " . $controller);
				}
			}
		}
		$this->error(404, "Page not found");
	}
	
	protected function error($nr, $message) {
		$http_codes = array(
			404=>'Not Found',
			500=>'Internal Server Error',
		);

		header($_SERVER['SERVER_PROTOCOL'] . " $nr {$http_codes[$nr]}");
		echo "
		<style type='text/css'>
			.routing-error { font-family:helvetica,arial,sans; border-radius:10px; border:1px solid #ccc; background:#efefef; padding:20px; }
			.routing-error h1 { padding:0px; margin:0px 0px 20px; line-height:1; }
			.routing-error p { color:#444; padding:0px; margin:0px; }
		</style>
		<div class='error routing-error'>
			<h1>Error $nr</h1>
			<p>$message</p>
		</div>";
		exit;
	}
}


class Route {
	function getRoute() {
		return array(
			'~^(home|admin)/([0-9+])~' => '$1/action/$2', //поменять название action. и разделить их admin и home отдельно
			'~^(enter|home|admin)$~' => '$1/action',//без параметров+
		);
	}
}
?>