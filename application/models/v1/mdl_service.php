<?php
class mdl_service extends CI_Model
{
	var $data = array();
	// SELECT `student_id`, `fname`, `lname`, `email`, `password`, `fb_id`, `secure_key`, `is_active`, `created_on` FROM `fis_student` WHERE 1
	function userLogin(){
		$data = $this->data;

		if($data['fb_id']){
			// when user login with facebook 
			// new user created
			return $this->userCreate();
		}else{
			// user enter their email and password 
			$userData = $this->db->where('email', $data['email'])
								 ->where('password', md5($data['password']))
								 ->get('student')
								 ->row_array();
			
			if($userData)					 
				return $userData;
		}
		
	}
	
	function userCreate(){
		$data = $this->data;
/*		$resUeerData = $this->db->where('email = "'.$data['email'].'" OR fb_id = "'.$data['fb_id'].'" ')
								->get('student')
								->row_array();
*/								
		$resUeerData = $this->db->or_where('email', $data['email'])
								->or_where('fb_id', $data['fb_id'])
								->get('student')
								->row_array();
								
		$saveData = array();
		$allowField = array('fname', 'lname', 'email', 'fb_id');
		
		foreach($allowField as $f){
			$saveData[$f] = $data[$f];
		}
		
		$saveData['password'] = '';

		$last_id = saveData($resUeerData['student_id'], $saveData, 'student', 'student_id');
		
		$saveData['student_id'] = $last_id;
		return $saveData;
	}
	
	function checkUser(){
		
	}
}