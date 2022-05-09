<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
	
	protected $table ="permissions";	
	public $timestamps = true;
	 protected $fillable = [
        'name', 'slug',
    ];
	
	
	public static function call_cl_fun() {
		return (new Permission());
  }
	
	public static function table() {
	
        return with(new static)->getTable();
    
  }
	public static function tableclass()
    {
        return static::class;
    }
	 // Common Database Methods
	public static function hd_css() {
	$x=stylesheet_formate(TP_BACK.'plugins/table/datatable/datatables.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/table/datatable/custom_dt_html5.css');
    $x.=stylesheet_formate(TP_BACK.'plugins/table/datatable/dt-global_style.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/promise-polyfill.js');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/sweetalert2.min.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/sweetalert.css');
	$x.=stylesheet_formate('assets/css/components/custom-sweetalert.css');
	echo $x;
}
public static function hd_script() {
	$x=script_formate('assets/scripts/jquery.slugify.js'); 
	$x.=script_formate(TP_BACK.'plugins/table/datatable/datatables.js'); 
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/dataTables.buttons.min.js');
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/jszip.min.js');
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/buttons.html5.min.js');
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/buttons.print.min.js');
	$x.=script_formate(TP_BACK.'plugins/sweetalerts/sweetalert2.min.js');
	$x.=script_formate(TP_BACK.'plugins/sweetalerts/custom-sweetalert.js');	
	$x.=self::extra_script();
	echo $x;
}	
    public static function extra_script()
    {
       $table = strtolower(self::tableclass());
?>
<script type="text/javascript">

function archiveFunction(id) {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger mr-3',
    buttonsStyling: false,
  })

  swalWithBootstrapButtons({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true,
    padding: '2em'
  }).then(function(result) {
    if (result.value) {
		
      swalWithBootstrapButtons(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
	  setTimeout( function () {
      
      $.post( "<?=TP_BACK?>resources<?=DS?>ajax_delete.php",{ id: id,table:'<?=strtolower($_GET['pname'])?>'}, function( data ) {  
        $("#delete"+id).fadeOut(1000, function(){ $(this).remove();});
});
   
    }, 1000);
	  
    } else if (
      // Read more about handling dismissals
      result.dismiss === swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons(
        'Cancelled',
        'Your Record is safe :)',
        'error'
      )
    }
  })

}
    </script>
 <script type="text/javascript" language="javascript" >	
	$(document).ready(function() {	
	var dataTable = $('#<?=$table?>s').DataTable( {
    "createdRow": function(row, data, dataIndex) {
    let id = "delete"+data[0]; // amend 'data[0]' here to be the correct column for your dataset
    $(row).prop('id', id).data('id', id); 
  },
	"processing": true,
	"order": [[ 0, "desc" ]],
	"serverSide": true, dom : 'lBfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
        "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },	
	"lengthMenu": [ [10, 25, 50, 100,1000,2000,3000,10000, -1], [10, 25, 50, 100,1000,2000,3000,10000] ],
	"pageLength": 10,
	"ajax":{
	url :"<?=TP_BACK?>resources/ajax_<?=$table?>.php", // json datasource
	type: "post", // method  , by default get
	data: {           
	action: '<?=$table?>',      // etc..
	},						
	error: function(){  // error handling
	$(".employee-grid-error").html("");
	$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
	$("#employee-grid_processing").css("display","none");	
	}
	}
	} );
	} );
	</script>
		<?php
    }
   
    // replaced with a custom save()
    // public function save() {
    //   // A new record won't have an id yet.
    //   return isset($this->id) ? $this->update() : $this->create();
    // }
   
      

   public static function delete_data()
	{
		extract($_POST);
		
		$x=self::find($delete_id);
		if($x!='')
		{
			
			$pp=$x->delete();
			if($pp)
			{
				$message='<div align="center"><h4 class="alert alert-warning">Record Deleted Successfully</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span></div>';
  echo output_message($message);
redirect_by_js('show',100);
}else
{
	$message='<div align="center"><h4 class="alert alert-danger">Record Not Deleted</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span></div>';
  echo output_message($message);
redirect_by_js('show',100);
	}
		}else
		{
			$message='<div align="center"><h4 class="alert alert-danger">Record Not Found</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span></div>';
  echo output_message($message);
redirect_by_js('show',100);
			}
		}
    protected static function action_data($id, $type)
    {
		if ($type == 'edit')
            {
        $data = self::find($id);
			}else
			{
		 $data = self::call_cl_fun();
		 	}
        
        if (isset($_REQUEST['submit']))
        {
            extract($_POST);
           
            $data->name = $cname;            
            $data->slug = $slug;
              
            
            if ($type == 'edit')
            {
                

                $us = self::find($id);
				$data->updated_at = date('Y-m-d H:i:s');               
                $pp = $data->save();
                $message = '<div align="center"><h4 class="alert alert-success">Success! Record Updated Successfully</h4><span><img src="' . TP_BACK . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
                echo output_message($message);
                redirect_by_js($id, 100);
            }
            else
            {
               
                   
                $pp = $data->save();
                $message = '<div align="center"><h4 class="alert alert-success">Success! New Record Added Successfully</h4><span><img src="' . TP_BACK . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
                echo output_message($message);
                redirect_by_js("add", 1000);
            }
        }

    }
   
    public static function form_data()
    {
        echo $fo = Forms::form_start();

        if ($_GET['action'] == 'add')
        {
            self::action_data('', 'add');            
            $cname = '';            
            $slug = '';          
        }
        else
        {
            self::action_data($_GET['id'], 'edit');
            $rw = self::find($_GET['id']);            
            $cname = $rw->name;
            $slug = $rw->slug;       

        }

        echo $fo = Forms::input("Name", "cname", $cname,1);
        echo $fo = Forms::input("Slug Name", "slug", $slug,1);      

        echo $fo = Forms::submit();
        echo $fo = Forms::form_end();
    }

    public static function show($pname, $action)
    {
        echo '<form name="form" action="deleteall.php" method="post">
            <table id="'.$pname.'" class="table table-hover non-hover  table-responsive" style="width:100%">
              <thead>
               <tr>
                  <th><input type="checkbox" name="checkall"/>Id</th>
				  <th>Name</th>
                  <th>Slug</th>
				   <th >Created</th>
				    <th >Updated</th>
                  <th >Options </th>
                </tr>
              </thead>
              
            </table>
          </form>';
    }
	public function getRole($request){


     ## Read value
     $draw = $request['draw'];
     $start = $request["start"];
     $rowperpage = $request["length"]; // Rows display per page

     $columnIndex_arr = $request['order'];
     $columnName_arr = $request['columns'];
     $order_arr = $request['order'];
     $search_arr = $request['search'];

     $columnIndex = $columnIndex_arr[0]['column']; // Column index
     $columnName = $columnName_arr[$columnIndex]['data']; // Column name
     $columnSortOrder = $order_arr[0]['dir']; // asc or desc
     $searchValue = $search_arr['value']; // Search value

     // Total records
      $totalRecords = Role::select('count(*) as allcount')->count();
     $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

     // Fetch records
     $records = Role::get();

     $data_arr = array();
     
     foreach($records as $record){
        $id = $record->id;       
        $name = $record->name;
        $slug = $record->slug;
		$created = $record->created_at;
		$updated = $record->updated_at;
        $data_arr[] = array(
          "id" => $id,         
          "name" => $name,
          "slug" => $slug,
		  "created_at" => $created,
		  "updated_at" => $updated,
		  "option" => ''
        );
     }

     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
     );

     echo json_encode($response);
     exit;
   }
	 public function roles()
    {
        return $this->belongsToMany(Permission::class);
    }
   
}

?>