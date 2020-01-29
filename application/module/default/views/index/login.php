    <?php 
 
//  create inputEmail
    $inputEmail  = Helper::cmsInput('text','form[email]','email', null,'contact_input');
    $rowEmail= Helper::cmsRow('Email',$inputEmail);
//  create inputPassword
    $inputPassword  = Helper::cmsInput('text','form[password]','password',null,'contact_input');
    $rowPassword= Helper::cmsRow('Password',$inputPassword);
//  create inputSubmit
    $inputSubmit  = Helper::cmsInput('submit','form[submit]','submit','login','register');
    $inputToken  = Helper::cmsInput('hidden','form[token]','token',time());
    $rowSubmit= Helper::cmsRow('Submit',$inputSubmit.$inputToken,true);

    $linkAction =URL::createLink('default','index','login');
    $errors= (isset($this->errors)) ? $this->errors : '';
    ?>

    <div class="title"><span class="title_icon"><img src="<?php echo $imageURL;?>/bullet1.gif" alt="" title="" /></span>Login</div>

    <div class="feat_prod_box_details">
    	<div class="contact_form">
    		<div class="form_subtitle">Log in</div>
            <?php echo $errors ?>
            <form name="adminForm" method="POST" action="<?php echo $linkAction;?>">          
               <?php echo $rowEmail.$rowPassword.$rowSubmit; ?>
           </form>     
       </div>  
   </div>  
   <div class="clear"></div>
