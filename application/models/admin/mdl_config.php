<?php
class mdl_config extends CI_Model
{
/*
+----------------------------------------------------------+
	Get all data for config information .
	@params : $table -> name of db table
			 $tableId -> name of db table field
	         $del_in -> 1 or 0 value change in db
			 $id -> is id of record
+----------------------------------------------------------+
*/
	function get_data($table, $tableId, $del_in = 0, $id = "" )
	{
		$f = $this->input->post('f');
		$s = $this->input->post('s');
		$srchKey = trim($this->input->post('searchtxt'));
		$where ='';
		if($id == "")
		{
		  if(@$srchKey != '')
		  {
			$srchKey = mysql_escape_string($srchKey);
			$where .= " and ( config_name like '%".$srchKey."%' )";
		  }
		  if($f !='' && $s != '' && check_db_column($table,$f)) // called from commondb_helper
			  $od = " order by $f $s";
		  else
			  $od = " order by ".$tableId." DESC";
		  
		  $sql = "select * from ".$table." where del_in='$del_in' ". $where . $od;

		}
		else
		  $sql = "select * from ".$table." where ".$tableId."=".$id." AND del_in='$del_in' ORDER BY ".$tableId." DESC";

		return $this->db->query($sql);
		
	}

}