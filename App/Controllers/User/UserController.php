<?//1. унаследвать подгрузку интерфейса. 2. что делать с id из таблицы??? 
class UserController {
	
	private $id;
	private $userModel;
	private $treeHelper;
	
	function __construct() {
		$this->userModel = new UserModel();
		$this->treeHelper = new TreeHelper();
		$this->userView = new AllView();
	}
	
	function info() { 
		$data = $this->userModel->getIdSection($this->id);
		return $data;
	}
	
	function menu() { 
		$data =  $this->userModel->getIdSectionMenu($this->id);
		return $this->treeHelper->tree($data,0);
	}
	
	function breadCrumbs() {
		$data = $this->userModel->bread($this->id);
		return $this->treeHelper->bread($data);;
	}
	
	function action($id=1) {
		$this->id = $id; //в конструктор!! т.е при отправлении из router !!!!!!!!!! и чтоб при создании модели сразу в конструктор передавать id!	
		
		$data = array();
		$data = $this->info();
		$data['menu'] = $this->menu();
		$data['bread'] = $this->breadCrumbs();
		$data['page_name'] = 'Сайт';
		$this->userView->show($data, 'UserView.php');
	}
}
?>