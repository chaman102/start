<?php
 header("Access-Control-Allow-Origin: *");
require_once('../../includes/initialize.php');

if($_POST['id'])
{
 $id=$_POST['id'];

$cor=Course_mo::where("cor_id",$id)->get();

echo '<option selected="selected">---Select Courses---</option>';
foreach($cor as $cors)
{
	$to=0;
	$counts=Video::where("mo_id",$cors->id)->count();
	if($counts==1)
	{
    $data=Video::where("mo_id",$cors->id)->first();
	$xvideo=explode(",",$data->icode);	
	$to=sizeof($xvideo);
	}
echo '<option value="'.$cors->id.'">'.$cors->id.'. '.ucfirst($cors->name).'-(V:'.$to.')</option>';
}
}

?>