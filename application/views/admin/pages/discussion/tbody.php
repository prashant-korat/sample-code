<?php  
	$class = 'alt-row';
	if( $listArr ){
		foreach($listArr as $list) {
			$record_id = $list[$this->dbTableId];
?>
				
			<tr id="row_<?php echo $record_id ?>" class="<?php echo $class ?>">
				<td><input type="checkbox" value="<?php echo $record_id ?>" name="recordId[]" /></td>
				<td><?php echo ($list['discussion_text']) ?></td>
				<td><?php echo ($list['like_count']) ?></td>
				<td><?php echo ($list['unlike_count']) ?></td>
				<td>
                  <a title="Edit" class="edit" rel="<?php echo $record_id;?>" href="javascript:void(0)">
                      <img alt="Edit" src="<?php echo base_url() ?>images/admin/pencil.png">
                  </a>
                  
                  <a href="javascript:void(0)" class="delete" rel="<?php echo $record_id ?>" data-="<?php echo $list['del_in'] ?>" title="Delete">
                      <img src="<?php echo base_url() ?>images/admin/cross.png" alt="Delete" />
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
