<?php
function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}
function date_convert ($created='')
{   $x='';
	if($created!='' || $created!=NULL)
	{
	 $dats=date_create($created);
	$x=date_formate(date_format($dats,"Y-m-d"));
	}
	 return $x;
}
function empty_ch($check='')
{
	if($check!='' || $check!=NULL)
	{
		 return $check;
	}else
	{
		 return  null;
		}
		 return $x;
	}
function date_convert_dp ($created='')
{   $x='';
	if($created!='' || $created!=NULL)
	{
	$x=date('d M Y', strtotime($created));
	}
	 return $x;
}

function date_view ($created='')
{   $x='';
	if($created!='' || $created!=NULL)
	{
	$x=date('d-m-Y g:i A', strtotime($created));
	}
	 return $x;
}

function random_color()
{
return  $color= '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
function redirect_by_script( $location = NULL ) {
  if ($location != NULL) {
    ?>
   <script>
     window.location='<?=$location?>';
    </script>
    <?php
    exit;
  }
}

function dateDiffInDays($date1, $date2)  
{ 
    // Calulating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
}


function date_formates( $dates = '' ) {
	$ds=explode("-",$dates);
	$dats=$ds[2]."/".$ds[1]."/".$ds[0];
	return $dats;
}

function date_formate( $dates = '' ) {
    $ds=explode("-",$dates);
	$dats=$ds[2]."-".$ds[1]."-".$ds[0];
	return $dats;
}

function date_time_formate( $dates = '' ) {
    $ds=explode(" ",$dates);
	$date=date_formate($ds[0]);
	$date=$date." ".$ds[1];
	return $date;
}

function redirect_by_js($page,$time)
{
	?>
<script>
function Redirect()
{

 window.location='<?=$page?>';
 
 }
setTimeout('Redirect()', <?=$time?>);
</script>
<?php
	}
function toast_msg($type,$title,$message,$time)
{
?>
<script>

 toastr["<?=$type?>"]("<?=$title?>", "<?=$message?>")
 toastr.options = {
  "closeButton": true,
  "debug": true,
  "newestOnTop": true,
  "progressBar": true,
  "rtl": true,
  "positionClass": "toast-top-full-width",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": 300,
  "hideDuration": 1000,
  "timeOut": <?=$time?>,
  "extendedTimeOut": 1000,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
</script>
<?php
	}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}
spl_autoload_register(function ($class_name) {
	$x=0;	

 $x=preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $class_name);
  $class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
   $path2 = LIB_PATH.DS."model".DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } elseif(file_exists($path2))
  {   require_once($path2);
	  } elseif($x==1) {
		//die("The file {$class_name}.php could not be found.");
	//	die('<div align="center"><h4 class="alert alert-warning">Error! The File Name '.$class_name.'.php could not be found <a href="'.TP_BACK.'admin">Go Back</a></h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span></div>');
	}
});






function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function include_resources_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'resources'.DS.$template);
}

