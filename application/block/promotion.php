<?php 
//link tạm thời
 $imageURL = $this->_dirImg; 

$cateID = isset($this->arrParam['category_id']) ? $this->arrParam['category_id'] : '' ;
$model = new Model();
$query    = "SELECT `id`, `name`, `picture` FROM ".TBL_BOOK." WHERE `status` = 1 AND `sale_off` > 0 ORDER BY `ordering`  ASC LIMIT 0,2";
$listBooks     = $model->fetchAll($query); 
$xhtml = '';
foreach ($listBooks  as $key => $value) {
    $name = substr($value['name'],0,29);
    $link = URL::createLink('default','book','detail',array('book_id'=>$value['id']));
    $picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];
    if (file_exists($picturePath)) {
        $picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-'.$value['picture'].'"/>';
    }else{
        $picture     = '<img width = "60px" height ="90px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
    }   
    $xhtml .= '
     <div class="new_prod_box">
        <a href="'.$link.'">'. $name.'</a>
        <div class="new_prod_bg">
            <span class="new_icon"><img src="'.$imageURL.'/promo_icon.gif" alt="" title="" /></span>
            <a href="'.$link.'">'. $picture.'</a>
        </div>           
    </div>'; 
}
?>
<div class="right_box">
<div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet4.gif" alt="" title=""></span>Promotions</div>
<?php echo $xhtml; ?>
</div>