<!-- @params: f -> name of table field, s -> name of table sorting field -->
<tr style="cursor:pointer;">
     <th><input class="check-all" rel='<?php echo $del_in ?>' type="checkbox" name="allbox" /></th>
     <th f="firstname" s="<?php echo get_sort_order(@$sort,@$field, 'firstname') ?>">Name</th>
     <th f="email" s="<?php echo get_sort_order(@$sort,@$field, 'email') ?>">Email</th>
     <th>Action</th>
</tr>