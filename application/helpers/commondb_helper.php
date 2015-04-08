<?php
/*
+-----------------------------------------+
	This Function will Save and Update data.
	@params : $id -> get id
	          $data -> array of data
			  $table -> table name
			  $tableId -> table field name
+-----------------------------------------+
*/
function saveData($id ='', $data, $table, $tableId)
{
	$CI =& get_instance();
	if($id == "")
	{
		$CI->db->insert($table,$data);
		$insert_id = $CI->db->insert_id();
		
		if(check_db_column($table, 'sort_order')){
			$temp['sort_order']=$insert_id;
			saveData($insert_id,$temp,$table,$tableId);
		}
		return $insert_id;
	}
	else
	{
		$CI->db->where($tableId,$id);
		$CI->db->update($table,$data);
		
		return $id;
	}
}

/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++
	This function will check column exist in database 
	or not? if column exist then return true otherwise
	return false.
	
	@params : $table_name -> name of the table
			  $column_name -> Column name you want to 
			  					check in table.
	@return : TRUE OR FALSE
+++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

function check_db_column($table_name,$column_name)
{
	$CI = & get_instance();
	
	$sql = "SELECT * 
	FROM information_schema.COLUMNS 
	WHERE 
		TABLE_SCHEMA = '".$CI->db->database."' 
	AND TABLE_NAME = 'l_".$table_name."' 
	AND COLUMN_NAME = '".$column_name."'";
	
	$rows = $CI->db->query($sql)->num_rows();

	if($rows > 0)
		return true;
	else
		return false;
}

/*
+-----------------------------------------+
	This Function will Delete data.
	@params : $id -> get id
	          $del_in -> 1 or 0 value change in db for delete purpose
			  $table -> table name
			  $tableId -> table field name
+-----------------------------------------+
*/
function deleteData($id, $table, $tableId)
{
	$CI =& get_instance();

	$CI->db->where($tableId,$id);
	$CI->db->delete($table);
}

/*
+-----------------------------------------+
	This Function will Edit form data.
	@params : $id -> get id
			  $table -> table name
			  $tableId -> table field name
+-----------------------------------------+
*/
function formData($id, $table, $tableId)
{
	$CI =& get_instance();
	$CI->db->where($tableId, $id);
	return $CI->db->get($table)->row_array();
}

/*
+-----------------------------------------+
	This Function will return for find minimum ordering data.
	@params : $start_id -> start row id
	          $end_id -> end row id
			  $table -> table name
			  $tableId -> table field name
+-----------------------------------------+
*/
function minOrderId($start_id, $end_id, $table, $tableId)
{
	$CI =& get_instance();
	
	return $CI->db->select_min('sort_order')->where("$tableId BETWEEN $start_id AND $end_id")->get($table);
}

/*
+-----------------------------------------+
	This Function will return for update ordering data.
	@params : $recordId -> field row id
	          $order -> order id
			  $table -> table name
			  $tableId -> table field name
+-----------------------------------------+
*/
function updateDisplayOrder($recordId, $order, $table, $tableId)
{
	$CI =& get_instance();
	return 	$CI->db->where(array('del_in'=>0, $tableId=>$recordId))->update($table, array('sort_order'=>$order));
}

/*
+-----------------------------------------+
	This Function will return for check field data.
	@params : $whereData -> condition field name
			  $dbTable -> table name
+-----------------------------------------+
*/
function checkField($whereData, $dbTable)
{
	$CI =& get_instance();
	if($whereData)
		$CI->db->where($whereData);
	return $CI->db->get($dbTable);
}

/*
+-----------------------------------------+
	This Function will return for config value.
	@params : $keyWord -> config keyword
		      $dbTable -> table name
+-----------------------------------------+
*/
function getConfig($keyWord,$dbTable)
{
	$C =& get_instance();
	$C->db->select('config_value');
	$C->db->where('config_keyword',$keyWord);
	$response = $C->db->get($dbTable)->row_array();
	return $response['config_value'];
}

/*
+------------------------------------------------------------------+
	Function will be use for single field value. 
Input ->
	@params-> $field : Name of field you want to fetch.
			  $table : Name of table
			  $wh : Where condition field name 
			  $cond : condition operator value.
+------------------------------------------------------------------+
*/
function getField($field,$table,$wh ='',$cond='')
{
	$CI = & get_instance();
	
	$CI->db->select($field,FALSE);
	if($wh && $cond)
		$CI->db->where($wh,$cond);
		
	$res = $CI->db->get($table);	
	
	//if we want some aggreagration then we pass field name in $wh
	$result =$res->row_array();
	unset($CI);
	//echo $result['new_order'];die;
	return $result[$field];
}


/*
+------------------------------------------------------------------+
	Function will be use for listing all value. 
	@params-> $table : Name of table
+------------------------------------------------------------------+
*/
function getDbTableData($table)
{
	$CI =& get_instance();
	$CI->db->where('del_in',0);
	return $CI->db->get($table)->result_array();
}

/*
+------------------------------------------------------------------+
	Function will be use for generate random string. 
	@params-> $table : Name of table
+------------------------------------------------------------------+
*/
function get_random_string($table,$field_code)
{
    // Create a random user id
    $random_unique = random_string('alnum', 6);

    // Make sure the random user_id isn't already in use
    $CI = get_instance();
    $CI->db->where($field_code, $random_unique);
    $query = $CI->db->get_where($table);
	
    if ($query->num_rows() > 0)
    {
        // If the random user_id is already in use, get a new number
        $this->get_random_string();
    }

    return $random_unique;
} 
?>