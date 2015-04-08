<?php
class mdl_userlist extends CI_Model
{
/*
+----------------------------------------------------------+
	Get all data for users information.
	@params : $dbTable -> name of db table
			  $dbTableId -> name of db table field
	          $del_in -> 1 or 0 value change in db
+----------------------------------------------------------+
*/
	function getData($del_in = 0, $dbTable, $dbTableId )
	{
		$f = $this->input->post('f');
		$s = $this->input->post('s');
		$srchKey = trim($this->input->post('searchtxt'));
//SELECT `student_id`, `fname`, `lname`, `email`, `password`, `fb_id`, `secure_key`, `is_active`, `created_on` FROM `fis_student` WHERE 1
		if(@$srchKey != '') //if search text
		{
		  $srchKey = mysql_escape_string($srchKey);
		  $this->db->where("(fname like '%".$srchKey."%' OR lname like '%".$srchKey."%' OR email like '%".$srchKey."%')");
		}

		if($f !='' && $s != '' && check_db_column($dbTable, $f)) // called from commondb_helper
			$this->db->order_by($f, $s);
		else
			$this->db->order_by($dbTableId, 'DESC');
		
		return $this->db->get($dbTable);
		
	}
	
	
}