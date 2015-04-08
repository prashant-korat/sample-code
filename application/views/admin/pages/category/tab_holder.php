<?php if($parent_id) { 
		$res = $this->db->where('category_id', $parent_id)->get('category')->row_array();
		if($res){
			$parent_id = $res['parent_id'];
?>
            <li>
                <a href="javascript:void(0)" class="load_sub_cat back" rel="<?php echo $parent_id ?>" title="Back">Back Category</a>
            </li>
<?php 	}
	  } ?>

<li><a href="javascript:void(0)" rel="#tab1" class="default-tab"><?php echo singular(humanize($this->router->class)); ?> - List</a></li> <!-- href must be unique and match the id of target div -->
<li><a href="javascript:void(0)" rel="#tab2">Add / Edit</a></li>