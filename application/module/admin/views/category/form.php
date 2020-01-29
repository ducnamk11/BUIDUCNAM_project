	 	<?php 
	 	require_once (MODULE_PATH.'admin/views/toolbar.php');
	 	require_once 'submenu/index.php'; 
// input
	 	
	 	$dataForm  = isset($this->arrParam['form']) ? $this->arrParam['form'] : $this->arrParam['form'] =null;
	 	$inputName = Helper::cmsInput('text','form[name]','name',$dataForm['name'],'inputbox required',40);
	 	$inputOrdering = Helper::cmsInput('text','form[ordering]','ordering',$dataForm['ordering'],'inputbox',40);
	 	$inputToken = Helper::cmsInput('hidden','form[token]','token',time());
	 	$selectboxStatus = Helper::cmsSelectbox('form[status]',null,array('default'=>'-Select status-','0'=>'Unpublish',1=>'Publish',),$dataForm['status'],'width:180px');
	 	$inputPicture  = Helper::cmsInput('file','picture','picture',null,'inputbox',40);

// row
	 	$inputPictureHidden = '';
	 	$picture = '';
	 	if (isset($this->arrParam['id'])) {
	 		$inputID = Helper::cmsInput('text','form[id]','id',$dataForm['id'],'inputbox readonly');
	 		$rowID = Helper::cmsRowForm('ID',$inputID);
	 		$picture = '<img src="'.UPLOAD_URL.'category'.DS.'60x90-'.$dataForm['picture'].'" />';
	 		$inputPictureHidden  = Helper::cmsInput('hidden','form[picture_hidden]','picture_hidden',null,'inputbox',40);
	 	}

	 	$rowName = Helper::cmsRowForm('Name',$inputName,true);
	 	$rowOrdering  = Helper::cmsRowForm('Ordering',$inputOrdering);
	 	$rowStatus = Helper::cmsRowForm('Status',$selectboxStatus);
	 	$rowPicture = Helper::cmsRowForm('Picture',$inputPicture.$picture.$inputPictureHidden);
	 	$message = Session::get('message');	
	 	Session::delete('message');
	 	$strMessage = Helper::cmsMessage($message);
	 	?>
	 	<div id="system-message-container"><?php echo ((isset($this->errors)) ? $this->errors : '').$strMessage;  ?></div>
	 	<div id="element-box">
	 		<div class="m">
	 			<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	 				<!-- FORM LEFT -->
	 				<div class="width-100 fltlft">
	 					<fieldset class="adminform">
	 						<legend>Details</legend>
	 						<ul class="adminformlist">
	 							<?php echo $rowName.$rowStatus.$rowOrdering.$rowPicture; ?>
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