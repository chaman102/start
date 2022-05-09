<?php
	require_once(LIB_PATH.DS.'database.php');
	use Intervention\Image\ImageManager;
	class Register_mo extends Register {
		public static function course_purchase_todays() {

		?>
	
    <div class="layout-px-spacing">
      <div class="row layout-top-spacing">
        <div id="basic" class="col-lg-12 layout-spacing">
          <div class="statbox widget box box-shadow">
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4>Full Course Purchase Today</h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">			
			 <table id="course_pu" class="table table-hover non-hover dataTable no-footer no-footer" style="width:100%">
                <thead>
                 <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Today's Purchase Total</th>
                    <th>Options </th>
                  </tr>
                </thead>
              
              
              </table>
			
			</div>
          </div>
        </div>
      <div id="basic" class="col-lg-12 layout-spacing">
          <div class="statbox widget box box-shadow">
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4>Installment Course Purchase Today</h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">			
			 
			
			</div>
          </div>
        </div>
      
	  
	  </div>
    </div>
  
		<?php
		  }
		  public static function reports() {
echo '<h3 class="text-center">Free Student Export</h3>';
if(!isset($_REQUEST['submit']))
{
echo $fo=Forms::form_start();
echo $fo=Forms::date_mm("Start ","start",'','start_date',1);
echo $fo=Forms::date_mm("End","end",'','end_date',1);
echo $fo=Forms::submit();
echo $fo=Forms::form_end();
}else
{
  $c=Courses_pur::pluck('cid')->toArray();
          $start=$_POST['start'];
          $end=$_POST['end'];  
          echo '<h5 class="text-center">From '.date('d-m-Y',strtotime($start))." to ".date('d-m-Y',strtotime($end)).'</h5>';
   echo'<div class="table-responsive" data-pattern="priority-columns">
        <table id="zero-config" class="table table-hover non-hover" style="width:100%">
          <thead>
           <tr>
           <th>Id</th>
           <th>Name</th>
           <th>Email</th>
           <th>Phone</th>          
           <th>Created</th>
          
            </tr>
          </thead>    
          <tbody>';  
           
          $rs=Register::WhereNotIn('id',$c)->whereBetween('created', [$start, $end])->get(['id','name','email','phone','created']);
        
          foreach ($rs as $key=>$v) {

           echo'<tr>
           <td>'.$v['id'].'</td>
           <td>'.$v['name'].'</td>
           <td>'.$v['email'].'</td>
           <td>'.$v['phone'].'</td>           
           <td>'.datetime_to_text($v['created']).'</td>
          
            </tr>';
          }
            
          echo '</tbody>              
      </table>
    </div>';
 
}
      }
		  
	}