<?php 

$message = '';
switch ($this->arrParam['type']) {
	case 'register-success':
	$message = 'Your account was created successfully, please wait for administrator of approval! ';
	break;
	case 'not-permission':
	$message = ' You are not authorized to access ! ';
	break;
	case 'not-url':
	$message = ' The path is not valid ! ';
	break;
}
?>
<div class="notice"> <?php echo $message; ?></div>