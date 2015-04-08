<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service extends CI_Controller {
	
	var $data = array();
	
	function service()
	{
		parent::__construct();
		$this->load->model('v1/mdl_service', 'mdl_file');
		
		if($this->input->is_ajax_request()){
			$this->data = $this->input->post();
		}else{
			$postData = file_get_contents('php://input');
			
			$this->data = json_decode($postData, true);
		}

		$this->mdl_file->data = $this->data;
	}
	
	function test(){
		$this->load->view('v1/test');
	}
	
	function userLogin(){
		$data = $this->data;
		
		$req_data = array('email');
		$validation = $this->ParamValidation($req_data, $data);
		
		$userData = $this->mdl_file->userLogin();
		
		if($userData){
			$flag = true;
			$msg = 'user login successfully';
			$returnData = $userData;
		}else{
			$flag = false;
			$msg = 'invalid user authentication';
			$returnData = array();
		}
		
		$this->returnArr($flag, $msg, $returnData);
	}
	
	function userReg(){
		//`student_id`, `fname`, `lname`, `email`, `password`, `fb_id`, `secure_key`, `is_active`, `created_on` 
		$data = $this->data;
		
		$req_data = array('fname','lname','email','password');
		$validation = $this->ParamValidation($req_data, $data);
		
		$userData = formData($data['email'], 'student', 'email');
		
		if($userData){
			$this->returnArr(false, 'email already registered');
		}else{
			$saveData = array();
			foreach($req_data as $f){
				$saveData[$f] = $data[$f];
			}
			$saveData['password'] = md5($data['password']);
			
			$last_id = saveData('', $saveData, 'student', 'student_id');
			
			$this->returnArr(true, 'user successfully created');
		}
	}
	
	function getAllTest(){
		$res = $this->db->get('test')->result_array();
		
		if($res)
			$this->returnArr(true, 'all test are loaded.', $res);
		else
			$this->returnArr(false, 'test data not found.');
	}
	
	function getTestQue(){
		$data = $this->data;

		$req_data = array('test_id');
		$validation = $this->ParamValidation($req_data, $data);
		
		$resQueData = formData($data['test_id'], 'test', 'test_id');

		$queAnsData = array();
		if($resQueData && $resQueData['test_que_ids']){
			$sql = 'SELECT * FROM `fis_questions` WHERE `question_id` IN ('.$resQueData['test_que_ids'].')';
			
			$questions = $this->db->query($sql)->result_array();
			
			if($questions){
				$queAnsData['test_info'] = $resQueData;
				
				foreach($questions as $key=>$que){
					$queAnsData[$key]['que'] = $que;
					//SELECT `answer_id`, `question_id`, `ans_txt`, `is_true` FROM `fis_answers` WHERE 1
					$queAnsData[$key]['ans'] = $this->db->select('answer_id, ans_txt, is_true')->where('question_id', $que['question_id'])->get('answers')->result_array();
				}
			}
		}
		
		if( $queAnsData ){
			$this->returnArr(true, 'question sets found', $queAnsData);
		}else{
			$this->returnArr(true, 'question sets not found');
		}
	}
	
	function saveUserAns(){
		$data = $this->data;
		
		$req_data = array('test_id', 'user_id', 'ans_arr'); // 'attempt_id'
		$validation = $this->ParamValidation($req_data, $data);
		
		if($data['attempt_id']){
		}else{
			
		}
	}
	
	// prepare return data format
	function returnArr($flag = false, $msg = '', $data = array()){
		$returnArr = array();
		$returnArr['success'] = $flag;
		$returnArr['msg'] = $msg;
		if($data)
		  $returnArr['data'] = $data;
		
		echo json_encode($returnArr);
		die;
	}
	
	// validation for param which are req in function 
	function ParamValidation($paramarray,$data)
	{
		$NovalueParam='';
		foreach($paramarray as $val)
		{
			if(!array_key_exists($val,$data))
			{				
				$NovalueParam[]=$val;
			}
		}
		if(is_array($NovalueParam) && count($NovalueParam)>0)
		{
			$msg = 'Sorry, that is not valid input. You missed '.implode(',',$NovalueParam).' parameters';
			$this->returnArr(false, $msg);
		}
		else
		{
			return false;
		}
	}

}