function include_layout_web($site="") {
	include(SITE_ROOT.DS.'front_layouts'.DS.$site);
}
function include_layout_front($site="") {
	include(SITE_ROOT.DS.'user_admin'.DS.'layouts'.DS.$site);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
  date_default_timezone_set('Asia/Kolkata');
    $timestamp = strftime("%d-%m-%Y %I:%M:%S %p", time());
	$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function cleanurl($string) {
 $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   return preg_replace('/-+/', '-', ucfirst($string));
}
function backup_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'backup.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
  date_default_timezone_set('Asia/Kolkata');
    $timestamp = strftime("%d-%m-%Y %I:%M:%S %p", time());
	$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function student_log_action($action, $message="",$student) {
	$logfile = SITE_ROOT.DS.'logs'.DS.$student.'.txt';
	$filename=$student.'.txt';
	if(file_exists($logfile))
{
} else {
    fopen("$filename", "w") or die("Unable to open file!");
}
    $new = file_exists($logfile) ? false : true;
    if($handle = fopen($logfile, 'a')) { // append
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = strftime("%d-%m-%Y %H:%M:%S", time());
	$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}
function datetime_to_text2($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%d/%m/%Y", $unixdatetime);
}
function daysBetweenns($dt1, $dt2) {
  return date_diff(
  date_create($dt2),  
  date_create($dt1)
  )->format('%a');
  }
function upload($path,$fname)
{
$target_dir = $path;
$nns=rand(5, 8522166);
$image=$fname["name"];
$name = explode(".", $image);
$newfile = $name[0].'_'.$nns.'.'.$name[1];
if(file_exists($path))
{
} else {
    mkdir($path, 0700);
}
$target_file = $path . $newfile;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($fname["tmp_name"]);
    if($check !== false) {
      //  echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
	 echo '<div class="alert alert-danger">
  <strong>Warning!</strong> Sorry, file already exists.
</div>';
   
    $uploadOk = 0;
}
// Check file size
if (round($fname["size"]/1024) >1024) {
   
	 echo '<div class="alert alert-danger">
  <strong>Warning!</strong> Sorry, your file is too large ('.round(($fname["size"]/1024)/1024).').
</div>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
   	 echo '<div class="alert alert-danger">
  <strong>Warning!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed.
  Your File is '.$imageFileType.'; 
</div>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  
	echo '<div class="alert alert-danger">
  <strong>Warning!</strong>Sorry, your file was not uploaded..
</div>';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($fname["tmp_name"], $target_file)) {
     /*   echo '
		<div class="alert alert-success">
  <strong>Success!</strong> The file has been uploaded.
</div>'; */
//$newfile=compress_image($newfile,$newfile,90);
return $newfile;
    } else {
       
		echo '<div class="alert alert-danger">
  <strong>Warning!</strong>Sorry, there was an error uploading your file.
</div>';
    }
}
}

function upload_img($image,$path){
	 $path=SITE_ROOT.DS.$path;	
	 $file_tmp =$image['tmp_name'];
     $file_name = $image['name'];
	 $n='';
	 $nns='';	 
     $n=explode('.', $image['name']);
	 $nns=rand(5, 8522166);
	 $imgname=$n[0]."_".rand(5, 8522166).".".$n[1];
	 move_uploaded_file($file_tmp,$path.$imgname);
	 return $imgname;
	}

function test_img($image,$size)
 { 
	  $size=($size*1024)*1024;
      $errors= array();
	  
      $file_name = $image['name'];
      $file_size =$image['size'];
      $file_tmp =$image['tmp_name'];
      $file_type=$image['type'];
      $file_exts=explode('.',$image['name']);
	  $file_ext= strtolower($file_exts[1]);      
      $extensions= array("jpeg","jpg","png","pdf","doc","docx");
      //echo $file_size;
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG Or PDF file.";
      }
      
      if($file_size > $size){
         $errors[]='File size must be excately '.$size.' MB';
      }
      
       if(empty($errors)==TRUE)
	 {
		 return 0;
	 }else
	 {   
	 return 1;
	  }
      return $errors;      
   }
function daysUntil($start, $end) {
    $lookup = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];
    $days = $lookup[$end] - $lookup[$start] + ($lookup[$end] <= $lookup[$start] ? 7 : 0);
   // return "{$days} days from {$start} to {$end}\n";
   return $days;
}
function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
			
            delete_files( $file );      
        }

       // rmdir( $target );
    } elseif(is_file($target)) {
		
		$x=strpos("$target",".php");
		if($x==0)
		{
        unlink( $target ); 
	} 
    }
}
function random()
	{
$code=rand(1000000, 2000000);
return $code;
	}
	function stylesheet_formate($url)
	{
	return'<link rel="stylesheet" href="'.$url.'">'."\n";
	}
 	
	function script_formate($url)
	{
	return'<script src="'.$url.'"></script>'."\n";
	}
function print_view()
	{?>	
	<script type="text/javascript">

function print1(strid)
{
if(confirm("Do you want to print?"))
{
var values = document.getElementById(strid);
var printing =
window.open('','','left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,sta­?tus=0');
printing.document.write(values.innerHTML);
printing.document.close();
printing.focus();
printing.print();
printing.close();
}
}
</script>

<!--<div id="print2">-------Data to print----------</div>-->
<?php
//$ps="'print2'";
//echo'<button type="button" class="btn btn-default waves-effect waves-light" onClick="return print1('.$ps.')"><i class="fa fa-print"></i> Print</button>';

	}

?>