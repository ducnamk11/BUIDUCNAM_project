<?php
class IndexModel extends Model{
	private $_columns = array(
		'id',
		'username',
		'email',
		'fullname',
		'password',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'register-date',
		'register-ip',
		'status',
		'ordering',
		'group_id');
	function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_USER);
	} 
	public function listItem($arrParam, $option = null){
		if ($option['task'] == 'books-special'){
			$query[]	= "SELECT `id`, `name`, `picture`, `description`";
			$query[]	= "FROM ".TBL_BOOK;
			$query[]	= "WHERE `status` = 1 AND special = 1";
			$query[]	= "ORDER BY `ordering`  ASC";
			$query[]	= "LIMIT 0,2";
			  $query		= implode(" ", $query);
			$result		= $this->fetchAll($query);
			return $result;
		}	
			if ($option['task'] == 'books-new'){
			$query[]	= "SELECT `id`, `name`, `picture`, `description`";
			$query[]	= "FROM ".TBL_BOOK;
			$query[]	= "WHERE `status` = 1 ";
			$query[]	= "ORDER BY `id`  DESC";
			$query[]	= "LIMIT 0,3";
			  $query		= implode(" ", $query);
			$result		= $this->fetchAll($query);
			return $result;
		}	
	}
	public function saveItems($arrParam,$option = null){
		if ($option['task'] == 'user-register') {
			$arrParam['form']['password'] = md5($arrParam['form']['password']);
			$arrParam['form']['register-date'] = date('Y-m-d H:m:s',time());
			$arrParam['form']['register-ip'] = $_SERVER['REMOTE_ADDR'];
			$arrParam['form']['created_by'] = 1;
			$arrParam['form']['status'] = 0;

			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			return $this->lastID();
		}
	}

	public function infoItem($arrParam,$option = null){
		if ($option==null) {
			$email = $arrParam['form']['email'];
			$password = md5($arrParam['form']['password']);
			$query[] = "SELECT u.id , u.fullname,u.username, u.email, u.group_id, g.group_acp";
			$query[] = "FROM user AS u LEFT JOIN `group` AS `g` ON `u`.group_id =`g`.id";
			$query[] = "WHERE email = '$email' AND password ='$password'";
			$query = implode(" ",$query);
			$result = $this->fetchRow($query);
			return $result;
		}
	}

}