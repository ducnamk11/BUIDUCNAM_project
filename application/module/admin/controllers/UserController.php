<?php
class UserController extends Controller{
 
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
 
	}
 	// hien thi danh sach -  phân trang
	public function indexAction(){
		$this->_view->_title     = 'User Manager: List';
		$totalItems              = $this->_model->countItem($this->_arrParam, null);
		$configPagination = array(	'totalItemsPerPage' =>5 ,
			'pageRange'			=> 3);
		$this->setPagination($configPagination);
		$this->_view->pagination = new Pagination($totalItems,$this->_pagination);
		$this->_view->slbGroup 		= $this->_model->itemInSelecbox($this->_arrParam, null);
		$this->_view->Items      =  $this->_model->listItem($this->_arrParam, null)  ;
		$this->_view->render('user/index');
	} 	
	// add & edit user
	public function formAction(){
		$this->_view->_title= "USER user : ADD";
		$this->_view->slbGroup 		= $this->_model->itemInSelecbox($this->_arrParam, null);
		if (isset($this->_arrParam['id'])) {
			$this->_view->_title= "USER user : EDIT";
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam,null);
		}
		if ( isset($this->_arrParam['form']['token'])>0) {
			$task = (isset($this->_arrParam['form']['id'])) ? 'edit' :'add';
			$queryUserName = "SELECT `id` FROM `".TBL_USER."` WHERE `username` ='".$this->_arrParam['form']['username']."'";
			$queryEmail = "SELECT `id` FROM `".TBL_USER."` WHERE `email` ='".$this->_arrParam['form']['email']."'";
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('username','string-notExistRecord',array('database'=>$this->_model,'query'=>$queryUserName,'min'=>5,'max'=>25))
			->addRule('email','email-notExistRecord',array('database'=>$this->_model,'query'=>$queryEmail))
			->addRule('password','password',array('action'=>$task))
			->addRule('status','status',array('deny'=>array('default')))
			->addRule('group_id','status',array('deny'=>array('default')))
			->addRule('ordering','int',array('min'=>1,'max'=>100));
			$validate->run();
			$this->_arrParam['form']= $validate->getResult();

			if ($validate->isValid()=='false') {
				$this->_view->errors= $validate->showErrors();
			}else{
				$this->_model->saveItems($this->_arrParam,array('task'=>'add'));
				$type = $this->_arrParam['type'];
				if ($type =='save-close') URL::redirect('admin','user','index');
				if ($type =='save-new') URL::redirect('admin','user','form');
				if ($type =='save') URL::redirect('admin','user','form',array('id'=>$id));
			}
		}
		$this->view->arrParam['form'] = $this->_arrParam;
		$this->_view->render('user/form');
	}
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam,array('task'=>'change-ajax-status'));
		echo  json_encode($result);
	}

	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam,array('task'=>'change-status'));
		URL::redirect('admin','user','index');
	}
	public function trashAction(){
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect('admin','user','index');
	}
	public function orderingAction(){
		$this->_model->ordering($this->_arrParam);
		URL::redirect('admin','user','index');
	}
}