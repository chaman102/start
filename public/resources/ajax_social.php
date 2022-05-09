<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }


$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */
 $table=ucfirst($_POST['action']);
 $url=strtolower($_POST['action']);
  $tablename=$table::table();
 $filen="ajax_".$table.".php";
 $consss=0;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'id', 
	1 =>'title'
	
	
);

// getting total number records without any search


$sql = "SELECT `id`,`title`,`url`,`status` ";
$sql.=" FROM `".$url."`";
$query=mysqli_query($conn, $sql) or die($filen.": get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT  `id`,`title`,`url`,`status` ";
$sql.=" FROM `".$url."` WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( title LIKE '%".$requestData['search']['value']."%' ";   	    	
	$sql.="  )";	
}
$query=mysqli_query($conn, $sql) or die($filen.": get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die($filen.": get employees");

$data = array();
$row= array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
		$nestedData=array(); 
		
$ro=$table::findOrFail($row['id']);
if(strtolower($ro->status)=="active")
{
	$scol='badge outline-badge-success';
}
else{
	
$scol='badge outline-badge-danger';
}

$code=TP_BACK_SIDE.$url.'/delete/'.$ro->id;			
$nestedData[] = $ro->id;
$nestedData[] = ucfirst($ro->title);
$nestedData[] = $ro->url;

$nestedData[] = '<form class="widget-content" action="'.TP_BACK_SIDE.$url.'/status_data" method="post"><input type="hidden" name="status_id" value="'.$ro->id.'"><button type="submit" name="sub_status" class="'.$scol.'">'.$ro->status.'</button></form>';
$nestedData[] = '<ul class="table-controls"><li><a class="btn" href="'.TP_BACK_SIDE.$url.'/edit/'.$ro->id.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li><li><button onClick="archiveFunction('.$ro->id.')" type="button" name="sub_delete" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button></li></ul>';
$data[] = $nestedData;
}
$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
