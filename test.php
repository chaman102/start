<?php
include("includes/initialize.php");
use Carbon\Carbon;


echo '<pre>';

echo $date1 = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'));
echo "<br>";
echo $date2 = Carbon::createFromFormat('Y-m-d H:i', '2021-06-22 10:50');
echo "<br>";
$result= $date1->eq($date2);
if($result)
{
	echo "working";
}else
{
		echo "not working";
		}
		echo "<br>";
	$dts='2021-06-21 12:00';	
echo $cu=date('Y-m-d H:i');
echo "<br>";
echo $check=date('Y-m-d H:i', strtotime($dts ));
echo "<br>";
$diff = abs(strtotime($cu) - strtotime($check));
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
echo $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
//$menu=Menu::where('group_id',1)->where('status','Active')->where('parent_id',0)->get();
echo '<pre>';
//print_r($menu);
//$ras=Register::count(26435);
//$ras=Courses_pur::where("cu_id",290)->whereRaw('`payment`=(SELECT `price` FROM `courses` WHERE `id`=".$database->escape_value(290)."')->where('date(`paydate`)','=','curdate()')->where('cid','!=',0)->get();
//$ph='7766939004';
//$x=Register::where('phone',$ph)->count();
//print_r($x);
//$users = User::get();

//foreach ($menu as $key => $user) {
 //   echo $user->title;
//}

?>