<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlist extends CI_Controller {
	
	var $dbTable = 'student';
	var $dbTableId = 'student_id';
	var $controller = '';
	var $dataFolder = 'admin/pages/userlist/'; //controller view part on this path
	//SELECT `student_id`, `fname`, `lname`, `email`, `password`, `fb_id`, `secure_key`, `is_active`, `created_on` FROM `fis_student` WHERE 1
	var $fieldArr = array('fname', 'lname', 'email', 'password');

	
	function Userlist()
	{
		parent::__construct();
		$this->load->model('admin/mdl_userlist');
		$this->controller = $this->router->class;
	}
/*
+-----------------------------------------+
	Set Frames for put the data
+-----------------------------------------+
*/
	public function index()
	{
		$count = $this->db->get('student')->result_array();
		$data['selectMenu'] = 'userlist'; //set controller name for selected menu used in leftbar
		$data['title'] = 'Student count : '.count($count); //set title on controller page

		$extraData['title'] = 'Archived Userlist'; //set archived box title
		$extraData['extraClass'] = 'extraId'; //when used archived data. DONT CHANGE IT..
		
		
		$this->load->view('admin/elements/header',$data);
		$this->load->view('admin/elements/sidebar');
		$this->load->view('admin/elements/ajax_load_data',$data);
//		$this->load->view('admin/elements/ajax_load_data',$extraData);
		$this->load->view($this->dataFolder.'page_js');
		$this->load->view('admin/elements/footer');
	}
/*
+-----------------------------------------+
	This function will Delete Single and Multiple Data
	@params : $flag -> is data for change in db table
			  $record_id -> Id OR post array of ids
+-----------------------------------------+
*/	
	function deleteData($user_id = '')
	{
		if($user_id) //if multiple delete
			$resid = array($user_id);
		else
			$resid = $this->input->post('recordId');

		foreach($resid as $res_id)
		{
			deleteData($res_id, $this->dbTable, $this->dbTableId); //called from db helper
		}
	}
/*
+-----------------------------------------+
	Function will save data, all parameters 
	will be in post method.
+-----------------------------------------+
*/		
	function addData()
	{
		$postData = array();
		foreach($this->fieldArr as $post)
		{
			if($post == 'password')
			{
				if($this->input->post($post))
				{
					$postData[$post] = md5(trim($this->input->post($post)));
				}
			}else{
				$postData[$post] = trim($this->input->post($post));
			}
			
		}
		
		$postData['is_active'] = 1;
		
		$id = $this->input->post('record_id');

		saveData($id, $postData, $this->dbTable, $this->dbTableId); //called from db helper
	}
/*
+-----------------------------------------+
	Function will Edit form in fill the data.
+-----------------------------------------+
*/	
	function ajaxFormData()
	{
		$recordId = $this->input->post('recordId');
		
		$data = formData($recordId , $this->dbTable, $this->dbTableId); //called from db helper
		
		echo json_encode($data);
	}

/*
+-----------------------------------------+
	This Function will Ajax through Load the data
	and put data on the view page
	@params : $del_in = is data for change in db table
+-----------------------------------------+
*/	
	function ajaxDataLoad($del_in = 0, $start = 0)
	{
		$numrows = $this->mdl_userlist->getData($del_in , $this->dbTable, $this->dbTableId);

		if($start == "s")
			$start = 0;
		
		$perPage = $this->input->post('perPage');
		if(!$perPage)
			$perPage = 20;	
		
		$data = $this->mdl_common->CustompagiationData('admin/userlist/ajaxDataLoad/'.$del_in,$numrows->num_rows(),$start, 5, $start, $perPage);
		$data['del_in'] = $del_in;

		$data['sort'] = $this->input->post('s');
		$data['field'] = $this->input->post('f');
		if(!$data['sort'])
			$data['sort'] = 'ASC';


		$returnData = array();

		$returnData['deleteDataURL'] = site_url('admin/'.$this->controller.'/deleteData/'); //link for delete data
		$returnData['searchURL']    = site_url('admin/'.$this->controller.'/ajaxDataLoad/'.$del_in); //link for search url data
		$returnData['ajaxFormData']    = site_url('admin/'.$this->controller.'/ajaxFormData'); //link for edit form data

		$returnData['tbody'] = $this->load->view($this->dataFolder.'tbody', $data, true); //tr td records view
		$returnData['thead'] = $this->load->view($this->dataFolder.'thead', array(), true); //column header view
		$returnData['links'] = $data['listArr']['links']; //pagination link
		$returnData['popupData'] = $this->load->view('admin/elements/popupData', array(), true); //put data on the popup box
		//$returnData['tab_holder'] = $this->load->view($this->dataFolder.'tab_holder', array(), true);
		//$returnData['tab2'] = $this->load->view($this->dataFolder.'tab2', array(), true);
		
		echo json_encode($returnData);		
	}
/*
+-----------------------------------------+
	This function will users information
	view in popup box.
	@params : $uId -> is id of record
+-----------------------------------------+
*/	
	function ajaxUsersView($uId='')
	{
		$data['viewInfo'] = formData($uId , $this->dbTable, $this->dbTableId); //called from db helper
							
		$data['htmlContent'] = $this->load->view($this->dataFolder.'popupHtmlData', $data, true); //$htmlContent;
		
		echo json_encode($data);
	}
/*
+-----------------------------------------+
	This Function will Check the user is verify
	@params : recordId -> is id of record
	          flag -> 1 or 0 value change in db
+-----------------------------------------+
*/	
	function verifyUser($recordId, $flag)
	{
		$data['is_active'] = $flag;
		saveData($recordId, $data, $this->dbTable, $this->dbTableId);
	}
/*
+-----------------------------------------+
	This Function will Users information 
	downloaded and create xls file.
+-----------------------------------------+
*/	
	function downloadXLS()
	{
		$res = $this->db->select('firstname, email')->where('del_in','0')->get($this->dbTable);
		
		$listArr = $res->result_array();
		$col= array('Name','Email');
		
		$this->mdl_common->exportExcel("Users".date('m-d-Y').".xls",$col,$listArr);
		die;
	}
}