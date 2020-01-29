<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
		
	}
 	// hien thi danh sach category
	public function indexAction(){
		$this->_view->_title     = 'Category :: list';
		$this->_view->Items      =  $this->_model->listItem($this->_arrParam, null)  ;
		$this->_view->render('category/index');
	} 	
}