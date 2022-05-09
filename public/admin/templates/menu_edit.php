<h2>Edit Menu</h2>
<form method="post" action="<?php echo site_url('menu.save'); ?>">
	<p>
		<label for="edit-menu-title">Title</label>
		<input type="text" name="title" id="edit-menu-title" autocomplete="off" class="title" value="<?php echo $row[MENU_TITLE]; ?>">
	</p>
	<p>
		<label for="edit-menu-url">URL</label>
		<input type="text" name="url" id="edit-menu-url" class="url" autocomplete="off" value="<?php echo $row[MENU_URL]; ?>">
	</p>
	<p>
		<label for="edit-menu-class">Type</label>

        <select name="class" id="edit-menu-class">
                                <?php
                                $me = Menu_type::find_by_id($row[MENU_CLASS]);
								echo'<option selected value="'.$me->id.'">'.ucfirst($me->name).'</option>';
								$mes = Menu_type::find_all();
								foreach($mes as $menuda)
								{
									if($menuda->id!=$me->id && $menuda->status=="Active")
									{
                                echo'<option value="'.$menuda->id.'">'.ucfirst($menuda->name).'</option>';
									}
								}
                                ?>
                                
                                </select>
	</p>
    <p>
		<label for="edit-menu-class">Status</label>
        <?php
		if($row[MENU_STATUS]=="Active")
		{
			$n="Selected";
			$n1='';
		}else
		{
			$n1="Selected";
			$n='';
			}
		
		?>
        <select name="status" id="edit-menu-status">
        <option value="Active" <?=$n?> >Active</option>
         <option value="Deactive" <?=$n1?> >Deactive</option>
        </select>
		
	</p>
	<input type="hidden" name="menu_id" value="<?php echo $row[MENU_ID]; ?>">
</form>