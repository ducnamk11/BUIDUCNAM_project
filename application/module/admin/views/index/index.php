<?php 
 $imageURL = $this->_dirImg;
$xhtml='';
$arrMenu = array(
	array('link'=>URL::createLink('admin','book','form'),'name' => 'add new book','image'=>'icon-48-article-add.png'),
	array('link'=>URL::createLink('admin','book','index'),'name' => 'Book manage','image'=>'icon-48-article.png'),
	array('link'=>URL::createLink('admin','category','index'),'name' => 'category manage','image'=>'icon-48-category.png'),
	array('link'=>URL::createLink('admin','group','index'),'name' => 'Group manage','image'=>'icon-48-groups.png'),
	array('link'=>URL::createLink('admin','user','index'),'name' => 'User manage','image'=>'icon-48-user.png'),
);
foreach ($arrMenu as $key => $value) {
	$xhtml .= '<div class="icon-wrapper">
		<div class="icon">
			<a href="'.$value["link"].'">
				<img src="'.$imageURL.'/header/'.$value['image'].'" alt="">
				<span>'.$value['name'].'</span>
			</a>
		</div>
	</div>';
}
?>
<div id="element-box">
	<div id="system-message-container"></div>
	<div class="m">
		<div class="adminform">
			<div class="cpanel-left">
				<div class="cpanel"><?php echo $xhtml; ?></div>
			</div>

		</div>
		<div class="clr"></div>
	</div>
</div>