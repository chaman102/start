<?php  
  $cost=Register::count();
   $xp='ml-auto';
    if(isset($_GET['action']))
   {
	   $xp='';
	   $action='';
   }
  ?>
<ul class="navbar-nav flex-row <?=$xp?>">
  <li class="nav-item more-dropdown">
    <div class="dropdown  custom-dropdown-icon"> <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Settings</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
      <polyline points="6 9 12 15 18 9"></polyline>
      </svg></a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown"> 
      <a href="<?=TP_BACK_SIDE?>video/daily" target="_blank" class="dropdown-item" data-value="Daily Update Videos">Daily Update</a> 
      <a href="<?=TP_BACK_SIDE?>courses/show" target="_blank" class="dropdown-item" data-value="Show Course">Show Course</a> 
      <a href="<?=TP_BACK_SIDE?>course_mo/add" target="_blank" class="dropdown-item" data-value="Show Course">Add Course Module</a> 
      <a href="<?=TP_BACK_SIDE?>video/add" target="_blank" class="dropdown-item" data-value="Show Course">Add Video Module</a> 
      <a href="<?=TP_BACK_SIDE?>video/show" target="_blank" class="dropdown-item" data-value="Show Videos">Show Videos</a> 
      <a href="<?=TP_BACK_SIDE?>courses/add" target="_blank" class="dropdown-item" data-value="Add New Course">Add New Course</a> 
      <a href="<?=TP_BACK_SIDE?>directstudent<?=DS?>add" class="dropdown-item" target="_blank" data-value="Add Direct Student">Add Direct Student</a> 
      <a href="<?=TP_BACK_SIDE?>student<?=DS?>show" class="dropdown-item" target="_blank" data-value="Show Student">Show Student</a> 
      <a href="<?=TP_BACK_SIDE?>coursesnew<?=DS.$cost?>" class="dropdown-item" target="_blank" data-value="Add Normal Course">Add Normal Course</a> 
      <a href="<?=TP_BACK_SIDE?>coursesinstall<?=DS.$cost?>" class="dropdown-item" target="_blank" data-value="Add Installment Studen">Add Installment Student</a> 
      <a href="<?=TP_BACK_SIDE?>course_purchase_today" class="dropdown-item" target="_blank" data-value="Today's Purchase">Today's Purchase</a> 
      <a href="<?=TP_BACK_SIDE?>video/cuvideo" class="dropdown-item" target="_blank" data-value="Today's Purchase">Show Runing Videos</a> 
      <a href="<?=TP_BACK_SIDE?>video/cunvideo" class="dropdown-item" target="_blank" data-value="Today's Purchase">Show Not Runing Videos</a> </div>
    </div>
  </li>
</ul>
