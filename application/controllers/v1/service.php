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
			$this->returnArr(false, 'email already registered', $userData);
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
		$data = $this->data;

		$req_data = array('user_id', 'cat_id');
		$validation = $this->ParamValidation($req_data, $data);

		$sql = 'SELECT fis_test.*, (SELECT count(*) 
									FROM `fis_user_attempt` 
									WHERE fis_user_attempt.`test_id` = fis_test.test_id AND 
										 `user_id` = '.$data['user_id'].') as attempted 
				FROM `fis_test` 
				WHERE test_cat_id = '.$data['cat_id'];
		
				
		//$res = $this->db->get('test')->result_array();
		$res = $this->db->query($sql)->result_array();
		
		if($res)
			$this->returnArr(true, 'all test are loaded.', $res);
		else
			$this->returnArr(false, 'test data not found.');
	}
	
	function getTestQue(){
		$data = $this->data;

		$req_data = array('test_id', 'user_id');
		$validation = $this->ParamValidation($req_data, $data);
		
		$resQueData = formData($data['test_id'], 'test', 'test_id');
		
		$attmptSql = 'SELECT *
					  FROM `fis_user_attempt` 
					  WHERE `user_id` = '.$data['user_id'].' AND 
							`test_id` = '.$data['test_id'];  
		
		$testAttemptData = $this->db->query($attmptSql)->row_array();
		$user_attempt_id = 0;
		
		if($testAttemptData){
			$user_attempt_id = $testAttemptData['user_attempt_id'];
			$attmptSql = 'SELECT * 
						  FROM `fis_attempt_ans` 
						  WHERE `attempt_id` = '.$testAttemptData['user_attempt_id'];
			
//			saveData($user_attempt_id, array('attempt_count' => $testAttemptData['attempt_count']+1), 'user_attempt', 'user_attempt_id');
//			$testAttemptAnsData = $this->db->query($attmptSql)->result_array();
			
//			echo '<pre>';print_r($testAttemptAnsData);echo '</pre>';
		}

		$queAnsData = array();
		if($resQueData && $resQueData['test_que_ids']){
			$sql = 'SELECT * FROM `fis_questions` WHERE `question_id` IN ('.$resQueData['test_que_ids'].') ORDER BY rand() ';
			
			$questions = $this->db->query($sql)->result_array();
			
			if($questions){
				$queAnsData['test_info'] = $resQueData;
				
				foreach($questions as $key=>$que){
					$queAnsData[$key]['que'] = $que;
					//SELECT `answer_id`, `question_id`, `ans_txt`, `is_true` FROM `fis_answers` WHERE 1
					$queAnsData[$key]['ans'] = $this->db->select('fis_answers.answer_id, fis_answers.ans_txt, fis_answers.is_true, (SELECT COUNT(*) FROM `fis_attempt_ans` WHERE `attempt_id` = '.$user_attempt_id.' AND `que_id` = '.$que['question_id'].' AND `ans_id` =  fis_answers.answer_id) as is_user_selected')
														->where('question_id', $que['question_id'])
														->get('answers')
														->result_array();
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
/*
		$data = array();
		$data['test_id'] = 9;
		$data['user_id'] = 2;
		$data['ans_arr'][15] = 56;
		$data['ans_arr'][16] = 11;
		$data['ans_arr'][17] = 20;
*/
		
		$req_data = array('test_id', 'user_id', 'ans_arr'); // 'attempt_id'
		$validation = $this->ParamValidation($req_data, $data);

//SELECT `user_attempt_id`, `user_id`, `test_id`, `created_on` FROM `fis_user_attempt` WHERE 1

		// user attempt test data save.
		$saveData = array();
		$saveData['user_id'] = $data['user_id'];
		$saveData['test_id'] = $data['test_id'];
		
		$user_attempt = $this->db->where( $saveData )->get('user_attempt')->row_array();
		
		$user_attempt_id = ($user_attempt) ? $user_attempt['user_attempt_id'] : '';
		$saveData['attempt_count'] = ($user_attempt) ? $user_attempt['attempt_count']+1 : 1 ;
		
		$attempt_id = saveData($user_attempt_id, $saveData, 'user_attempt', 'user_attempt_id');
		
		$trueAnsCount = 0;
		$falseAnsCount = 0;
		$ansIdsArr = array();
		if($attempt_id){
			//SELECT `attempt_ans_id`, `attempt_id`, `que_id`, `ans_id` FROM `fis_attempt_ans` WHERE 1

			$data['ans_arr'] = json_decode($data['ans_arr'],true);
			foreach($data['ans_arr'] as $que_id=>$ans_id){
				$ansIdsArr[] = $ans_id;
				$saveData = array();
				$saveData['attempt_id'] = $attempt_id;
				$saveData['que_id'] = $que_id;
				
				$attempt_ans = $this->db->where( $saveData )->get( 'attempt_ans' )->row_array();
				$attempt_ans_id = ($attempt_ans) ? $attempt_ans['attempt_ans_id'] :'';
				
				$saveData['ans_id'] = $ans_id;
				
				saveData($attempt_ans_id, $saveData, 'attempt_ans', 'attempt_ans_id');
				
				$whereData = array();
//				$whereData['question_id'] = $que_id;
				$whereData['answer_id'] = $ans_id;
				$whereData['is_true'] = 1;
				$getTrueAnsData = $this->db->where($whereData)->get('answers')->row_array();
				
				if($getTrueAnsData) $trueAnsCount++; else $falseAnsCount++;
				
			};
		}

		$testInfo = formData($data['test_id'], 'test', 'test_id');
		
		$returnData = array();
		$returnData['trueAnsCount'] = $trueAnsCount;
		$returnData['falseAnsCount'] = $falseAnsCount;
		$returnData['userScore'] = ($trueAnsCount * $testInfo['test_point_if_ans_true']) - ($falseAnsCount * $testInfo['test_point_if_ans_false']);
		
		if($ansIdsArr){
			$sql = "SELECT FC.cat_name, FA.is_true, FQ.question_id, FC.category_id
					FROM fis_category AS FC
						LEFT JOIN fis_questions AS FQ ON FQ.cat_id = FC.category_id
					LEFT JOIN fis_answers AS FA ON FQ.question_id = FA.question_id
					WHERE FA.answer_id IN (".implode(',', $ansIdsArr).")
					GROUP BY FC.category_id";
					
			$getAnlayticData = $this->db->query($sql)->result_array();		
		

			foreach($getAnlayticData as $d){
				$tempArr = array();
				$tempArr['category_name'] = $d['cat_name'];
				$sql = "SELECT count(*) AS resCount
						FROM fis_category AS FC
							LEFT JOIN fis_questions AS FQ ON FQ.cat_id = FC.category_id
							LEFT JOIN fis_answers AS FA ON FQ.question_id = FA.question_id
						WHERE FA.answer_id IN (".implode(',', $ansIdsArr).") AND FC.category_id = $d[category_id] ";
							  
				$total = $this->db->query($sql)->row_array();			  
				$tempArr['total'] = $total['resCount'];
				
				$sql .= " AND FA.is_true = 1";
				$total = $this->db->query($sql)->row_array();			  
				$tempArr['successTotal'] = $total['resCount'];

				$returnData['analyticalData'][] = $tempArr;
			}
		}
		
		$this->returnArr(true, 'data saved successfully', $returnData);
	}
	
	function materialsList(){
		$res = $this->db->get('materials')->result_array();
		
		if($res){
			$this->returnArr(true, 'material list found', $res);
		}else{
			$this->returnArr(false, 'material list not found');
		}
	}
	
	function materialsGetDetail(){
		$data = $this->data;

		$req_data = array('material_id');
		$validation = $this->ParamValidation($req_data, $data);
		
		$res = formData($data['material_id'], 'materials', 'material_id');
		
		if($res){
			$this->returnArr(true, 'material list found', $res);
		}else{
			$this->returnArr(false, 'material list not found');
		}
	}
	
	function discussionList(){
		$data = $this->data;
		$req_data = array('parent_id', 'user_id');
		$validation = $this->ParamValidation($req_data, $data);

		$discussionList = array();		
		if($data['cat_id'])
			$this->db->where('cat_id', $data['cat_id']);
		$select = "fis_discussion.*, (SELECT count(*) 
									  FROM `fis_discussionreview` 
									  WHERE fis_discussionreview.`discussion_id` = fis_discussion.discussion_id AND 
									  		fis_discussionreview.`type` = 1) AS likea, 
									 (SELECT count(*) 
									  FROM `fis_discussionreview` 
									  WHERE fis_discussionreview.`discussion_id` = fis_discussion.discussion_id AND 
									  		fis_discussionreview.`type` = 0) AS dislike,
									 (SELECT count(*) 
									  FROM `fis_discussionreview` 
									  WHERE fis_discussionreview.`discussion_id` = fis_discussion.discussion_id AND 
									  		fis_discussionreview.`type` = 1 AND
											fis_discussionreview.user_id = $data[user_id]) AS userlike, 
									 (SELECT count(*) 
									  FROM `fis_discussionreview` 
									  WHERE fis_discussionreview.`discussion_id` = fis_discussion.discussion_id AND 
									  		fis_discussionreview.`type` = 0 AND
											fis_discussionreview.user_id = $data[user_id]) AS userdislike,
									 fis_student.fname, fis_student.lname";
									 
		
		if($data['parent_id']){
			$this->db->select($select);
			$this->db->join('fis_student', 'student_id = fis_discussion.user_id', 'LEFT');									 
			$discussionList['que'] = $this->db->where('fis_discussion.discussion_id', $data['parent_id'])->get('discussion')->row_array();
			
			$this->db->select($select);
			$this->db->join('fis_student', 'student_id = fis_discussion.user_id', 'LEFT');									 
			$discussionList['ans'] = $this->db->where('fis_discussion.parent_id', $data['parent_id'])->get('discussion')->result_array();
		}else{
			$this->db->select($select);
			$this->db->join('fis_student', 'student_id = fis_discussion.user_id', 'LEFT');									 
			$discussionList['que'] = $this->db->where('fis_discussion.parent_id', $data['parent_id'])->get('discussion')->result_array();
		}
		$this->returnArr(true, 'discussion data found.', $discussionList);
	}
	
	function discussionSave(){
		$data = $this->data;
		//SELECT `discussion_id`, `parent_id`, `user_id`, `discussion_text`, `created_on` FROM `fis_discussion` WHERE 1
		$req_data = array('discussion_id', 'cat_id', 'parent_id', 'user_id', 'discussion_text');
		$validation = $this->ParamValidation($req_data, $data);
		
		$saveData = array();
		foreach($req_data as $f){
			$saveData[$f] = $data[$f];
		}
		date_default_timezone_set('Asia/Kolkata');
		$saveData['created_on'] = date('Y-m-d H:i:s');
		unset($saveData['discussion_id']);
		saveData($data['discussion_id'], $saveData, 'discussion', 'discussion_id');
		
		$this->returnArr(true, 'discussion saved successfully');
	}

	
	function discussionReview(){
		$data = $this->data;

		$req_data = array('discussion_id', 'user_id', 'type');
		$validation = $this->ParamValidation($req_data, $data);
		
		$whereData = $data;
		unset($whereData['type']);
		
		$res = $this->db->where($whereData)->get('discussionreview')->row_array();
		if($res){
			$this->db->where($whereData)->delete('discussionreview');
			$returnMsg = 'reviewed removed';
		}
		if($res['type'] != $data['type']){
			$saveData = $data;
			$this->db->insert('discussionreview', $saveData);
		}
		$returnMsg = 'review submitted';
		
		$this->returnArr(true, $returnMsg);		
	}
	
	function discussionDelete(){
		$data = $this->data;

		$req_data = array('discussion_id');
		$validation = $this->ParamValidation($req_data, $data);
		
		$this->db->where('discussion_id', $data['discussion_id'])->delete('discussion');
		$this->db->where('parent_id', $data['discussion_id'])->delete('discussion');		
		$this->db->where('discussion_id', $data['discussion_id'])->delete('discussionreview');		
		
		$this->returnArr(true, 'discussion deleted');
	}
	
	function getCategory(){
		//SELECT `category_id`, `parent_id`, `cat_name` FROM `fis_category` WHERE 1
		$res = $this->db->where('parent_id', 0)->get('category')->result_array();
		
		if($res)
			$this->returnArr(true, 'category data found', $res);
		else
			$this->returnArr(false, 'category data not found');
	}
	
	function newsList(){
		
		$res = $this->db->get('news')->result_array();
		
		if($res){
			$this->returnArr(true, 'news data found', $res);
		}else{
			$this->returnArr(false, 'news data not found');
		}
	}
	
	function newsView(){
		$data = $this->data;

		$req_data = array('news_id');
		$validation = $this->ParamValidation($req_data, $data);
		
		$res = $this->db->where('news_id', $data['news_id'])->get('news')->row_array();
		
		if($res){
			$this->returnArr(true, 'news info found', $res);
		}else{
			$this->returnArr(false, 'news info not found');
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