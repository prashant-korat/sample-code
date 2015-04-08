<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_user extends CI_Controller {
	
	var $dbTable = 'admins';
	var $dbTableId = 'admin_id';
	var $controller = '';
	var $dataFolder = 'admin/pages/admin_user/'; //controller view part on this path


	function admin_user()
	{
		parent::__construct();
		$this->load->model('admin/mdl_admin_user');
		$this->controller = $this->router->class; //current controller name
	}
/*
+-----------------------------------------+
	Set Frames for put the data
+-----------------------------------------+
*/
	public function index()
	{
		$data['selectMenu'] = 'admin_user'; //set controller name for selected menu used in leftbar
		$data['title']      = 'Admin User'; //set title on controller page

		$this->load->view('admin/elements/header',$data);
		$this->load->view('admin/elements/sidebar');
		$this->load->view('admin/elements/ajax_load_data',$data);
		$this->load->view($this->dataFolder.'page_js');
		$this->load->view('admin/elements/footer');
		
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
		$numrows = $this->mdl_admin_user->get_data($this->dbTable, $del_in);
		if($start == "s")
			$start = 0;
		
		$perPage = $this->input->post('perPage');
		if(!$perPage)
			$perPage = 20;	
		
		$data = $this->mdl_common->CustompagiationData('admin/'.$this->controller.'/ajaxDataLoad/'.$del_in,$numrows->num_rows(),$start, 5, $start, $perPage);
		$data['del_in'] = $del_in;

		$data['sort'] = $this->input->post('s'); //sorting
		$data['field'] = $this->input->post('f'); //name of table field
		if(!$data['sort'])
			$data['sort'] = 'ASC';
		
		$returnData = array();
		
		$returnData['deleteDataURL'] = site_url('admin/'.$this->controller.'/deleteData/'); //link for delete data
		$returnData['searchURL']    = site_url('admin/'.$this->controller.'/ajaxDataLoad/'.$del_in); //link for search url data
		$returnData['ajaxFormData']    = site_url('admin/'.$this->controller.'/ajaxFormData'); //link for edit form data

		$returnData['tbody'] = $this->load->view($this->dataFolder.'tbody', $data, true); //tr td records view
		$returnData['thead'] = $this->load->view($this->dataFolder.'thead', array(), true); //column header view
		$returnData['links'] = $data['listArr']['links']; //pagination link
		$returnData['popupData'] = $this->load->view($this->dataFolder.'popupData', array(), true); //popup data
		$returnData['tab_holder'] = $this->load->view($this->dataFolder.'tab_holder', array(), true); //tab link
		$returnData['tab2'] = $this->load->view($this->dataFolder.'tab2', array(), true); //form tab
		
//		$this->load->view('admin/ajaxPages/ajax_admin_user',$data);

		echo json_encode($returnData);		
	}
/*
+-----------------------------------------+
	Function will save data, all parameters 
	will be in post method.
+-----------------------------------------+
*/	
	function addData()
	{
		$returnArr=array();

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		if($this->input->post('admin_id') == '' || $this->input->post('password') != '')
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('re_psd', 'Re-enter Password', 'trim|required|matches[password]');
		}
		
		if($this->form_validation->run() == FALSE)
		{
			$error_msg=$this->form_validation->_error_array;
			foreach($error_msg as $key=>$val)
			{
				$returnArr['obj']=$key;		
				$returnArr['msg']=$val;		
				break;
			}
			$returnArr['is_error']=true;						
		}
		else //saving data to database
		{
			$returnArr['is_error']=false;
			
			$id = $this->input->post('admin_id');
			$data['username'] = $this->input->post('username');
			if($this->input->post('password') != ''){
				if($this->input->post('admin_type') == 'A')
					$data['password'] = md5($this->input->post('password').$this->config->item('encryption_key'));
				else	 
					$data['password'] = ($this->input->post('password'));
			}
				
					
			saveData($id, $data, $this->dbTable, $this->dbTableId); //called from db helper
		}
		
		echo json_encode($returnArr);
	}
/*
+-----------------------------------------+
	This function will Delete Single and Multiple Data
	@params : $flag -> is data for change in db table
			  $record_id -> Id OR post array of ids
+-----------------------------------------+
*/		
	function deleteData($flag = '', $record_id = '')
	{
		if($flag==1)
			$flag = 0;
		else	
			$flag = 1;

		if($record_id == "") //if multiple delete
			$ids = $this->input->post('recordId');
		else
			$ids = array($record_id);

		foreach($ids as $id)
		{
			deleteData($id , $flag, $this->dbTable, $this->dbTableId); //called from db helper
		}
	}
/*
+-----------------------------------------+
	Function will Edit form in fill the data.
+-----------------------------------------+
*/	
	function ajaxFormData()
	{
		$recordId = $this->input->post('recordId');
		
		$data = formData($recordId , $this->dbTable, $this->dbTableId);	//called from db helper
		
		$returnData['htmlContent'] = $this->load->view($this->dataFolder.'tab2', $data, true);
		echo json_encode($returnData);
	}

}