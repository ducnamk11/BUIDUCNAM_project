
<div id="content-box">
	<?php 
	require_once (MODULE_PATH.'admin/views/toolbar.php');
	require_once 'submenu/index.php';  
	$columPost = isset($this->arrParam['filter_column']) ? $this->arrParam['filter_column'] : "Name" ;
	$orderPost = isset($this->arrParam['filter_column_dir']) ? $this->arrParam['filter_column_dir'] : "asc" ;
	$filterSearch = isset($this->arrParam['filter_search']) ? $this->arrParam['filter_search'] : "" ;
	$filterState     = isset($this->arrParam['filter_state'])? $this->arrParam['filter_state'] : '';  
	$filterGroup    = isset($this->arrParam['filter_group_id'])? $this->arrParam['filter_group_id'] : '';  

// COLUMN
	$lblUserName       = Helper::cmsLinkSort('UserName','username',$columPost,$orderPost);
	$lblEmail       = Helper::cmsLinkSort('Email','email',$columPost,$orderPost);
	$lblFullName     = Helper::cmsLinkSort('FullName','fullname',$columPost,$orderPost);
	$lblGroup   = Helper::cmsLinkSort('Group','group_id',$columPost,$orderPost);
	$lblOrdering   = Helper::cmsLinkSort('Ordering','ordering',$columPost,$orderPost);
	$lblStatus   = Helper::cmsLinkSort('Status','status',$columPost,$orderPost);
	$lblCreated    = Helper::cmsLinkSort('Created','created',$columPost,$orderPost);
	$lblCreatedby  = Helper::cmsLinkSort('Created By','created_by',$columPost,$orderPost);
	$lblModified   = Helper::cmsLinkSort('Modified','modified',$columPost,$orderPost);
	$lblModifiedBy = Helper::cmsLinkSort('Modified By','modified_by',$columPost,$orderPost);
	$lblID         = Helper::cmsLinkSort('ID','id',$columPost,$orderPost);

	//select status
	$arrStatus       =  array('default'=>'- select status -','publish'=>'Publish' , 'unpublish'=>'Unpublish');           
	$selectboxStatus = Helper::cmsSelectbox('filter_state','inputbox',$arrStatus,$filterState);

 	//select group
	$selectboxGroup = Helper::cmsSelectbox('filter_group_id','inputbox',$this->slbGroup,$filterGroup);
	
// pagination
	$paginationHTML = $this->pagination->showPagination(URL::createLink('admin','group','index'));
	$message = Session::get('message');	
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);

	?>

	<div id="system-message-container">
		<?php echo $strMessage; ?>
	</div>
	<div id="element-box">
		<div class="m">
			<form action="#" method="post" name="adminForm" id="adminForm">
				<!-- FILTER -->
				<fieldset id="filter-bar">
					<div class="filter-search fltlft">
						<label class="filter-search-lbl" for="filter_search">Filter:</label>
						<input type="text" name="filter_search" id="filter_search" value="<?php echo  $filterSearch; ?>" >
						<button type="submit" name="submit-keyword">Search</button>
						<button type="button" name="clear-keyword" onclick="">Clear</button>
					</div>
					<div class="filter-select fltrt">
						<?php echo $selectboxStatus.$selectboxGroup; ?>
					</div>
				</fieldset>
				<div class="clr"> </div>
				<table class="adminlist" id="modules-mgr">
					<!-- HEADER TABLE -->
					<thead>
						<tr>
							<th width="1%"> <input type="checkbox" name="checkall-toggle" > </th>
							<th class="title"><?php echo $lblUserName; ?></th>
							<th width="10%"><?php echo $lblEmail; ?></th> 
							<th width="10%"><?php echo $lblFullName; ?></th> 
							<th width="10%"><?php echo $lblGroup; ?></th> 
							<th width="10%"><?php echo $lblOrdering; ?></th> 
							<th width="5%"><?php echo $lblStatus; ?></th> 
							<th width="10%"><?php echo $lblCreated; ?></th> 
							<th width="10%"><?php echo $lblCreatedby; ?></th> 
							<th width="10%"><?php echo $lblModified; ?></th> 
							<th width="10%"><?php echo $lblModifiedBy; ?></th> 
							<th width="1%"><?php echo $lblID; ?></th> 
						</tr>
					</thead>
					<!-- FOOTER TABLE -->
					<tfoot>
						<tr>
							<td colspan="12">
								<!-- PAGINATION -->
								<div class="container">
									<?php echo $paginationHTML; ?>
								</div>				
							</td>
						</tr>
					</tfoot>
					<!-- BODY TABLE -->
					<tbody>
						<?php 
						if (!empty($this->Items)) {
							$i= 0;
							foreach ($this->Items as $key => $value) {
								$i++;
								$id          = $value['id'];
								$ckb         = '<input type="checkbox"  name="cid[]" value="'.$id.'" ">';
								$username        = $value['username'];
								$email        = $value['email'];
								$fullname        = $value['fullname'];
								$group_id        = $value['group_name'];
								$row         = ($i%2 ==0) ? 'row0' : 'row1';
								$status 	 = Helper::cmsStatus($value['status'],URL::createLink('admin','user','ajaxStatus',array('id'=>$id,'status'=>$value['status'])),$id);

								$ordering    = 	'<input type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'   "   class="text-area-order">';
								$created     = 	Helper::formatDate('d-m-Y',$value['created']);
								$created_by  = 	$value['created_by'];
								$modified     = Helper::formatDate('d-m-Y',$value['modified']);
								$modified_by = 	$value['modified_by'];
								$linkEdit = URL::createLink('admin','user','form',array('id'=>$id))
								?>
								<tr class="<?php echo $row; ?>">
									<td class="center"><?php echo $ckb; ?></td>
									<td><a href="<?php echo $linkEdit;  ?>"><?php echo $username; ?></a></td>
									<td class="center"> <?php echo $email; ?></td>
									<td class="center"> <?php echo $fullname; ?></td>
									<td class="center"> <?php echo $group_id; ?></td>
									<td class="order">	<?php echo $ordering  ; ?></td>
									<td class="center"> <?php echo $status; ?></td>
									<td class="center"><?php echo $created  ; ?></td>
									<td class="center"><?php echo $created_by  ; ?></td>
									<td class="center"><?php echo $modified  ; ?></td>
									<td class="center"><?php echo $modified_by  ; ?></td>
									<td class="center"><?php echo $id  ; ?></td>
								</tr>	
								<?php 	
							}
						}  
						?>
					</tbody>
				</table>
				<div>
					<input type="hidden" name="filter_column" value="username">
					<input type="hidden" name="filter_page" value="1">
					<input type="hidden" name="filter_column_dir" value="desc">
				</form>
				<div class="clr"></div>
			</div>
		</div>
	</div>