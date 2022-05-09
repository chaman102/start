<?php
require_once ("../../includes/initialize.php");
use Illuminate\Hashing\BcryptHasher;
$Template = Template::findOrFail(1);
if ($session->is_logged_in())
{
    redirect_to(TP_BACK . "admin");
}
echo '<title>Forget Password</title>';
include_layout_template('admin_header.php');
if (isset($_POST['submit']))
{
    $email = $_POST['email_id'];
    $cos = User::count_by_x("email", $email);
    $data = new User;
    if ($cos == 1)
    {
        $cos = User::find_by_field_value("email", $email);
        $temp = Template::findOrFail(1);
        $user = User::find_by_id(1);
        $xp = new BcryptHasher();
        $password = random();
        $npassword = $xp->make($password, ['rounds' => 4]);
        $data->update_password($npassword, $email);
        $msg_body = "Your New Password:" . $password;
        // Form has been submitted.
        $msg = Mail_info::mail_body_template($msg_body, "Message From " . $temp->sitename);
        Mail_info::mail_msg($temp->email, "noreply@site.com", "Message From " . $temp->sitename, $msg);
    }
    else
    {
        $type = 'danger';
        $message = 'Error ! </h4> Email address not found';
        redirect_by_js(TP_BACK . "admin/forget_password", 1000, $type, $message);
    }
}
?>

<div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1>Password <a href="javascript:void(0);"><span class="brand-name">Recovery</span></a></h1>
                        <p class="signup-link text-center">Enter your email and instructions will sent to you!</p>
                         <?php if ($message != '')
{
    echo '<div class="alert alert-' . $type . '">
                ' . $message . '</div><br><center><div class="loader multi-loader mx-auto"></div></center>';
} ?>
                        <form class="text-left" method="post">
						<div class="form">

<div id="email-field" class="field-wrapper input">
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
	<input id="email" name="email_id" type="text" value="" placeholder="Email">
</div>
<div class="d-sm-flex justify-content-between">
	<div class="field-wrapper">
		<button type="submit" name="submit"  class="btn btn-primary" value="">Submit</button>
	</div>                                    
</div>
<div class="field-wrapper">
                                    <a href="<?=TP_BACK_AD?>login" class="forgot-pass-link">Login Again?</a>
                                </div>
</div>
                        </form>
                        <?php $temp = Template::findOrFail(1); ?>	                        
                        <p class="terms-conditions text-center">© <?=date('Y') ?> <span ><?=$temp->sitename ?></span> All Rights Reserved. </p>

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    
	<?php include_layout_template('admin_footer.php'); ?>
