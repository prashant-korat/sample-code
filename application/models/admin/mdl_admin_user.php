<?php
class mdl_admin_user extends CI_Model
{
/*
+----------------------------------------------------------+
	Get all data for admin users .
	@params : $table -> name of db table
	         $del_in -> 1 or 0 value change in db
			 $id -> is id of record
+----------------------------------------------------------+
*/
	function get_data($table, $del_in = 0, $id = "" )
	{
		$f = $this->input->post('f');
		$s = $this->input->post('s');
		$srchKey = trim($this->input->post('searchtxt'));
		$where ='';
		
		
		return $this->db->get($table);
		
		/*if($id == "")
		{
		  if(@$srchKey != '')
		  {
			$srchKey = mysql_escape_string($srchKey);
			$where .= " and ( username like '%".$srchKey."%' )";
		  }
		  if($f !='' && $s != '' && check_db_column($table,$f)) // called from commondb_helper
			  $od = " order by $f $s";
		  else
			  $od = " order by admin_id DESC";
		  
		  $admin_type = $this->session->userdata('admin_type');
		  if($admin_type == 'A')
			  $sql = "select * from ".$table." where del_in='$del_in' ". $where . $od;
		  else
			  $sql = "select * from ".$table." where admin_id = ".$this->session->userdata('admin_id')." AND del_in='$del_in' ". $where . $od;

		}
		else
		  $sql = "select * from ".$table." where admin_id != ".$this->session->userdata('admin_id')." AND del_in='$del_in' ORDER BY admin_id DESC";

		return $this->db->query($sql);*/
		
	}

}