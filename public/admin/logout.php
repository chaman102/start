<?php require_once("../../includes/initialize.php"); ?>
<?php	
//setcookie('username', '', time() - 3600);
//setcookie('password', '', time() - 3600);
//setcookie('user', '', time() - 3600);
//setcookie('admin', '', time() - 3600);
    $session->logout();
    redirect_to("login");
?>
