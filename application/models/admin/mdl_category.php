<?php
class mdl_category extends CI_Model
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
		  $this->db->like('cat_name', $srchKey);
		}
		if($f !='' && $s != '' && check_db_column($this->dbTable, $f)) // called from commondb_helper
			$this->db->order_by($f, $s);
//		else
//			$this->db->order_by('sort_order');
		
		$response = $this->db->where('parent_id', $parent_id)
							 ->get($this->dbTable);
		
		return $response;
		
	}
	
	
}