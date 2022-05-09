<?php
$action=$_GET['action'];
$pname=$_GET['pname'];
$pname_title=str_replace("_"," ",$_GET['pname']);
$saction=str_replace("_"," ",$_GET['action']);
if(strtolower($_GET['pname'])!='menus')
{

	if($_GET['action']=='show')
	{
	$maction="add";
 $url='<a href="'.TP_BACK_SIDE.$_GET['pname'].'/'.$maction.'">';
	}elseif(strtolower($_GET['pname'])=='template')
	{
		$pname_title='';
		}else
	{
			$maction="show";
 $url='<a href="'.TP_BACK_SIDE.$_GET['pname'].'/'.$maction.'">';
		}
}else
{
	$maction="show";
  $url='<a href="'.TP_BACK.'admin/menu.php?act=menu">';
}
?>
<script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   document.location = delUrl;
  }
}
</script>
<script>
function confirmStatus(staUrl,action) {
  if (confirm("Are you sure you want to " + action + " ?")) {
   document.location = staUrl;
  }
}
</script>

<div id="basic" class="col-lg-12 layout-spacing">
  <div class="statbox widget box box-shadow">
    <div class="widget-header">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
          <h4>          
            <?=cleanurl(ucfirst($action))?>
            <?=ucfirst($pname_title)?>
          </h4>
        </div>
      </div>
    </div>
    <div class="widget-content widget-content-area">
      <div class="row">
        <div class="col-lg-12 col-12 mx-auto">
          <?php
		
		if($action=='add' || $action=='edit')
		  {
			 if($pname=="menus")
		  {
		   Menus::form_data();
		  }else{
			$pname::form_data();  
		  }
  		  }else
		  {
			  if(method_exists($pname,$action)) 
			  {
		  $pname::$action($pname,$action);
			  }else
			  {
				 // echo "Function Not Found";				  
				   redirect_to(TP_BACK_AD);
				  }
			  }
		?>
        </div>
      </div>
    </div>
  </div>
</div>
