<?php
	$class = 'alt-row';  
	if( $listArr ){
		foreach($listArr as $list) {
			$record_id = $list['admin_id'];
?>
				
			<tr id="row_<?php echo $record_id ?>" class="<?php echo $class ?>">
				<td><?php echo $list['username'] ?></td>
                <td><?php echo ($list['admin_type'] == 'A')?'Admin':'Catalouges';?> User</td>
				<td>
                    <a title="Edit" class="edit" rel="<?php echo $record_id ?>" href="javascript:void(0)">
                        <img alt="Edit" src="<?php echo base_url() ?>images/admin/pencil.png">
                    </a>
				</td>
			</tr>
<?php  
			if($class=='alt-row') { $class=' '; } else {$class='alt-row';}
		}
	} else {
?>            
			<tr align='center'><td colspan='3' style='text-align:center'>No Records Found</td></tr>
<?php  
	}
?>
