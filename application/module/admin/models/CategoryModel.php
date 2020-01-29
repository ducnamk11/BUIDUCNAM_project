<?php
class CategoryModel extends Model{
	private $_columns = array('id','name','picture','created','created_by','modified','modified_by','status','ordering');
	private $_userInfo;
	function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_CATEGORY);
		$userObj =  Session::get('user');
		$this->_userInfo= $userObj['info']; 
	} 
	public function countItem($arrParam,$option = null){

		$query[] = "SELECT COUNT(`id`) AS `total`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id` >0" ;

		//SEARCH
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND `name` LIKE $keyword" ;
		}

		//filter status
		if (isset($arrParam['filter_state']) && $arrParam['filter_state']  !='default')  {
			$status = ($arrParam['filter_state']=='unpublish') ? 0 : 1;
			$query[] = "AND `status` ='". $status."'" ;
		}

		$query = implode(" ",$query);
		$result = 	$this->fetchRow($query);

 		return $result['total'];
	}
	
	public function infoItem($arrParam,$option = null){
		$query[] = "SELECT id , name, picture, status, ordering,created ,created_by ,modified ,modified_by ";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id` > 0" ;
		//SEARCH
		$flagWhere =false;
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND `name` LIKE $keyword" ;
			
		}
		//select box status
		if (isset($arrParam['filter_state']) && $arrParam['filter_state'] !='default')  {
			$status = ($arrParam['filter_state']=='unpublish') ? 0 : 1;
			$query[] = "AND `status` ='". $status."'" ;
		}

		//FILTER
		if (!empty($arrParam['filter_column']) &&  !empty($arrParam['filter_column_dir'])) {
			$column  =$arrParam['filter_column'];
			$columnDir  =$arrParam['filter_column_dir'];
			$query[] = "ORDER BY `$column` $columnDir";
		}
		else{
			$query[] = "ORDER BY `name` ASC";
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

	public function changeStatus($arrParam,$option = null){
		if ($option['task'] == 'change-ajax-status') {
			$status = ($arrParam['status'] ==0) ? 1 : 0;
			$modified = date('Y-m-d',time());
			$modified_by =  $this->_userInfo['username'];
			$id = $arrParam['id'];
			$query = "UPDATE `$this->table` SET status = $status, modified = '$modified', modified_by = '$modified_by' WHERE `id` = $id ";
			$this->query($query);
			$result =   array( 	'id'=>$id,
				'status'=>$status,
				'link' =>URL::createLink('admin','category','ajaxStatus',array('id'=>$id,'status'=>$status)));
			return $result;
		}

		if ($option['task'] == 'change-status') {
			$status =  $arrParam['type'];
			$modified = date('Y-m-d',time());
			$modified_by =  $this->_userInfo['username'];
			if (!empty($arrParam['cid' ])) {
				$ids = $this->createWhereDeleteSQL($arrParam['cid']);
				$query = "UPDATE `$this->table` SET status = $status, modified = '$modified', modified_by = '$modified_by' WHERE `id` IN ($ids) ";
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

//remove image
				$query = "SELECT id,picture AS name FROM $this->table WHERE id IN ($ids)";
				$arrImage  = $this->fetchPairs($query);
				require_once LIBRARY_EXT_PATH.'Upload.php';
				$uploadObj = new Upload();
				foreach ($arrImage as $value) {
					$uploadObj->removeFile('category',$value);
					$uploadObj->removeFile('category','60x90-'.$value);
				}

				$query = "DELETE FROM `$this->table` WHERE `id` IN ($ids) ";
				$this->query($query);
				Session::set('message', array('class'=> 'success', 'content'=> 'Có '.$this->affectedRows().' Phần tử đã được xóa!'));
			}else{
				Session::set('message',array('class'=>'error','content'=>'Vui long chon phần tử muốn xóa!'));
			}
		}
	}
	public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `id`, `name`, `picture`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`";
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `id` > 0";
		
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])){
			$keyword	= '"%' . $arrParam['filter_search'] . '%"';
			$query[]	= "AND `name` LIKE $keyword";
		}
		
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
			$query[]	= "AND `status` = '" . $arrParam['filter_state'] . "'";
		}
		
		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
			$column		= $arrParam['filter_column'];
			$columnDir	= $arrParam['filter_column_dir'];
			$query[]	= "ORDER BY `$column` $columnDir";
		}else{
			$query[]	= "ORDER BY `id` DESC";
		}  
		
		// PAGINATION
		$pagination			= $arrParam['pagination'];
		$totalItemsPerPage	= $pagination['totalItemsPerPage'];
		if($totalItemsPerPage > 0){
			$position	= ($pagination['currentPage']-1)*$totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}

		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
	}
	
	public function saveItems($arrParam,$option = null){
		$userObj = Session::get('user');
		$userInfo= $userObj['info']; 
		require_once LIBRARY_EXT_PATH.'Upload.php';
		$uploadObj = new Upload();
		if ($option['task'] == 'add') {
			$arrParam['form']['picture'] = $uploadObj->uploadFile($arrParam['form']['picture'],'category');
			$arrParam['form']['created'] = date('Y-m-d',time());
			$arrParam['form']['created_by'] = $this->_userInfo['username'];

			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class'=> 'success', 'content'=> 'Dữ liệu được lưu thành công !'));
			return $this->lastID();
		}

		if ($option['task'] == 'edit') {
	 	
			$arrParam['form']['modified'] = date('Y-m-d',time());
			$arrParam['form']['modified_by'] = $this->_userInfo['username'];
			if ($arrParam['form']['name'] == null) {
				unset($arrParam['form']['picture']);
			}else{
				$uploadObj->removeFile('category',$arrParam['form']['picture_hidden']);
				$uploadObj->removeFile('category','60x90-'.$arrParam['form']['picture_hidden']);
				$arrParam['form']['picture'] = $uploadObj->uploadFile($arrParam['form']['picture'],'category');

			}
			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data,array(array('id',$arrParam['form']['id'])));
			Session::set('message', array('class'=> 'success', 'content'=> 'Dữ liệu được lưu thành công !'));
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