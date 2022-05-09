
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
  <div class="widget widget-one">
    <div class="widget-heading">
      <h6 class="">Welcome Screen</h6>
    </div>
    <?php $template=Template::findOrFail(1); ?>
    <!-- /.dropdown js__dropdown --> 
    
    <br>
    <br>
    <h1 class="text-center" >
      <?=$template->sitename?>
    </h1>
    <center class="animated wow bounceIn">
      <img src="<?=BASE_PATH?><?=$template->image_path()?>"  class="img-responsive img-thmbnail">
    </center>
    <br>
  </div>
</div>

<!-- /.row small-spacing --> 

