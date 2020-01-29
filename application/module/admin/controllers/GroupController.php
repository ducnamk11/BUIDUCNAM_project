<?php
class GroupController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
 	// hien thi danh sach group
	public function indexAction(){

		$this->_view->_title     = 'User Group: List';
		$totalItems              = $this->_model->countItem($this->_arrParam, null);
		$configPagination = array(	'totalItemsPerPage' => 5 ,
			'pageRange'			 => 3);
		$this->setPagination($configPagination);

		$this->_view->pagination = new Pagination($totalItems,$this->_pagination);
		$this->_view->Items      =  $this->_model->infoItem($this->_arrParam, null)  ;
		$this->_view->render('group/index');
	} 	
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam,array('task'=>'change-ajax-status'));
		echo  json_encode($result);
	}
	public function ajaxACPAction(){
		$result = $this->_model->changeStatus($this->_arrParam,array('task'=>'change-ajax-group-acp'));
		echo json_encode($result);

	}
	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam,array('task'=>'change-status'));
		URL::redirect('admin','group','index');
	}
	public function trashAction(){
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect('admin','group','index');
	}
	public function orderingAction(){
		$this->_model->ordering($this->_arrParam);
		URL::redirect('admin','group','index');
	}
}