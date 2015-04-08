<?php  
	$class ='alt-row';
	if( $listArr ){
		foreach($listArr as $list) {
			$record_id = $list[$this->dbTableId];
?>
				
			<tr id="row_<?php echo $record_id ?>" class="<?php echo $class ?>">
				<td><input type="checkbox" value="<?php echo $record_id ?>" name="recordId[]" /></td>
				<td><?php echo strip_tags($list['config_name']) ?></td>
                <td><?php echo character_limiter(strip_tags($list['config_value']),150) ?></td>
                <td>
                      <a title="Edit" class="edit" rel="<?php echo $record_id;?>" href="javascript:void(0)">
                          <img alt="Edit" src="<?php echo base_url() ?>images/admin/pencil.png">
                      </a>
                      <a href="javascript:void(0)" class="delete" rel="<?php echo $record_id;?>" data-="<?php echo $list['del_in'];?>" title="Delete">
                          <img src="<?php echo base_url() ?>images/admin/cross.png" alt="Delete" />
                      </a>
				</td>
			</tr>
<?php  
			if($class=='alt-row') { $class=' '; } else {$class='alt-row';}
		}
	} else {
?>            
			<tr align='center'><td colspan='5' style='text-align:center'>No Records Found</td></tr>
<?php  
	}
?>
