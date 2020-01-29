	 	<?php 
	require_once (MODULE_PATH.'admin/views/toolbar.php');
	 	require_once 'submenu/index.php'; 
// input
	 	// echo '<pre> view';
	 	// print_r($this->arrParam);
	 	// echo '</pre>';	
	 	$dataForm  = isset($this->arrParam['form']) ? $this->arrParam['form'] : $this->arrParam['form'] =null;
	 	$inputName = Helper::cmsInput('text','form[name]','name',$dataForm['name'],'inputbox required',40);
	 	$inputOrdering = Helper::cmsInput('text','form[ordering]','ordering',$dataForm['ordering'],'inputbox',40);
	 	$inputToken = Helper::cmsInput('hidden','form[token]','token',time());
	 	$selectboxStatus = Helper::cmsSelectbox('form[status]',null,array('default'=>'-Select status-','0'=>'Unpublish',1=>'Publish',),$dataForm['status'],'width:180px');
	 	$selectboxGroupACP = Helper::cmsSelectbox('form[group_acp]',null,array('default'=>'- Select Group ACP -',0=>'Yes',1=>'No'),$dataForm['group_acp'],'width:180px');

// row
	 	$rowName = Helper::cmsRowForm('Name',$inputName,true);
	 	$rowOrdering  = Helper::cmsRowForm('Ordering',$inputOrdering);
	 	$rowStatus = Helper::cmsRowForm('Status',$selectboxStatus);
	 	$rowGroupACP = Helper::cmsRowForm('Group ACP',$selectboxGroupACP);
	 	$message = Session::get('message');	
	 	Session::delete('message');
	 	$strMessage = Helper::cmsMessage($message);
	 	?>
	 	<div id="system-message-container"><?php echo ((isset($this->errors)) ? $this->errors : '').$strMessage;  ?></div>
	 	<div id="element-box">
	 		<div class="m">
	 			<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
	 				<!-- FORM LEFT -->
	 				<div class="width-100 fltlft">
	 					<fieldset class="adminform">
	 						<legend>Details</legend>
	 						<ul class="adminformlist">
	 							<?php echo $rowName.$rowStatus.$rowGroupACP.$rowOrdering; ?>
	 						</ul>
	 						<div class="clr"></div>
	 						<div>
	 							<?php echo $inputToken; ?>
	 						</div>
	 					</fieldset>
	 				</div>
	 				<div class="clr"></div>
	 				<div>
	 				</div>
	 			</form>
	 			<div class="clr"></div>
	 		</div>
	 	</div>