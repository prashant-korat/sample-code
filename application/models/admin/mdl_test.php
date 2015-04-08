<?php
class mdl_test extends CI_Model
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
		$this->db->select($this->dbTable.'.*, (SELECT SUM(`attempt_count`) FROM `fis_user_attempt` WHERE `test_id` = fis_'.$this->dbTable.'.test_id) as attempt');
		if(@$srchKey != '') //if search text
		{
		  $srchKey = mysql_escape_string($srchKey);
		  $this->db->like('test_name', $srchKey);
		}

		$response = $this->db//->where('parent_id', $parent_id)
							 ->get($this->dbTable);
		
		return $response;
	}
	
	function loadCategory($test_cat_id = 0){
		$parent_id = 0;	
		$res = $this->db->where('parent_id', $parent_id)->get('category')->result_array();
		
		if($res){
			$optionArr = array();
			$optionArr[] = '';
			foreach($res as $r){
				$optionArr[$r['category_id']] = $r['cat_name'];
			}
			$catLoadClass = ($parent_id == 0) ? 'load-que' : 'load-sub-sub-category';
			echo form_dropdown('test_cat_id', $optionArr, $test_cat_id, 'class="text-input small-input '.$catLoadClass.'" ');
		}
	}
	
	function loadAllCatInput($id){
		$res = $this->db->where('category_id')->get('category');
	}
	
	function loadQue($cat_id, $selectedAueArrString = ''){
		$sql = "SELECT fis_questions.*, (SELECT cat_name FROM fis_category WHERE fis_questions.cat_id = category_id) as cat_name
				FROM `fis_questions` 
				WHERE `cat_id` IN (SELECT category_id 
								   FROM `fis_category` 
								   WHERE `category_id` = $cat_id OR `parent_id` IN (SELECT `category_id` 
																					FROM `fis_category` 
																					WHERE `parent_id` = $cat_id) 
									OR `parent_id` = $cat_id) ";

		$res = $this->db->query($sql)->result_array();
		
		$selectedAueArr = explode(',', $selectedAueArrString);
		
		$htmlCont = '';
		foreach($res as $r){
			$is_checked = (in_array($r['question_id'], $selectedAueArr)) 
								? 'checked="checked"' 
								: '';
			
			$htmlCont .= '<tr>
							<td width="1%">
								<input type="checkbox" name="test_que_ids[]" id="que_'. $r['question_id'] .'" value="'. $r['question_id'] .'" '. $is_checked .' /> 
							</td>
							<td>
								<label for="que_'. $r['question_id'] .'">
									'. $r['question_txt'] .'
								</label>	
							</td>
							<td>'.$r['cat_name'].'</td>
						  </tr>';
		}
		echo ($htmlCont != '') 
				? '<tr>
					<td></td>
					<td>
						<label>Select Questions :  
							<span style="float:right">
								<a href="javascript:;" class="view_all">View All</a> / 
								<a href="javascript:;" class="show_selected">View Selected</a>
							</span>
						</label> 
					</td>
				   </tr>'.$htmlCont 
				: '<tr><td>No Data Found</td></tr>';
										 
	}
}