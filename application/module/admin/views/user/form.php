	 	<?php 
	require_once (MODULE_PATH.'admin/views/toolbar.php');
	 	require_once 'submenu/index.php'; 
	 	$dataForm  =  isset($this->arrParams['form']) ? $this->arrParams['form'] : $this->arrParams['form'] =null;
	 	$inputUserName = Helper::cmsInput('text','form[username]','username',$dataForm['username'],'inputbox required',40);
	 	$inputEmail = Helper::cmsInput('text','form[email]','email',$dataForm['email'],'inputbox required',40);
	 	$inputFullName = Helper::cmsInput('text','form[fullname]','fullname',$dataForm['fullname'],'inputbox',40);
	 	$inputPassword = Helper::cmsInput('text','form[password]','password',$dataForm['password'],'inputbox required',40);
	 	$inputOrdering = Helper::cmsInput('text','form[ordering]','ordering',$dataForm['ordering'],'inputbox',40);
	 	$inputToken = Helper::cmsInput('hidden','form[token]','token',time());
	 	$slbStatus = Helper::cmsSelectbox('form[status]',null,array('default'=>'-Select status-','0'=>'Unpublish',1=>'Publish',),$dataForm['status'],'width:180px');
	 	$slbGroup = Helper::cmsSelectbox('form[group_id]','inputbox',$this->slbGroup,$this->arrParams['form']['fullname']);


// row
	 	$rowUsername = Helper::cmsRowForm('UserName',$inputUserName,true);
	 	$rowEmail = Helper::cmsRowForm('Email',$inputEmail,true);
	 	$rowFullName = Helper::cmsRowForm('FullName',$inputFullName);
	 	$rowPassword = Helper::cmsRowForm('Password',$inputPassword,true);
	 	$rowOrdering  = Helper::cmsRowForm('Ordering',$inputOrdering);
	 	$rowStatus = Helper::cmsRowForm('Status',$slbStatus);
	 	$rowGroup = Helper::cmsRowForm('Group',$slbGroup);
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
	 							<?php echo $rowUsername.$rowEmail.$rowFullName.$rowPassword.$rowStatus.$rowGroup.$rowOrdering; ?>
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