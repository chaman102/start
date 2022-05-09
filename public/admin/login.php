<?php
require_once("../../includes/initialize.php");
$Template = Template::find(1);

if($session->is_logged_in()) {
  redirect_to(TP_BACK."admin");
}
include_layout_template('admin_header.php');
// Remember to give your form's submit tag a name="submit" attribute!
$type='';
if(isset($_COOKIE['username']) AND  isset($_COOKIE['password']))
   {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $found_user = User::authenticate($username, $password);
   
    if (is_object($found_user)) {
        $session->login($found_user);
        //log_action('Login', "{$found_user->username} logged in.");
        //$type='success';
        //$message = 'Success ! </h4> Login Successfull';                
        //redirect_by_js(TP_BACK."admin",1000,$type,$message);    
      }
}
if (isset($_POST['submit'])) { // Form has been submitted.

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
   
   
 //exit();
//$password =md5($password);
    
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username, $password);

  if (is_object($found_user)) {
    if(isset($_POST['rember']))
    {
    $session->setcokkie($found_user->username,$found_user->password);
    }
    $session->login($found_user);
	log_action('Login', "{$found_user->username} logged in.");
	$type='success';
	$message = 'Success ! </h4> Login Successfull';
			
	redirect_by_js(TP_BACK."admin",1000,$type,$message);
	?>
	
<?php	
 
  } else {
    // username/password combo was not found in the database
    $type='danger';
	$message = $found_user;
	redirect_by_js("login",1000,$type,$message);
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
}

?>


    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1>Admin Login  <a href="javascript:void(0);"><span class="brand-name">Panel</span></a></h1>
                        <p class="signup-link text-center">Welcome Back </p>
                         <?php if($message!='')
  {
	  echo'<div class="alert alert-'.$type.'">
                '.$message.'</div><br><center><div class="loader multi-loader mx-auto"></div></center>';
	  } ?>
                        <form class="text-left" method="post">
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="<?=htmlentities($username); ?>">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="<?=htmlentities($password); ?>">
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    
                                    <div class="field-wrapper">
                                        <button type="submit" name="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                    
                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" name="rember" value="1" class="new-control-input">
                                          <span class="new-control-indicator"></span>Keep me logged in
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    <a href="<?=TP_BACK_AD?>forget_password" class="forgot-pass-link">Forgot Password?</a>
                                </div>

                            </div>
                        </form>
                        <?php $temp=Template::find(1); ?>	                        
                        <p class="terms-conditions text-center">© <?=date('Y')?> <span ><?=$temp->sitename?></span> All Rights Reserved. </p>

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    

  <?php  include_layout_template('admin_footer.php'); ?>  
   