<?php 
$model = new Model();
if (isset($this->arrParam['book_id'])) {
	$bookID     =  $this->arrParam['book_id'];
	$queryCate  = "SELECT category_id FROM ".TBL_BOOK." WHERE id ='$bookID' ";
	$resultCate = $model->fetchRow($queryCate);
	$cateID = $resultCate['category_id']; 
}else{
	$cateID = isset($this->arrParam['category_id']) ? $this->arrParam['category_id'] : '' ;
}
$query    = "SELECT `id`, `name` FROM ".TBL_CATEGORY." WHERE `status` = 1 ORDER BY `ordering`  ASC";
$listCats     = $model->fetchAll($query); 
$xhtml = '';
foreach ($listCats  as $key => $value) {
	$name = substr($value['name'],0,29);
	$link = URL::createLink('default','book','list',array('category_id'=>$value['id']));
	if ($cateID == $value['id'] ) {
		$xhtml .=  ' <li><a class="active" href="'.$link.'">'.$name.'</a></li>' ;
	}else{
		$xhtml .=  ' <li><a href="'.$link.'">'.$name.'</a></li>' ;
	}
}
?>
<div class="right_box">
	<div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet5.gif" alt="" title="" /></span>Categories</div> 
	<ul class="list">
		<?php echo $xhtml; ?>
	</ul>
</div>         