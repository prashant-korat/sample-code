<?php
class mdl_materials extends CI_Model
{
	var $dbTable;
	var $dbTableId;

/*
+----------------------------------------------------------+
	Get all data for coupons information.
	@params : $dbTable -> name of db table
			  $dbTableId -> name of db table field
	          $del_in -> 1 or 0 value change in db
+----------------------------------------------------------+
*/
	function getData($parent_id = 0)
	{
		$f = $this->input->post('f');
		$s = $this->input->post('s');
		$srchKey = trim($this->input->post('searchtxt'));
		$where ='';

		if(@$srchKey != '') //if search text
		{
		  $srchKey = mysql_escape_string($srchKey);
		  $this->db->like('question_txt', $srchKey);
		}

		$response = $this->db//->where('parent_id', $parent_id)
							 ->get($this->dbTable);
		
		return $response;
	}
	
	function loadCategory($parent_id = 0, $selected_id = ''){
		if(!isset($parent_id))
			return false;
			
		$res = $this->db->where('parent_id', $parent_id)->get('category')->result_array();

		if($res){
			$optionArr = array();
//			if($selected_id == '')
//				$optionArr[] = '';
			foreach($res as $r){
				$optionArr[$r['category_id']] = $r['cat_name'];
			}
			$catLoadClass = ($parent_id == 0) ? 'load-sub-category' : 'load-sub-sub-category';
			return array( 'htmlCont' 	=> '<p>'.form_dropdown('cat_id', $optionArr, $selected_id, 'class="text-input small-input '.$catLoadClass.'" '). '</p>' );
		}
	}
	function loadAllCatInput($id){
		$res = $this->db->where('category_id', $id)->get('category')->row_array();
		
		if($res){
			$optionLoad = $this->loadCategory($res['parent_id'], $res['category_id']);

			$res1 = $this->loadAllCatInput($res['parent_id']);
			echo $optionLoad['htmlCont'];
		}
	}
}