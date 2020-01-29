	 	<?php 
	 	require_once (MODULE_PATH.'admin/views/toolbar.php');
	 	
	 	$dataForm  =  isset($this->arrParams['form']) ? $this->arrParams['form'] : $this->arrParams['form'] =null;
	 	$inputEmail = Helper::cmsInput('text','form[email]','email',$dataForm['email'],'inputbox required',40);
	 	$inputFullName = Helper::cmsInput('text','form[fullname]','fullname',$dataForm['fullname'],'inputbox',40);
	 	$inputID = Helper::cmsInput('text','form[id]','id',$dataForm['id'],'inputbox readonly');
// row
	 	$rowEmail = Helper::cmsRowForm('Email',$inputEmail,true);
	 	$rowID = Helper::cmsRowForm('ID',$inputID);
	 	$rowFullName = Helper::cmsRowForm('FullName',$inputFullName);

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
	 							<?php echo $rowEmail.$rowFullName.$rowID; ?>
	 						</ul>
	 						<div class="clr"></div>

	 					</fieldset>
	 				</div>
	 				<div class="clr"></div>
	 				<div>
	 				</div>
	 			</form>
	 			<div class="clr"></div>
	 		</div>
	 	</div>