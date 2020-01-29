	 
<?php 
require_once (MODULE_PATH.'admin/views/toolbar.php');
require_once 'submenu/index.php'; 
$dataForm  =  isset($this->arrParams['form']) ? $this->arrParams['form'] : $this->arrParams['form'] =null;
$inputName = Helper::cmsInput('text','form[name]','name',$dataForm['name'],'inputbox required',40);
$inputDescription = '<textarea name="form[description]">'.$dataForm['description'].'</textarea>';
$inputPrice = Helper::cmsInput('text','form[price]','price',$dataForm['price'],'inputbox require',40);
$inputSaleOff = Helper::cmsInput('text','form[sale_off]','sale_off',$dataForm['sale_off'],'inputbox',40);
$inputOrdering = Helper::cmsInput('text','form[ordering]','ordering',$dataForm['ordering'],'inputbox',40);
$inputToken = Helper::cmsInput('hidden','form[token]','token',time());
$slbStatus = Helper::cmsSelectbox('form[status]',null,array('default'=>'-Select status-','0'=>'Unpublish',1=>'Publish',),$dataForm['status'],'width:180px');
$slbSpecial = Helper::cmsSelectbox('form[special]',null,array('default'=>'-Select special-','0'=>'No',1=>'YES',),$dataForm['special'],'width:180px');
$slbCategory = Helper::cmsSelectbox('form[category_id]','inputbox',$this->slbCategory,$this->arrParams['form']['fullname']);
// picture//
$inputPicture  = Helper::cmsInput('file','picture','picture',$dataForm['picture'],'inputbox',40);
$picture = '';
// row
$inputPictureHidden = '';
if (isset($this->arrParam['id'])) {
	$inputID = Helper::cmsInput('text','form[id]','id',$dataForm['id'],'inputbox readonly');
	$rowID = Helper::cmsRowForm('ID',$inputID);
	$picture = '<img src="'.UPLOAD_URL.'book'.DS.'98x150-'.$dataForm['picture'].'" />';
	$inputPictureHidden  = Helper::cmsInput('hidden','form[picture_hidden]','picture_hidden',null,'inputbox',40);
}


// row
$rowName = Helper::cmsRowForm('Name',$inputName,true);
$rowDescription = Helper::cmsRowForm('description',$inputDescription);
$rowPicture = Helper::cmsRowForm('Picture',$inputPicture.$picture);
$rowPrice = Helper::cmsRowForm('Price',$inputPrice,true);
$rowSaleOff = Helper::cmsRowForm('SaleOff',$inputSaleOff,true);
$rowOrdering  = Helper::cmsRowForm('Ordering',$inputOrdering,true);
$rowStatus = Helper::cmsRowForm('Status',$slbStatus);
$rowSpecial = Helper::cmsRowForm('Special',$slbSpecial);
$rowCategory = Helper::cmsRowForm('Category',$slbCategory);
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
						<?php echo $rowName.$rowPrice.$rowSaleOff.$rowStatus.$rowSpecial.$rowCategory.$rowOrdering.$rowPicture.$rowDescription; ?>
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