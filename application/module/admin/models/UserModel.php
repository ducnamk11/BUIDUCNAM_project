<?php
class UserModel extends Model{
	private $_columns = array('id','username','email','fullname','password','created','created_by','modified','modified_by','status','ordering','group_id');
	function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_USER);
	} 
	public function countItem($arrParam,$option = null){

		$query[] = "SELECT COUNT(`id`) AS `total`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id` >0" ;

 		//SEARCH
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND (`username` LIKE $keyword OR `email` LIKE $keyword)" ;
		}

		//filter status
		if (isset($arrParam['filter_state']) && $arrParam['filter_state']  !='default')  {
			$status = ($arrParam['filter_state']=='unpublish') ? 0 : 1;
			$query[] = "AND `status` ='". $status."'" ;
		}
				//filter group
		if (isset($arrParam['filter_group_id']) && $arrParam['filter_group_id']  !='default')  {
			$query[] = "AND `group_id` ='". $arrParam['filter_group_id']."'" ;
		}
		 $query = implode(" ",$query);
		$result = 	$this->fetchRow($query);
		return $result['total'];
	}
	public function itemInSelecbox($arrParam,$option = null){
		$result = '';
		if ($option ==  null) {
			$query = "SELECT `id` ,`name` FROM `".TBL_GROUP."`";
			$result = $this->fetchPairs($query);
			$result['default']   = '- select Group -';
			ksort($result);
		}
		return $result;


	}
	
	public function listItem($arrParam,$option = null){
		$query[] = "SELECT `u`.`id` , `u`.`username`, `u`.`email`, `u`.`fullname` ,`u`.`status`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS `group_name`";
		$query[] = "FROM `$this->table` AS `u` LEFT JOIN `".TBL_GROUP."` AS `g` ON `u`.`group_id` = `g`.`id`";
		$query[] = " WHERE `u`.`id` >0" ;

		//SEARCH
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND (`username` LIKE $keyword OR `email` LIKE $keyword)" ;
		}
		//select box status
		if (isset($arrParam['filter_state']) && $arrParam['filter_state'] !='default')  {
			$status = ($arrParam['filter_state']=='unpublish') ? 0 : 1;
			$query[] = "AND `u`.`status` ='". $status."'" ;
		}
						//filter group
		if (isset($arrParam['filter_group_id']) && $arrParam['filter_group_id']  !='default')  {
			$query[] = "AND u.`group_id` ='". $arrParam['filter_group_id']."'" ;
		}
		//FILTER
		if (!empty($arrParam['filter_column']) &&  !empty($arrParam['filter_column_dir'])) {
			$column  =$arrParam['filter_column'];
			$columnDir  =$arrParam['filter_column_dir'];
			$query[] = "ORDER BY `$column` $columnDir";
		}
		else{
			$query[] = "ORDER BY `u`.`id` DESC";
		}
//PAGINATION
		$pagination = $arrParam['pagination'];
		$totalItemsPerPage = $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage >1) {
			$position	= ($pagination['currentPage']-1)*$totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}
		$query = implode(" ",$query);
		$result = 	$this->fetchAll($query);
		return $result;
	}
	public function infoItem($arrParam,$option = null){
		if ($option['task'] == null) {
			$query[]="SELECT `id`,`username`,`email`,`fullname`,`group_id`,`status`, `ordering`";
			$query[]="FROM `$this->table`";
			$query[]="WHERE `id` = '".$arrParam['id']."'";
			  $query = implode(" ",$query);
			$result = $this->fetchRow($query);
			return $result;
		}
	}
	public function changeStatus($arrParam,$option = null){
		if ($option['task'] == 'change-ajax-status') {
			$status = ($arrParam['status'] ==0) ? 1 : 0;
			$id = $arrParam['id'];
			$query = "UPDATE `$this->table` SET status = $status WHERE `id` = $id ";
			$this->query($query);
			$result =   array( 	'id'=>$id,
				'status'=>$status,
				'link' =>URL::createLink('admin','user','ajaxStatus',array('id'=>$id,'status'=>$status)));
			return $result;
		}
		
		if ($option['task'] == 'change-status') {
			$status =  $arrParam['type'];
			if (!empty($arrParam['cid' ])) {
				$ids = $this->createWhereDeleteSQL($arrParam['cid']);
				$query = "UPDATE `$this->table` SET status = $status WHERE `id` IN ($ids) ";
				$this->query($query);
				Session::set('message', array('class'=> 'success', 'content'=> 'Có '.$this->affectedRows().' phần tử được thay đổi trạng thái!'));
			}else{
				Session::set('message',array('class'=>'error','content'=>'Vui long chon phần tử thay đổi trạng thái!'));
			}
		}
	}
	public function deleteItems($arrParam,$option = null){
		if ($option['task'] == null) {
			if (!empty($arrParam['cid' ])) {
				$ids = $this->createWhereDeleteSQL($arrParam['cid']);
				$query = "DELETE FROM `$this->table` WHERE `id` IN ($ids) ";
				$this->query($query);
				Session::set('message', array('class'=> 'success', 'content'=> 'Có '.$this->affectedRows().' Phần tử đã được xóa!'));

			}else{
				Session::set('message',array('class'=>'error','content'=>'Vui long chon phần tử muốn xóa!'));
			}
		}
	}
	public function saveItems($arrParam,$option = null){
		if ($option['task'] == 'add') {
			$arrParam['form']['created'] = date('Y-m-d',time());
			$arrParam['form']['created_by'] = 1;
			$arrParam['form']['password'] = md5($arrParam['form']['password']);
			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class'=> 'success', 'content'=> 'saved success!'));
			return $this->lastID();
		}
		if ($option['task'] == 'edit') {
			$arrParam['form']['modified'] = date('Y-m-d',time());
			$arrParam['form']['modified_by'] = 10;

			if ($arrParam['form']['password']!=null) {
				$arrParam['form']['password']= md5($arrParam['form']['password']);
			}else{
				unset($arrParam['form']['password']);
			}
			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data,array(array('id',$arrParam['form']['id'])));
			Session::set('message', array('class'=> 'success', 'content'=> 'saved success !'));
			return $arrParam['form']['id'];
		}
	}
	public function ordering($arrParam,$option = null){

		if (!empty($arrParam['order'])) {
			foreach ($arrParam['order'] as $id => $ordering) {
				$i;
				$query = "UPDATE `$this->table` SET `ordering` = $ordering WHERE `id` = $id ";
				$this->query($query);
				$i++;
			}
			Session::set('message', array('class'=> 'success', 'content'=> 'Có '.$i.' Phần tử đã được ordering  !'));
		}
	}

}