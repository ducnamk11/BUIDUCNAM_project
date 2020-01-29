
<div id="content-box">
	<?php 
	require_once (MODULE_PATH.'admin/views/toolbar.php');
	require_once 'submenu/index.php';  
	$columPost = isset($this->arrParam['filter_column']) ? $this->arrParam['filter_column'] : "Name" ;
	$orderPost = isset($this->arrParam['filter_column_dir']) ? $this->arrParam['filter_column_dir'] : "asc" ;
	$filterSearch = isset($this->arrParam['filter_search']) ? $this->arrParam['filter_search'] : "" ;
	$filterState     = isset($this->arrParam['filter_state'])? $this->arrParam['filter_state'] : '';  
	$filterSpecial     = isset($this->arrParam['filter_special'])? $this->arrParam['filter_special'] : '';  
	$filterCategory   = isset($this->arrParam['filter_group_id'])? $this->arrParam['filter_group_id'] : '';  

// COLUMN
	$lblUserName       = Helper::cmsLinkSort('UserName','username',$columPost,$orderPost);
	$lblPrice       = Helper::cmsLinkSort('Price','price',$columPost,$orderPost);
	$lblName     = Helper::cmsLinkSort('Name','name',$columPost,$orderPost);
	$lblPicture    = Helper::cmsLinkSort('Picture','picture',$columPost,$orderPost);

	$lblSaleOff     = Helper::cmsLinkSort('Sale Off','sale_off',$columPost,$orderPost);
	$lblCategory   = Helper::cmsLinkSort('Category','category_id',$columPost,$orderPost);
	$lblOrdering   = Helper::cmsLinkSort('Ordering','ordering',$columPost,$orderPost);
	$lblStatus   = Helper::cmsLinkSort('Status','status',$columPost,$orderPost);
	$lblSpecial   = Helper::cmsLinkSort('Special','special',$columPost,$orderPost);
	$lblCreated    = Helper::cmsLinkSort('Created','created',$columPost,$orderPost);
	$lblCreatedby  = Helper::cmsLinkSort('Created By','created_by',$columPost,$orderPost);
	$lblModified   = Helper::cmsLinkSort('Modified','modified',$columPost,$orderPost);
	$lblModifiedBy = Helper::cmsLinkSort('Modified By','modified_by',$columPost,$orderPost);
	$lblID         = Helper::cmsLinkSort('ID','id',$columPost,$orderPost);

	//select status
	$arrStatus       =  array('default'=>'- select status -',1=>'Publish' , 0 =>'Unpublish');           
	$selectboxStatus = Helper::cmsSelectbox('filter_state','inputbox',$arrStatus,$filterState);

	//select special
	$arrSpecial       =  array('default'=>'- select special -',1=>'Yes' , 2 =>'No');           
	$selectboxSpecial = Helper::cmsSelectbox('filter_special','inputbox',$arrSpecial,$filterSpecial); 

 	//select  
	$selectboxCategory = Helper::cmsSelectbox('filter_category_id','inputbox',$this->slbCategory,$filterCategory);
	
// pagination
	$paginationHTML = $this->pagination->showPagination(URL::createLink('admin','book','index'));
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
						<?php echo $selectboxStatus.$selectboxSpecial.$selectboxCategory; ?>
					</div>
				</fieldset>
				<div class="clr"> </div>
				<table class="adminlist" id="modules-mgr">
					<!-- HEADER TABLE -->
					<thead>
						<tr>
							<th width="1%"> <input type="checkbox" name="checkall-toggle" > </th>
							<th class="title"><?php echo $lblName; ?></th> 
							<th class="title"><?php echo $lblPicture; ?></th> 
							<th width="7%"><?php echo $lblPrice; ?></th> 
							<th width="5%"><?php echo $lblSaleOff; ?></th> 
							<th width="10%"><?php echo $lblCategory; ?></th> 
							<th width="10%"><?php echo $lblOrdering; ?></th> 
							<th width="5%"><?php echo $lblStatus; ?></th> 
							<th width="5%"><?php echo $lblSpecial; ?></th> 
							<th width="7%"><?php echo $lblCreated; ?></th> 
							<th width="7%"><?php echo $lblCreatedby; ?></th> 
							<th width="7%"><?php echo $lblModified; ?></th> 
							<th width="7%"><?php echo $lblModifiedBy; ?></th> 
							<th width="3%"><?php echo $lblID; ?></th> 
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
								$name        = $value['name'];
								$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];

								if (file_exists($picturePath)) {
									$picture     = '<img width="60px" height = "90px" src="'.UPLOAD_URL.'book'.DS.'98x150-'.$value['picture'].'"';
								}else{
									$picture     = '<img width="60px" height = "90px" src="'.UPLOAD_URL.'book'.DS.'60x90-default.jpg'.'"';
								}	
								$price        = $value['price'];
								$sale_off        = $value['sale_off'];
								$category_id        = $value['category_name'];
								$row         = ($i%2 ==0) ? 'row0' : 'row1';
								$status 	 = Helper::cmsStatus($value['status'],URL::createLink('admin','book','ajaxStatus',array('id'=>$id,'status'=>$value['status'])),$id);
								$special 	 = Helper::cmsSpecial($value['special'],URL::createLink('admin','book','ajaxSpecial',array('id'=>$id,'special'=>$value['special'])),$id);

								$ordering    = 	'<input type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'   "   class="text-area-order">';
								$created     = 	Helper::formatDate('d-m-Y',$value['created']);
								$created_by  = 	$value['created_by'];
								$modified     = Helper::formatDate('d-m-Y',$value['modified']);
								$modified_by = 	$value['modified_by'];
								$linkEdit = URL::createLink('admin','book','form',array('id'=>$id))
								?>
								<tr class="<?php echo $row; ?>">
									<td class="center"><?php echo $ckb; ?></td>
									<td><a href="<?php echo $linkEdit;  ?>"><?php echo $name; ?></a></td>
									<td class="center"> <?php echo $picture; ?></td>
									<td class="center"> <?php echo $price; ?></td>
									<td class="center"> <?php echo $sale_off; ?></td>
									<td class="center"> <?php echo $category_id; ?></td>
									<td class="order">	<?php echo $ordering  ; ?></td>
									<td class="center"> <?php echo $status; ?></td>
									<td class="center"> <?php echo $special; ?></td>
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
					<input type="hidden" name="filter_column" value="name">
					<input type="hidden" name="filter_page" value="1">
					<input type="hidden" name="filter_column_dir" value="desc">
				</form>
				<div class="clr"></div>
			</div>
		</div>
	</div>