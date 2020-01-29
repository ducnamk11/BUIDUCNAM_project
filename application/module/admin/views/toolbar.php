<?php 
$controller = $this->arrParam['controller'];
$linknew = URL::createLink('admin',$controller,'form');
$bntNew = Helper::cmsButton('new','toolbar-popup-new','icon-32-new',$linknew);
// publich
$linkPublic = URL::createLink('admin',$controller,'status',array('type'=>1));
$bntPublic = Helper::cmsButton('Publish','toolbar-publish','icon-32-publish',$linkPublic,'submit');
//unpublic
$linkUnPublic = URL::createLink('admin',$controller,'status',array('type'=>0));
$bntUnPublic = Helper::cmsButton('Unpublish','toolbar-unpublish','icon-32-unpublish',$linkUnPublic,'submit');
//trash
$linkTrash = URL::createLink('admin',$controller,'trash');
$bntTrash = Helper::cmsButton('Trash','toolbar-trash','icon-32-trash',$linkTrash,'submit');

//ordering
$linkOrdering = URL::createLink('admin',$controller,'ordering');
$bntOrdering  = Helper::cmsButton('Ordering','toolbar-checkin','icon-32-checkin',$linkOrdering,'submit');

//save
$linkSave = URL::createLink('admin',$controller,'form',array('type'=>'save'));
$bntSave = Helper::cmsButton('Save','toolbar-apply','icon-32-apply',$linkSave,'submit');

//save close
$linkSaveClose = URL::createLink('admin',$controller,'form',array('type'=>'save-close'));
$bntSaveClose = Helper::cmsButton('Save & Close','toolbar-save','icon-32-save',$linkSaveClose,'submit');

//save new
$linkSaveNew = URL::createLink('admin',$controller,'form',array('type'=>'save-new'));
$bntSaveNew = Helper::cmsButton('Save & New','toolbar-save-new','icon-32-save-new',$linkSaveNew,'submit');

//save cancel
$linkCancel = URL::createLink('admin',$controller,'index');
$bntCancel = Helper::cmsButton('Cancel','toolbar-cancel','icon-32-cancel',$linkCancel);

$strButton = '';

switch ($this->arrParam['action']) {
	case 'index':
	if ($controller == 'group') {
		$strButton = $bntPublic.$bntUnPublic.$bntOrdering;
	}else{
		$strButton = $bntNew.$bntPublic.$bntUnPublic.$bntOrdering.$bntTrash;
	}
	break;
	case 'form':
	$strButton = $bntSave.$bntSaveClose.$bntSaveNew.$bntCancel;
	break;
	case 'profile':
	$strButton = $bntSave.$bntSaveClose.$bntCancel;
	break;
}

?>
<div id="toolbar-box">
	<div class="m">
		<!-- TOOLBAR -->
		<div class="toolbar-list" id="toolbar">
			<ul>
				<?php echo $strButton; ?>
			</ul>
			<div class="clr"></div>
		</div>
		<!-- TITLE -->
		<div class="pagetitle icon-48-module"><h2><?php echo $this->_title; ?></h2></div>
	</div>
</div>