<?php
 header("Access-Control-Allow-Origin: *");
require_once('../../includes/initialize.php');

if($_POST['id'])
{
$id=$_POST['id'];
$table=$_POST['table'];
	extract($_POST);

		$x=$table::where("id",$id)->first();
  
		if($x!='')
		{
			
	$pp=$x->delete();
	if($pp)
	{
		$xs=[
			'error'=>0,
			'msg'=>'Data deleted Successfully'
			];
		return $x;
		}else
	{
		$xs=[
			'error'=>1,
			'msg'=>'Data not deleted'
			];
		return $x;
		}
		}
			
}

?>