<?php
class mdl_discussion extends CI_Model
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
	function getData($discussion_id = '', $parent_id = 0)
	{
		$f = $this->input->post('f');
		$s = $this->input->post('s');
		$srchKey = trim($this->input->post('searchtxt'));
		$where ='';
		
		$likeQur = 'SELECT count(*) FROM `fis_discussionreview` WHERE `discussion_id` = fis_'.$this->dbTable.'.discussion_id  AND `type` = 1';
		$unlikeQur = 'SELECT count(*) FROM `fis_discussionreview` WHERE `discussion_id` = fis_'.$this->dbTable.'.discussion_id  AND `type` = 0';
		
		$this->db->select('fis_'.$this->dbTable.'.*, ('.$likeQur.') as like_count, ('.$unlikeQur.') as unlike_count');

		if(@$srchKey != '') //if search text
		{
		  $srchKey = mysql_escape_string($srchKey);
		  $this->db->like('discussion_text', $srchKey);
		}
		if($discussion_id)
			$this->db->where('discussion_id', $discussion_id);
			
		$this->db->where('parent_id', $parent_id);

		$response = $this->db->get($this->dbTable);
		
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