<?php
	require_once(LIB_PATH.DS.'database.php');
	
	class users_mo extends users
	{
		public function savedata($response){
		    $pp=0;
if($response['payments'][0]['status']=='Credit')
{
$data=new book_pur();
$data->bid=1;
$data->st_id=$_SESSION['user_id'];
$data->amount=$response['payments'][0]['amount'];
$data->paydate=date('Y-m-d');
$data->payby="Online";
$data->txnid=$response['payments'][0]['payment_id'];
$data->created=date('Y-m-d H:i:s');
$data->status=$response['payments'][0]['status'];
$pp=$data->create();
}
return $pp;
		}
	}