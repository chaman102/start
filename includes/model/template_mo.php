<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
use Coderatio\SimpleBackup\SimpleBackup;
use Razorpay\Api\Api;
class Template_mo extends Template {
	
	public static function backnow() {
	  $time=date('d-m-Y(h.i.s A)');
	
	$simpleBackup = SimpleBackup::setDatabase([DB_NAME,DB_USER,DB_PASS,DB_SERVER])
  ->storeAfterExportTo(SITE_ROOT.DS."includes".DS.'backup', 'mybackup_'.$time);
  return $simpleBackup->getExportedName();
	 }
	 public static function backnow_table_in($arr) {
	SimpleBackup::start()
    ->setDbName(DB_NAME)
    ->setDbUser(DB_USER)
    ->setDbPassword(DB_PASS)
    ->includeOnly($arr)
    ->then()->storeAfterExportTo('backups')
    ->then()->getResponse();
	 }
	public static function backnow_table_out($arr) {
	SimpleBackup::start()
    ->setDbName(DB_NAME)
    ->setDbUser(DB_USER)
    ->setDbPassword(DB_PASS)
    ->excludeOnly($arr)
    ->then()->storeAfterExportTo('backups')
    ->then()->getResponse();
	 }
	 public static function backup_history_clears()	 
	 {
	  $logfile = SITE_ROOT.DS.'logs'.DS.'backup.txt';
	 
	  delete_files(SITE_ROOT.DS.'includes'.DS.'backup');
  
	  file_put_contents($logfile, '');
	  // Add the first log entry
	  log_action('Logs Cleared', "by User ID : {$_SESSION['user_id']}");
    // redirect to this same page so that the URL won't 
    // have "clear=true" anymore
	$message='<div align="center"><h4 class="alert alert-success">Success! Clear the history</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
echo output_message($message);
redirect_by_js("backnow_history",1000);

   
 }
  public static function script_register() {		
		 ?>
	 <script>
      $().ready(function() {
      $("#register-form").validate({
			rules: {					
			name: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength:5,
				maxlength:12
			},			
			password_confirm: {
            required: true,
            minlength: 5,
            equalTo: "#password"
        	},				
			},
		errorPlacement: function(){
            return false;  // suppresses error message text
        }
		});
      });</script>
      <?php 
	  }
	 public static function script_contact() {		
		 ?>
	 <script>
      $().ready(function() {
      $("#contact-form").validate({
			rules: {					
			cname: {
				required: true
			},
			subject: {
				required: true				
			},
			phone: {
				required: true				
			},			
			email: {
				required: true,
				email: true
			},
			msg: {
				required: true				
			},					
			},
		errorPlacement: function(){
            return false;  // suppresses error message text
        }
		});
      });</script>
      <?php 
	  }
	   public static function script_login() {		
		 ?>
	 <script>
      $().ready(function() {
      $("#login-form").validate({
			rules: {				
						
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength:5,
				maxlength:12
			},					
			},
		errorPlacement: function(){
            return false;  // suppresses error message text
        }
		});
      });</script>
      <?php 
	  }
	public static function backnow_his() {
	  $dps='';
	  $link='';
	  $maction='clear';	  
	  $logfile = SITE_ROOT.DS.'logs'.DS.'backup.txt';
 
  ?>

<!-- /.col-xl-6 col-12 -->

<div class="card-content">
  <ul class="list-inline text-right">
    <li class="margin-bottom-10 "><a href="<?=TP_BACK_SIDE?>template/backup_history_clear" class="btn btn-primary btn-rounded waves-effect waves-light">Clear All Backup History</a></li>
    <li class="margin-bottom-10 "><a href="<?=TP_BACK_SIDE?>template/backupsql" class="btn btn-success btn-rounded waves-effect waves-light">Create Backup</a></li>
  </ul>
  <div class="col-md-12">
    <div class="list-group">
      <?php

  if( file_exists($logfile) && is_readable($logfile) && 
			$handle = fopen($logfile, 'r')) {  // read
    echo "<ul class=\"log-entries\">";
		while(!feof($handle)) {
			$entry = fgets($handle);
			if(trim($entry) != "") {
			echo'<a href="#" class="list-group-item">									
			<p class="list-group-item-text">'.$entry.'</p>
			</a>';			
			}
		}
		echo "</ul>";
    fclose($handle);
  } else {
    echo "Could not read from {$logfile}.";
  }

?>
    </div>
  </div>
</div>
<?php
		 }
		 public static function yougen() 
		 {
			 if(!isset($_REQUEST['submit']))
{
			 echo $fo=Forms::form_start();
			 echo $fo=Forms::input("Playlist ID","playlist",'',1,0);
			 echo $fo=Forms::input("Play No of Videos","nos",50,1,0);		
			 echo $fo=Forms::submit();
			 echo $fo=Forms::form_end(); 
}else
{
	$playid=$_POST['playlist'];
//'PLBvRzmJWdUQ3nJaGdhQbC1R3tUhCDFHxG';
//$playid='PLBvRzmJWdUQ25miKm3FRLbxPaN7NrULR7';
$clientid='UCzKG3pj6DKOrGLEfLpNpt1Q';
$appkey='AIzaSyCFqB50fsO8uGJfwbOw32zyypRd5r9DfPM';
$client = new Google\Client();
$client->setApplicationName($clientid);
$client->setDeveloperKey($appkey);

$youtube = new Google_Service_YouTube($client);
$nextPageToken = '';
$htmlBody = '';
$htmlname='';
$xdata='';
$co=0;


do {
    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
    'playlistId' => $playid,
    'maxResults' => $_POST['nos'],
    'pageToken' => $nextPageToken));

    foreach ($playlistItemsResponse['items'] as $playlistItem) {
        //$htmlBody .= sprintf('<li>%s %s (%s)</li>', $i++,$playlistItem['snippet']['title'], $playlistItem['snippet']['resourceId']['videoId']);
    $htmlBody .= 'https://www.youtube.com/embed/'.$playlistItem['snippet']['resourceId']['videoId'].",";
	
	$xdata=str_replace(","," ",$playlistItem['snippet']['title']);
	$string=preg_replace('/[^A-Za-z0-9\-]/', ' ', $xdata);
	 $htmlname .= $string.",";
	$co++;
	
	}

    $nextPageToken = $playlistItemsResponse['nextPageToken'];
} while ($nextPageToken <> '');

	?>
    <a class="btn btn-info" href="<?=TP_BACK_SIDE?>yougen">Retry</a>        
  <h2 class="text-center">Total Videos:<?=$co?></h2>
   <hr>
   <div class="form-group">
    <label for="pwd">Videos Names:</label>
   
	<textarea name="text" rows="6" cols="50" class="form-control" ><?=$htmlname?></textarea>
 </div>
	 <div class="form-group">
    <label for="pwd">Iframe Links:</label>
   
	<textarea name="text" rows="10" cols="50" class="form-control" ><?=$htmlBody?></textarea>
  </div>
			<?php 
	}
		 }
	 public static function orders() 
		 {
			 date_default_timezone_set('Asia/Kolkata');

$api = new Api(KEYID, KEYSECRET);
$options=['count'=>100];
$payment= $api->order->all($options);
//$payment=  $api->order->fetch($orderId);
//date("d/m/Y h:i:s A",$payment['items'][0]['created_at'])
//echo date("d/m/Y h:i:s A",$payment->created_at);
echo "<pre>";
//print_r($payment);
echo "</pre>";
echo '  <table id="zero-config" class="table table-bordered " >
  <thead>
    <tr>
      <td>ID</td>
      <td>Order Id</td>
      <td>Payment</td>
      <td>Recipt</td>
      <td>Status</td>
      <td>Created AT</td>
    </tr></thead>';
	echo '</tbody>';
$co=1;
$i=0;
$am=0;
$re='';
$cname='';
$stname='';
$phone='';
while($i!=$payment['count'])
{
	if($payment['items'][$i]['receipt']!='')
	  {
		  
	$re=explode("-",$payment['items'][$i]['receipt']);
	
	$st=Register::findOrFail($re[4]);
	
	$sco=Register::where('id',$re[4])->count();
	
	if($sco!=0)
	{
		$stname=ucfirst($st->name);
		$phone=ucfirst($st->phone);
		}
	if($re[0]==1)
	{
	$cos=Courses::where("id",$re[0])->first();
	$cname=ucfirst($cos->name);
	}else
	{
		
			$cos=S_cor::where("id",$re[0])->first();
			//$cname=ucfirst($cos->name);
		}
	  }
		$am=($payment['items'][$i]['amount']/100)+$am;
		if($payment['items'][$i]['status']=='created')
	{
		$status='<a href="'.TP_BACK_AD.'viewfull/'.$re[4].'" target="_blank"><span class="badge badge-info">'.ucfirst($payment['items'][$i]['status']).'</span></a>';
		}elseif($payment['items'][$i]['status']=='paid')
	{
		$status='<a href="'.TP_BACK_AD.'viewfull/'.$re[4].'" target="_blank"><span class="badge badge-success">'.ucfirst($payment['items'][$i]['status']).'</span></a>';
		}elseif($payment['items'][$i]['status']=='attempted')
	{
		$status='<a href="'.TP_BACK_AD.'viewfull/'.$re[4].'" target="_blank"><span class="badge badge-primary">'.ucfirst($payment['items'][$i]['status']).'</span></a>';
		}
		echo ' <tr>
      <td>'.$co++.'</td>
      <td>'.$payment['items'][$i]['id'].'</td>
      <td>'.($payment['items'][$i]['amount']/100).'</td>';
	  if($payment['items'][$i]['receipt']!='')
	  {
      echo '<td>'.$payment['items'][$i]['receipt'].'-(<span style="color:blue;font-weight:bold">'.$cname.'</span>)-(<span style="color:red;font-weight:bold">'.$stname.'</span>)-(<span style="color:orange;font-weight:bold">'.$phone.'</span>)</td>';
      }
	  echo '<td>'.$status.'</td>
      <td>'.date("d/m/Y h:i:s A",$payment['items'][$i]['created_at']).'</td>
    </tr>';
	
	
$i++;
}
echo '</tbody>
</table>';
		 }
		  public static function payments() 
		 {
			 
			 date_default_timezone_set('Asia/Kolkata');

$api = new Api(KEYID, KEYSECRET);
$options=['count'=>100];
$payment= $api->payment->all($options);
$paych='';

echo ' <table id="zero-config" class="table table-bordered " >
  <thead>
    <tr>
      <td>ID</td>
      <td>Payment Id</td>
      <td>Payment</td>
      <td>Phone</td>
	  <td>Email</td>
      <td>Status</td>
      <td>Created AT</td>
    </tr>
	</thead>';
	echo '</tbody>';
$co=1;
$i=0;
$am=0;
$status='';
$rec='';
while($i!=$payment['count'])
{
	//$paych = $api->payment->fetch($payment['items'][$i]['id']);
	//$order  = $api->order->fetch($paych->order_id);
	//if($order->receipt!='')
//{
	//$rec=$order->receipt;
//}
	
	
	if($payment['items'][$i]['status']=='captured')
	{
		$status='<span class="badge badge-success">'.ucfirst($payment['items'][$i]['status']).'</span>';
		}elseif($payment['items'][$i]['status']=='failed')
	{
		$status='<span class="badge badge-danger">'.ucfirst($payment['items'][$i]['status']).'</span>';
		}
		$am=($payment['items'][$i]['amount']/100)+$am;
		echo ' <tr>
      <td>'.$co++.'</td>
      <td>'.$payment['items'][$i]['id'].'</td>
      <td>'.($payment['items'][$i]['amount']/100).'<hr>'.$rec.'</td>
	  <td>'.$payment['items'][$i]['email'].'</td>
      <td>'.$payment['items'][$i]['contact'].'</td>
      <td>'.$status.'</td>
      <td>'.date("d/m/Y h:i:s A",$payment['items'][$i]['created_at']).'</td>
    </tr>';
	
	
$i++;
}
echo '</tbody>
</table>';
		 }
		 public static function paycheck() 
		 { 
		  if(!isset($_REQUEST['submit']))
{
		     echo $fo=Forms::form_start();
			 echo $fo=Forms::input("Payment ID","pay_id",'',1,0);				
			 echo $fo=Forms::submit();
			 echo $fo=Forms::form_end();
}else
{
	
 //echo $_POST['pay_id'];
 $billId = $_POST['pay_id']; 
$len=strlen($_POST['pay_id']);
$api = new Api(KEYID, KEYSECRET);

$payment = $api->payment->fetch($billId);

// Get the created Order ID
if($payment)
{
$orderId = $payment->order_id; 
$order  = $api->order->fetch($orderId);

//$orders = $api->order->all($options); // Returns array of order objects
//$payments = $api->order->fetch($orderId)->payments(); // Returns array of payment objects against an order
$install=0;
$ty='';
$cprice=0;
if($order->receipt!='')
{
$x=explode("-",$order->receipt);
$paymentmode = (int)$x[3];
if(sizeof($x)==6)
		  {
		  $install = (int)$x[5];
		  }
					
$cname='';
if($x[0]==1)
{
	$co="Full Course";
	$cor=Courses::find($x[1]);
	$cname=ucfirst($cor->name);
	$cprice=$cor->price;
}else
{
	$co="Individual Course";
	$cor=S_cor::find($x[1]);
	$cname=ucfirst($cor->name);
	$cprice=$cor->price;
}
//echo $order->receipt;
$stu=Register::find($x[4]);

if($install!=0)
		{
			if($cor->pay_type!='')
			{
				$ch=Install_pay::where('cid',(int)$x[4])->where('cu_id',$x[1])->count();
				$type="New Installment System Paid in ".$ch ." Part";
			}else
			{
				$ch=Half_pay::where('cid',(int)$x[4])->where('cu_id',$x[1])->count();
				$type="Old Installment System Paid in ".$ch ." Part";
			}
				
			$ty='<tr>
      <td><strong>Payment In</strong></td>
      <td>'.$type.'</td>
    </tr>';
		}else
		{
			$ty='<tr>
      <td><strong>Payment In</strong></td>
      <td>Full</td>
    </tr>';
		}
}else
{
	
}
echo '<table class="table table-bordered table-hover table-responsive" border="1">
  <tbody>
    <tr>
      <td colspan="2"><h3>Payment Information</h3></td>
    </tr>
    <tr>
      <td><strong>Payment Id</strong></td>
      <td>'.$billId.'</td>
    </tr>
    <tr>
      <td><strong>Email</strong></td>
      <td>'.$payment->email.'</td>
    </tr>
    <tr>
      <td><strong>Phone</strong></td>
      <td>'.$payment->contact.'</td>
    </tr>
    <tr>
      <td><strong>Amount Pay</strong></td>
      <td><strong>Rs.</strong>'.($payment->amount/100).'</td>
    </tr>
    <tr>
      <td><strong>Payment Time</strong></td>
      <td>'.date("d/m/Y h:i:s A",$payment->created_at).'</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><h3>Order Information</h3></td>
    </tr>
    <tr>
      <td><strong>Order Id</strong></td>
      <td>'.$payment->order_id.'</td>
    </tr>
    <tr>
      <td><strong>Order status</strong></td>
      <td>'.$order->status.'</td>
    </tr>';
	if($order->receipt!='')
{
    echo '<tr>
      <td colspan="2" align="left"><h3>Course and Student Information</h3></td>
    </tr>
	
    <tr>
      <td><strong>Course Name</strong></td>
      <td>'.$cname.'-('.$x[1].')</td>
    </tr>
	<tr>
      <td><strong>Course Price</strong></td>
      <td>Rs.'.$cprice.'</td>
    </tr>
	<tr>
      <td><strong>Student Id</strong></td>
      <td>'.$stu->id.'</td>
    </tr>
    <tr>
      <td><strong>Student Name</strong></td>
      <td>'.ucfirst($stu->name).'</td>
    </tr>
    <tr>
      <td><strong>Student Email</strong></td>
       <td>'.$stu->email.'</td>
    </tr>
    <tr>
      <td><strong>Student Phone</strong></td>
      <td>'.$stu->phone.'</td>
    </tr>'.$ty.'
	<tr>
      <td><strong></strong></td>
      <td><a class="btn btn-info" href="'.TP_BACK_SIDE.'student/viewinfo/'.$stu->id.'">Open Courses Details</a></td>
    </tr>';
}
  echo '</tbody>
</table>';
}else
{
	echo '<center>Not Found</center>';
}

	}
		 }
}
