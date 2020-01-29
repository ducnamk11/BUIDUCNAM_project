<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
 	// hien thi danh sach category
	public function indexAction(){
		$this->_view->_title     = 'Category manage :: list';
		$totalItems              = $this->_model->countItem($this->_arrParam, null);
		$configPagination = array(	'totalItemsPerPage' => 5 ,
			'pageRange'			 => 3);
		$this->setPagination($configPagination);

		$this->_view->pagination = new Pagination($totalItems,$this->_pagination);
		$this->_view->Items      =  $this->_model->infoItem($this->_arrParam, null)  ;
		$this->_view->render('category/index');
	} 	
	// add & edit category ( category khong cho phep add va trash)
	public function formAction(){

		$this->_view->_title= "USER category : ADD";
		if(!empty($_FILES)) {$this->_arrParam['form']['picture'] =  $_FILES['picture'];
	};
	if (isset($this->_arrParam['id'])) {
		$this->_view->_title= "USER category : EDIT";
		$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam,null);
	}
	if ( isset($this->_arrParam['form']['token'])>0) 
	{
		$validate = new Validate($this->_arrParam['form']);
		$validate->addRule('name','string',array('min'=>3,'max'=>255))
		->addRule('status','status',array('deny'=>array('default')))
		->addRule('ordering','int',array('min'=>1,'max'=>100))
		->addRule('picture','file',array('min'=>100,'max'=>1000000,'extension'=>array('jpg','png')),false);
		$validate->run();
		$this->_arrParam['form']= $validate->getResult();
		if ($validate->isValid()=='false') {
			$this->_view->errors= $validate->showErrors();
		}else{
			$this->_model->saveItems($this->_arrParam,array('task'=>'add'));
			$type = $this->_arrParam['type'];
			if ($type =='save-close') URL::redirect('admin','category','index');
			if ($type =='save-new') URL::redirect('admin','category','form');
		}
	}
	$this->view->arrParam['form'] = $this->_arrParam;
	$this->_view->render('category/form');
}
public function ajaxStatusAction(){
	$result = $this->_model->changeStatus($this->_arrParam,array('task'=>'change-ajax-status'));
	echo  json_encode($result);
}
public function statusAction(){
	$this->_model->changeStatus($this->_arrParam,array('task'=>'change-status'));
	URL::redirect('admin','category','index');
}
public function trashAction(){
	$this->_model->deleteItems($this->_arrParam);
	URL::redirect('admin','category','index');
}
public function orderingAction(){
	$this->_model->ordering($this->_arrParam);
	URL::redirect('admin','category','index');
}
}