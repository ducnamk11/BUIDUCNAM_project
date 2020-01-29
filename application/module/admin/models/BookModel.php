<?php
class BookModel extends Model{
	private $_columns = array('id','name','description','created','special','price','sale_off','picture','created_by','modified','modified_by','status','ordering','category_id');
	function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_BOOK);
	} 
	public function countItem($arrParam,$option = null){

		$query[] = "SELECT COUNT(`id`) AS `total`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id` >0" ;

 		//SEARCH
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND (`name` LIKE $keyword )" ;
		}
		//filter status
		if (isset($arrParam['filter_state']) && $arrParam['filter_state']  !='default')  {
			$status = ($arrParam['filter_state']=='unpublish') ? 0 : 1;
			$query[] = "AND `status` ='". $status."'" ;
		}
				// FILTER : special
		if(isset($arrParam['filter_special']) && $arrParam['filter_special'] != 'default'){
			$query[]	= "AND `special` = '" . $arrParam['filter_special'] . "'";
		}
				//filter group
		if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id']  !='default')  {
			$query[] = "AND `category_id` ='". $arrParam['filter_category_id']."'" ;
		}
		$query = implode(" ",$query);
		$result = 	$this->fetchRow($query);
		return $result['total'];
	}

	public function itemInSelecbox($arrParam,$option = null){
		$result = '';
		if ($option ==  null) {
			$query = "SELECT `id` ,`name` FROM `".TBL_CATEGORY."`";
			$result = $this->fetchPairs($query);
			$result['default']   = '- select category -';
			ksort($result);
		}
		return $result;
	}

	public function listItem($arrParam,$option = null){
		$query[]	= "SELECT `b`.`id`, `b`.`special`, `b`.`name`, `b`.`picture`, `b`.`price`, `b`.`sale_off`, `b`.`status`, `b`.`ordering`, `b`.`created`, `b`.`created_by`, `b`.`modified`, `b`.`modified_by`, `c`.`name` AS `category_name`";
		$query[]	= "FROM `$this->table` AS `b` LEFT JOIN `". TBL_CATEGORY . "` AS `c` ON `b`.`category_id` = `c`.`id`";
		$query[]	= "WHERE `b`.`id` > 0";
		//SEARCH
		if (!empty($arrParam['filter_search']) ) {
			$keyword = '"%'.$arrParam['filter_search'].'%"';
			$query[] = "AND (`b`.`name` LIKE $keyword )" ;
		}
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
			$query[]	= "AND `b`.`status` = '" . $arrParam['filter_state'] . "'";
		}
			// FILTER : special
		if(isset($arrParam['filter_special']) && $arrParam['filter_special'] != 'default'){
			$query[]	= "AND `b`.`special` = '" . $arrParam['filter_special'] . "'";
		}
						//filter group
		if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id']  !='default')  {
			$query[] = "AND b.`category_id` ='". $arrParam['filter_category_id']."'" ;
		}

		//SORT
		if (!empty($arrParam['filter_column']) &&  !empty($arrParam['filter_column_dir'])) {
			$column  =$arrParam['filter_column'];
			$columnDir  =$arrParam['filter_column_dir'];
			$query[] = "ORDER BY `b`.`$column` $columnDir";
		}
		else{
			$query[] = "ORDER BY `b`.`id` DESC";
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
			$query[]="SELECT `id`,`name`,`price`,`picture`,`special`,`description`,`sale_off`,`category_id`,`status`, `ordering`";
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
				'link' =>URL::createLink('admin','book','ajaxStatus',array('id'=>$id,'status'=>$status)));
			return $result;
		}
		if ($option['task'] == 'change-ajax-special') {
			$special = ($arrParam['special'] ==0) ? 1 : 0;
			$id = $arrParam['id'];
			$query = "UPDATE `$this->table` SET special = $special WHERE `id` = $id ";
			$this->query($query);
			$result =   array( 	'id'=>$id,
				'special'=>$special,
				'link' =>URL::createLink('admin','book','ajaxSpecial',array('id'=>$id,'special'=>$special)));
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
		$userObj = Session::get('user');
		$userInfo= $userObj['info'];
		require_once LIBRARY_EXT_PATH.'Upload.php';
		$uploadObj = new Upload();
		if ($option['task'] == 'add') {
			$arrParam['form']['picture'] = $uploadObj->uploadFile($arrParam['form']['picture'],'book',98,150);
			$arrParam['form']['created'] = date('Y-m-d',time());
			$arrParam['form']['created_by'] = 'this one';
			//loai bo gia gia tri tokken trong 	$arrParam['form']
			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class'=> 'success', 'content'=> 'saved success!'));
			return $this->lastID();
		}
		if ($option['task'] == 'edit') {
			if ($arrParam['form']['name'] == null) {
				unset($arrParam['form']['picture']);
			}else{
				$uploadObj->removeFile('book',$arrParam['form']['picture_hidden']);
				$uploadObj->removeFile('book','98x150-'.$arrParam['form']['picture_hidden']);
				$arrParam['form']['picture'] = $uploadObj->uploadFile($arrParam['form']['picture'],'book',98,150);

			}
			$arrParam['form']['modified']    = date('Y-m-d',time());
			$arrParam['form']['modified_by'] = 10;
			$arrParam['form']['name']        = mysql_real_escape_string($arrParam['form']['name']);
			$arrParam['form']['description'] = mysql_real_escape_string($arrParam['form']['description']);
			
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