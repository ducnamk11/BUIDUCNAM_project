 <?php 
$imageURL = $this->_dirImg;
 $arrMenu = array(
 	array('change Pass'	,'/changepass.png'	,URL::createLink('default','user','index')),
 	array('View Cart'	,'/cart.png'		,URL::createLink('default','user','cart')),
 	array('History'		,'/history.png'		,URL::createLink('default','user','history')),
 	array('Logout'		,'/Logout.png'		,URL::createLink('default','index','logout')),
 );

 $xhtml= '';
 foreach ($arrMenu as $key => $value) {
 	$xhtml.= 
 	' <div class="new_prod_box"><a href="'.$value[2].'">'.$value[0].'</a>
	 	<div class="new_prod_bg">
	 		<a href="'.$value[2].'"><img class="thumb" src="'.$imageURL.$value[1].'" ></a>
	 	</div>
 	</div>';
 }
 ?>


 <div class="title">
 	<span class="title_icon">
 		<img src="<?php echo $imageURL; ?>/bullet1.gif">
 	</span>
 	My account
 </div>
 <div class="clear"></div>
  
<?php echo $xhtml; ?>