    <?php 
   
    $dataUsername = isset($this->arrParam['form']['username']) ? $this->arrParam['form']['username'] : '' ;
    $dataFullname = isset($this->arrParam['form']['fullname']) ? $this->arrParam['form']['fullname'] : '' ;
    $dataEmail    = isset($this->arrParam['form']['email']) ? $this->arrParam['form']['email'] : '' ;
    $dataPassword = isset($this->arrParam['form']['password']) ? $this->arrParam['form']['password'] : '' ;
    //  create username input
    $inputUserName  = Helper::cmsInput('text','form[username]','username',$dataUsername,'contact_input');
    $rowUsername= Helper::cmsRow('Username',$inputUserName);
    //  create fname input
    $inputFullName  = Helper::cmsInput('text','form[fullname]','fullname', $dataFullname,'contact_input');
    $rowFullName= Helper::cmsRow('FullName',$inputFullName);
//  create inputEmail
    $inputEmail  = Helper::cmsInput('text','form[email]','email', $dataEmail,'contact_input');
    $rowEmail= Helper::cmsRow('Email',$inputEmail);
//  create inputPassword
    $inputPassword  = Helper::cmsInput('text','form[password]','password',$dataPassword,'contact_input');
    $rowPassword= Helper::cmsRow('Password',$inputPassword);
//  create inputSubmit
    $inputSubmit  = Helper::cmsInput('submit','form[submit]','submit','register','register');
    $inputToken  = Helper::cmsInput('hidden','form[token]','token',time());
    $rowSubmit= Helper::cmsRow('Submit',$inputSubmit.$inputToken,true);

    $linkAction =URL::createLink('default','index','register');
    $errors= (isset($this->errors)) ? $this->errors : '';
    ?>

    <div class="title"><span class="title_icon"><img src="<?php echo $imageURL;?>/bullet1.gif" alt="" title="" /></span>Register</div>

    <div class="feat_prod_box_details">
    	<div class="contact_form">
    		<div class="form_subtitle">create new account</div>
            <?php echo $errors ?>
            <form name="adminForm" method="POST" action="<?php echo $linkAction;?>">          
               <?php echo $rowUsername.$rowFullName.$rowEmail.$rowPassword.$rowSubmit; ?>
           </form>     
       </div>  
   </div>  
   <div class="clear"></div>
