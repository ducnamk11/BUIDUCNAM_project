<?php 	$imageURL = $this->_dirImg;
   ?>
<div class="title"><span class="title_icon">
	<img src="<?php echo $imageURL; ?>/bullet1.gif" alt="" title=""></span>Featured books</div>
	<?php 

	if (!empty($this->specialBooks)) {
		$xhtml = '';
		foreach ($this->specialBooks as  $value) {
			$link = URL::createLink('default','book','detail',array('book_id'=>$value['id']));
			$name = $value['name'];
			$description = substr($value['description'],0,200).'...';
			$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];
			if (file_exists($picturePath)) {
				$picture     = '<img width = "98px" height ="150px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-'.$value['picture'].'"/>';
			}else{
				$picture     = '<img width = "98px" height ="150px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
			}	
			$xhtml .= '
			<div class="feat_prod_box">
			<div class="prod_img"><a href="'.$link.'">'.$picture.'</a></div>
			<div class="prod_det_box">
			<span class="special_icon"><img src="'.$imageURL.'/special_icon.gif" alt="" title=""></span>
			<div class="box_top"></div>
			<div class="box_center">
			<div class="prod_title">'.$name.'</div>
			<p class="details">'.$description.'</p>
			<a href="'.$link.'" class="more">- more details -</a>
			<div class="clear"></div>
			</div>
			<div class="box_bottom"></div>
			</div>    
			<div class="clear"></div>
			</div>  
			';    
		}
	} 
	echo $xhtml;
	?>


	<!-- NEW BOOK -->
	<?php 
	if (!empty($this->newBooks)) {
		$xhtmlNewBook = '';
		foreach ($this->newBooks as  $value) {
			$link = URL::createLink('default','book','detail',array('book_id'=>$value['id']));
			$name = substr($value['name'],0,20) ;
			$description = substr($value['description'],0,200).'...';
			$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];
			if (file_exists($picturePath)) {
				$picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-'.$value['picture'].'"/>';
			}else{
				$picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
			}	
			$xhtmlNewBook .= '
			<div class="new_prod_box">
			<a href="'.$link.'">'.$name.'</a>
			<div class="new_prod_bg">
			<span class="new_icon"><img src=".$imageURL./new_icon.gif" alt="" title=""></span>
			<a href="'.$link.'">'.$picture.'</a>
			</div>           
			</div>
			';    
		}
	} 

	?>
	<div class="clear"></div>

	<!-- NEW BOOK -->
	<div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet2.gif" alt="" title=""></span>New books</div>
	<div class="clear"></div>
	<?php 	echo $xhtmlNewBook; ?>