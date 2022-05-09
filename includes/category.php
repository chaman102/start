<?php
	use Illuminate\Database\Eloquent\Model;
	use Intervention\Image\ImageManager;
	class Category extends Model {
	protected $table="category";
	public $timestamps=false;
  protected $folder="category";
   
  protected $fillable = ['name'];  
    public static function call_cl_fun() {
    return (new Category());
    }
	 public static function table() {	
        return with(new static)->getTable();    
  }
  public static function tableclass()
    {
        return static::class;
    }
     public function image_path()
    {
        return FULL_PATH.$this->folder.DS.$this->image;
    }
    public function fpath()
    {
        return FULL_PATH.$this->folder.DS.$this->image;
    }
    public function path()
    {
        return FULL_PATH.$this->folder.DS;
    }
    public function img_path()
    {
        return $this->folder.DS;
    }   
    // Common Database Methods
	public static function hd_css() 
     {
	$x=stylesheet_formate(TP_BACK.'plugins/table/datatable/datatables.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/table/datatable/custom_dt_html5.css');
    	$x.=stylesheet_formate(TP_BACK.'plugins/table/datatable/dt-global_style.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/promise-polyfill.js');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/sweetalert2.min.css');
	$x.=stylesheet_formate(TP_BACK.'plugins/sweetalerts/sweetalert.css');
	$x.=stylesheet_formate('assets/css/components/custom-sweetalert.css');	
	echo $x;
     }
     public static function hd_script() 
     {
	//$x=script_formate('assets/scripts/jquery.slugify.js'); 
	$x=script_formate(TP_BACK.'plugins/table/datatable/datatables.js'); 
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/dataTables.buttons.min.js');
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/jszip.min.js');
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/buttons.html5.min.js');
	
	$x.=script_formate(TP_BACK.'plugins/table/datatable/button-ext/buttons.print.min.js');
	$x.=script_formate(TP_BACK.'plugins/sweetalerts/sweetalert2.min.js');
	$x.=script_formate(TP_BACK.'plugins/sweetalerts/custom-sweetalert.js');
  $x.=self::extra_script();
	echo $x;
      }	

public static function extra_script() {
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
 public static function image_maker($image, $upload_size, $uid, $imgfield)
    {

        $message = '';
        $upload_size = ($upload_size * 1024) * 1024;
       
        $size = round($image['size']);
        $n = explode(".", $image['name']);
        $filename = $image["tmp_name"];
        $type = $n[1];
        if ($size > $upload_size)
        {

            $message = '<div align="center">                
                <h4 class="alert alert-danger">Image Size is Larger Than 1MB ' . $size . 'Kb</h4>                
            </div>';
            echo output_message($message);
            redirect_by_js('', 1000);
            exit();

        }
        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png')
        {
            toast_msg("Error", "", "Image type is not jpg or png -" . $type . "", 1000);
            $message = '<div align="center">                
                <h4 class="alert alert-danger">Image type is not jpg or png - ' . $type . '</h4>                
            </div>';
            echo output_message($message);
            redirect_by_js('', 1000);
?>
  
    <?php
            redirect_by_js('', 100);
            exit();
        }
        if ($uid != '')
        {
            $user = self::find($uid);
            if ($user->$imgfield != '')
            {

                unlink($_SERVER['DOCUMENT_ROOT'] . "/" . MYF . $user->image_path());
                $user->empty_imgae($uid);
            }
        }
        $n = explode('.', $image['name']);
        $imgname = $n[0] . "_" . rand(5, 8522166) . "." . $n[1];

        $manager = new ImageManager(array(
            'driver' => 'gd'
        ));
        $image = $manager->make($filename)->resize(null, 200, function ($constraint)
        {
            $constraint->aspectRatio();
        })
            ->save(SITE_ROOT . DS . $user->path() . $imgname);
        return $imgname;

    }
	public function empty_imgae($id=0) {
	  
	  $s=self::find($id);
	  $s->image='';
	  $pp=$s->save();    
	 if($pp) {	   
	    return true;
	  } else {
	    return false;
	  }
  }
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

public static function show($pname, $action)
    {
        echo '<form name="form" action="deleteall.php" method="post">
            <div class="table-responsive" data-pattern="priority-columns">
            <table id="'.strtolower(self::table()).'s" class="table table-hover non-hover" style="width:100%">
              <thead>
               <tr>
                  <th><input type="checkbox" name="checkall"/>Id</th>				  
				  <th>Name</th>                 
                  <th>Image</th>				 
                  <th>Status</th>				 
                  <th>Options </th>
                </tr>
              </thead>
              
          </table></div>
          </form>';
    }
public static function form_data() {
	echo $fo=Forms::form_start();
	if($_GET['action']=='add')
	{
	self::action_data('','add');
    $name='';	
    $image='';
	  $impath='';
    $text='';
	
    }
	else
	{
	self::action_data($_GET['id'],'edit');
	
    $rw=self::findOrFail($_GET['id']);
	  
        $name=$rw->name;
        $image=$rw->image;
	    	$impath=$rw->image_path();
        $text=$rw->text;
		}
    echo $fo=Forms::input("Name","name",$name,1);		
    if($_GET['action']=='add')
        {
		echo $fo=Forms::image("Upload image","image");
        }
	    else
	    {
		echo $fo=Forms::image_edit("Upload image","image",$impath,$image,"checkbox");	
		}	
    echo $fo=Forms::textarea("Text","text",$text,'',0);
	 echo $fo=Forms::submit();
	 echo $fo=Forms::form_end();
	 }	
      protected static function action_data($id,$type) {
        if ($type == "edit")
		 {
			  $data=self::find($id);
		 }else{
			 $data=self::call_cl_fun();
	   
        }
	  if(isset($_REQUEST['submit']))
        {
      extract($_POST);
          $data->name=$name;
      if($_FILES['image']['size']!=0)
		   {
			   $data->image=$data->image_maker($_FILES['image'],1,$id,'image');
      
			}elseif(isset($_POST['tpimg_image']))
		   {
			   $data->image=$_POST['tpimg_image'];
      }else{$data->image='';
      }$data->text=$text;
      
	  if($type=='edit')
{ 
if(isset($_REQUEST['check_image']))
			 {
				 unlink($_SERVER['DOCUMENT_ROOT'].'/'.MYF.$data->image_path());
	 $data->empty_image();
      }
  $pp=$data->save();
  $message='<div align="center"><h4 class="alert alert-success">Success! Record Updated Successfully</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
  echo output_message($message);
redirect_by_js($id,100);
}else
{

	 $data->status="Active";
  $pp=$data->save();
$message='<div align="center"><h4 class="alert alert-success">Success! New Record Added Successfully</h4><span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
echo output_message($message);
redirect_by_js('add',1000);
	}
	  }
}
}