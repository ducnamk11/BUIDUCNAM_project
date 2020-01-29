<?php
// test IMGLINK
$imageURL = $this->_dirImg;
if (!empty($this->Items)) {
	$xhtml = '';
	foreach ($this->Items as  $value) {
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
}else{
	$xhtml = '
		<div class="feat_prod_box"> NỘI DUNG ĐANG CẬP NHẬT !</div>';
}
?>
<!-- TITLE -->
<div class="title">
	<span class="title_icon">
		<img src="<?php echo $imageURL;?>/bullet1.gif"  />
	</span>
	<?php  ;
	echo  $this->categoryName['name'];  ?>
</div>

<!-- LIST CATEGORY -->
<div class="feat_prod_box">

	<?php echo $xhtml; ?>
 </div>
