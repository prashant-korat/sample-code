<?php  
	$class = 'alt-row';
	if( $listArr ){
		foreach($listArr as $list) {
			$record_id = $list[$this->dbTableId];
			if($list['is_active']==0){
				$activeHtml = '<a title="Activate user" class="activeUser" rel="'.$record_id.'" data="1" href="javascript:void(0)">
								  <img src="'.base_url().'images/admin/in-active.png">
							   </a>';
			}else{
				$activeHtml = '<a title="De-activate the user" class="activeUser" rel="'.$record_id.'" data="0" href="javascript:void(0)">
								  <img src="'.base_url().'images/admin/active.png">
							   </a>';
			}
?>
				
			<tr id="row_<?php echo $record_id ?>" class="<?php echo $class ?>">
				<td><input type="checkbox" value="<?php echo $record_id ?>" name="recordId[]" /></td>
				<td><?php echo strip_tags($list['fname']).' '.strip_tags($list['lname']) ?></td>
				<td><?php echo strip_tags($list['email']) ?></td>
				<td>
                      <?php echo $activeHtml ?>
                      <a href="javascript:void(0)" class="delete" rel="<?php echo $record_id ?>" data-="<?php echo $list['del_in'] ?>" title="Delete">
                          <img src="<?php echo base_url() ?>images/admin/cross.png" alt="Delete" />
                      </a>
                      <a title="Click to see Users Detail" class="view_users" rel="<?php echo $record_id;?>" href="javascript:void(0)">
                          <img alt="info" src="<?php echo base_url() ?>images/admin/information.png">
                      </a>
				</td>
			</tr>
<?php  
			if($class == 'alt-row') { $class=' '; } else {$class='alt-row';}
		}
	} else {
?>            
		<tr align='center'><td colspan='3' style='text-align:center'>No Records Found</td></tr>
<?php  
	}
?>
