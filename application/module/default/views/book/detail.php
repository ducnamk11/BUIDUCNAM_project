<?php 

$imageURL = $this->_dirImg;

$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$this->bookInfo['picture'];
$pictureFull = '';
if (file_exists($picturePath)) {
	$picture     = '<img width = "98px" height ="150px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.$this->bookInfo['picture'].'"/>';
	$pictureFull = UPLOAD_URL.'book'.DS.$this->bookInfo['picture'];
}else{
	$picture     = '<img width = "98px" height ="150px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
}	
$description =  substr($this->bookInfo['description'],0,400);

if ($this->bookInfo['sale_off']>0)  {
	$saleoff = ((100-$this->bookInfo['sale_off'])*$this->bookInfo['price']/100);
	$price = '<span class="red">'.number_format($saleoff).'$ </span>';
	$price .= '<span class="red-through">' .number_format($this->bookInfo['price']).'$ </span>';
	$linkOrder = URL::createLink('default','user','order',array('book_id'=>$this->bookInfo['id'], 'price'=>$this->bookInfo['price']));
}else{
	$price = '<span class="red">'.number_format($this->bookInfo['price']).'$ </span>';
	$linkOrder = URL::createLink('default','user','order',array('book_id'=>$this->bookInfo['id'], 'price'=>$this->bookInfo['price']));

}

?>

<!-- TITLE -->
<div class="title">
	<span class="title_icon">
		<img src="<?php echo $imageURL;?>/bullet1.gif"  />
	</span>
	<?php 	echo  $this->bookInfo['name'];  ?>
</div>
<div class="feat_prod_box_details">

	<div class="prod_img"><a id="single_image" href="<?php echo $pictureFull; ?>" rel="lightbox"><?php echo $picture; ?></a>
		<br><br>
		<a id="single_image" href="<?php echo $pictureFull; ?>" rel="lightbox"><img src="<?php echo $imageURL;?>/zoom.gif" ></a>
	</div>

	<div class="prod_det_box">
		<div class="box_top"></div>
		<div class="box_center">
			<div class="prod_title">Details</div>
			<p class="details"><?php echo $description; ?></p>
			<div class="price"><strong>PRICE:</strong> <?php echo $price; ?></div>

			<a href=" <?php echo $linkOrder ?>" class="more"><img src="<?php echo $imageURL;?>/order_now.gif" ></a>
			<div class="clear"></div>
		</div>

		<div class="box_bottom"></div>
	</div>    
	<div class="clear"></div>
</div>


<!-- relate book  -->
<?php 
$xhtmlRelateBook = '';
if (!empty($this->bookRelate)) {
	foreach ($this->bookRelate as  $value) {
		$link = URL::createLink('default','book','detail',array('book_id'=>$value['id']));
		$name = substr($value['name'],0,20) ;
		$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];
		if (file_exists($picturePath)) {
			$picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-'.$value['picture'].'"/>';
		}else{
			$picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
		}	
		$xhtmlRelateBook .= '
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

<div id="demo" class="demolayout">

	<ul id="demo-nav" class="demolayout">
		<li><a class="tab1 active" href="#">More details</a></li>
		<li><a class="tab2 " href="#">Related books</a></li>
	</ul>

	<div class="tabs-container">
		<div style="display: block;" class="tab" id="tab1">
			<p class="more_details"> <?php echo $this->bookInfo['description'];?>
		</p>                           
	</div>	
	<div style="display: none;" class="tab" id="tab2">
		<?php echo $xhtmlRelateBook; ?>              
		<div class="clear"></div>
	</div>	

</div>


</div>