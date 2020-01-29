<?php 
$linkCategory = URL::createLink('default','category','index');
if (!empty($this->Items)) {
	$xhtml='';
	$totalPrice=0;
	$linkSubmitForm = URL::createLink('default','user','buy');
	foreach ($this->Items as $key => $value) {
		$picturePath = UPLOAD_PATH.'book'.DS.'98x150-'.$value['picture'];
		if (file_exists($picturePath)) {
			$picture     = '<img width = "23px" height ="35px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.$value['picture'].'"/>';
		}else{
			$picture     = '<img width = "23px" height ="35px" class ="thumb" src="'.UPLOAD_URL.'book'.DS.'98x150-default.jpg'.'"/>';
		}
		$inputBookId = Helper::cmsInput('hidden','form[bookid][]','input_book'.$value['id'],$value['id']);	
		$inputQuantity = Helper::cmsInput('hidden','form[quantity][]','input_quantity'.$value['quantity'],$value['quantity']);	
		$inputPrice = Helper::cmsInput('hidden','form[price][]','input_price'.$value['price'],$value['price']);	
		$inputName = Helper::cmsInput('hidden','form[name][]','input_name'.$value['name'],$value['name']);	
		$inputPicture = Helper::cmsInput('hidden','form[picture][]','input_picture'.$value['picture'],$value['picture']);	
		$link = URL::createLink('default','book','detail',array('book_id'=>$value['id']));
		$totalPrice += $value['totalprice'];
		$xhtml .='
		<tr>
		<td><a href="'.$link.'">'.$picture.'</a></td>
		<td>'.$value['name'].'</td>
		<td>'.$value['price'].'$</td>
		<td>'.$value['quantity'].'</td>
		<td>'.$value['totalprice'].'$</td>               
		</tr>';
		$xhtml .=$inputBookId.$inputQuantity.$inputName.$inputPrice.$inputPicture  ; 
	} 	?>
	<div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title=""></span>My cart</div>
	<div class="feat_prod_box_details">
		<form id="adminForm" method="POST" action="<?php echo $linkSubmitForm; ?>" name="adminForm">
			<table class="cart_table">
				<tbody>
					<tr class="cart_title">
						<td>Item pic</td>
						<td>Book name</td>
						<td>Unit price</td>
						<td>Qty</td>
						<td>Total</td>               
					</tr> <?php echo $xhtml; ?> <tr>
						<td colspan="4" class="cart_total"><span class="red">TOTAL:</span></td>
						<td style="font-weight: bold" > <?php echo $totalPrice; ?>$</td>                
					</tr>                  
				</tbody>
			</table>

			<a href="<?php echo $linkCategory; ?>" class="continue">&lt; continue</a>
			<a href="#" onclick="javascript:submitForm('<?php echo $linkSubmitForm; ?>')" class="checkout">checkout &gt;</a>
		</form>
		'<?php 

	}else{
		?>
		<div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet1.gif" alt="" title=""></span>My cart</div>
		<div class="feat_prod_box_details">
			<h2>Your cart is empty</h2> 
		</div>
		<h3> click <a href="<?php echo $linkCategory; ?>">HERE</a>  to bach to category !!</h3>

		<?php 

		
	}

	?>



</div>	






<!-- <div class="clear"></div> -->
