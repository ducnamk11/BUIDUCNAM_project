<?php
class BookController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

 	// hien thi danh sach category
	public function listAction(){
		$this->_view->_title       = 'book :: list';
		$this->_view->categoryName =  $this->_model->infoItem($this->_arrParam,array('task' =>'get-cat-name'))  ;
		$this->_view->Items        =  $this->_model->listItem($this->_arrParam,array('task' =>'book-in-cat'))  ;
		$this->_view->render('book/list');
	} 
	 	// hien thi danh sach category
	public function detailAction(){
		$this->_view->_title     = 'Info Book';
		$this->_view->bookInfo   =  $this->_model->infoItem($this->_arrParam,array('task' =>'book-info'))  ;
		$this->_view->bookRelate =  $this->_model->listItem($this->_arrParam,array('task' =>'book-relate'))  ;
		$this->_view->render('book/detail');
	} 	
}