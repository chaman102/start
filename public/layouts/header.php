<?php $Template = Template::findOrFail(1);?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<title>Admin Panel</title>
<link rel="icon" type="image/x-icon" href="<?=TP_BACK?>assets/img/favicon.ico"/>
<link href="<?=TP_BACK?>assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="<?=TP_BACK?>assets/js/loader.js"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="<?=TP_BACK?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=TP_BACK?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="<?=TP_BACK?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="<?=TP_BACK?>assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<link href="<?=TP_BACK?>assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
<link href="<?=TP_BACK?>assets/css/elements/tooltip.css" rel="stylesheet" type="text/css" />
<?php 
		 Global $debugbarRenderer;
	echo $debugbarRenderer->renderHead();
		
		  ?>

<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<?php 
	
	
       if(isset($_GET['pname'],$_GET['action']))  {
		 // echo $_GET['pname'];
		  if($_GET['pname']=="menus" || $_GET['pname']=="logfile" )
		  {
			 Menus::hd_css();
		  }else
		  {
			  if (class_exists($_GET['pname'])) {
			$s= $_GET['pname']::hd_css();
			  }else
			  {
				redirect_to(BASE_PATH."public".DS."admin");  
			  }				  
		 }
		}
		else		
		{
		Template::hd_css();
			}
			
			
	?>
<script src="<?=TP_BACK?>editor/ckeditor.js"></script>
</head>
<body>
<!-- BEGIN LOADER -->
<div id="load_screen">
  <div class="loader">
    <div class="loader-content">
      <div class="spinner-grow align-self-center"></div>
    </div>
  </div>
</div>
<!--  END LOADER --> 

<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top">
  <header class="header navbar navbar-expand-sm">
    <ul class="navbar-item theme-brand flex-row  text-center">
      <li class="nav-item theme-logo"> <a href="<?=TP_BACK?>admin/"> <img src="<?=TP_BACK?>assets/img/logo.svg" class="navbar-logo" alt="logo"> </a> </li>
      <li class="nav-item theme-text"> <a href="<?=TP_BACK?>admin/" class="nav-link"> Admin Panel </a> </li>
    </ul>
    <ul class="navbar-item flex-row ml-md-auto">
      <li class="nav-item dropdown message-dropdown"> <a href="<?=BASE_PATH?>" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg> </a> </li>
      <?php  $user=User::findOrFail($_SESSION['user_id']);
	 
	  if(file_exists($_SERVER['DOCUMENT_ROOT']."/".MYF.$user->image_path()))
							{
								$img=BASE_PATH.$user->image_path();
							}else
							{
								$img=BASE_PATH."public/assets/img/profile.jpg";
							}
	 ?>
      <li class="nav-item dropdown user-profile-dropdown"> <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <img src="<?=$img?>" alt="<?=$user->full_name;?>"> </a>
        <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
          <div class="">
            <div class="dropdown-item"> <a class="" href="<?=TP_BACK_SIDE?>user/edit/<?=$_SESSION['user_id']?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
              </svg> My Profile</a> </div>
            <div class="dropdown-item"> <a class="" href="<?=TP_BACK?>admin/dashboard/settings"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg> Site Settings</a> </div>
            <div class="dropdown-item"> <a class="" href="<?=TP_BACK?>admin/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
              </svg> Sign Out</a> </div>
          </div>
        </div>
      </li>
    </ul>
  </header>
</div>
<!--  END NAVBAR  --> 

<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
  <header class="header navbar navbar-expand-sm"> <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
    <line x1="3" y1="12" x2="21" y2="12"></line>
    <line x1="3" y1="6" x2="21" y2="6"></line>
    <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg></a>
    <ul class="navbar-nav flex-row">
      <li>
        <div class="page-header">
          <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?=TP_BACK?>admin/">Dashboard</a></li>
              <?php
								
								if(!isset($_GET['other']) && !isset($_GET['pname']))  {
                                   
									echo '<li class="breadcrumb-item active" aria-current="page"><span>Welcome</span></li>';
								}elseif(isset($_GET['pname']) && !isset($_GET['action']))
								{
                                   
									echo '<li class="breadcrumb-item active" aria-current="page"><span>'.cleanurl(ucfirst($_GET['pname'])).'</span></li>';
								}elseif(isset($_GET['other']))
								{
								
									echo '<li class="breadcrumb-item active" aria-current="page"><span>'.cleanurl(ucfirst($_GET['other'])).'</span></li>';
								}
								
								else
								{
								
									echo '<li class="breadcrumb-item" aria-current="page"><span>'.cleanurl(ucfirst($_GET['pname'])).'</span></li>';
								echo '<li class="breadcrumb-item active" aria-current="page"><span>'.cleanurl(ucfirst($_GET['action'])).'</span></li>';
								
								}
								?>
            </ol>
          </nav>
        </div>
      </li>
    </ul>
    <?php
$maction='';
$url='';
$pname_title='';

if(isset($_GET['action']))
{
$action=$_GET['action'];
$pname=$_GET['pname'];

$pname_title=str_replace("_"," ",$_GET['pname']);
$saction=str_replace("_"," ",$_GET['action']);
if(strtolower($_GET['pname'])!='menus')
{
	if($_GET['action']=='show')
	{
	$maction="add";
 $url='<a href="'.TP_BACK_SIDE.$_GET['pname'].'/'.$maction.'" class="btn btn-outline-primary">';
	}elseif($_GET['pname']!='template')
	{
			$maction="show";

 $url='<a href="'.TP_BACK_SIDE.$_GET['pname'].'/'.$maction.'" class="btn btn-outline-info">';
		}else
	{
		$maction='';
		$url='';	
		$pname_title='';
		}
}else
{
	
	$maction="show";
  $url='<a href="'.TP_BACK.'admin/menu.php?act=menu" class="btn btn-outline-primary">';
}
}
if(isset($_GET['action'],$_GET['pname']))
{
	
if($_GET['action']=='add' && $_GET['pname']=='user_data')
{
}else
{	
?>
    <ul class="navbar-nav flex-row ml-auto mr-4">
      <li class="breadcrumb-item">
        <?=$url?>
        <?=ucfirst($maction)?>
        <?=ucfirst($pname_title)?>
        </a></li>
    </ul>
    <?php
}
}
			?>
    <?php  include_layout_template('top.php'); ?>
  </header>
</div>
<!--  END NAVBAR  -->
<div class="main-container" id="container">
<div class="overlay"></div>
<div class="search-overlay"></div>
<?=include_layout_template('side.php');?>
