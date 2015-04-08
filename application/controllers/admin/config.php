<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {
	
	var $dbTable = 'l_config';
	var $dbTableId = 'config_id';
	var $controller = '';
	var $dataFolder = 'admin/pages/config/';  //controller view part on this path


	function Config()
	{
		parent::__construct();
		$this->load->model('admin/mdl_config','mdl_file');
		$this->controller = $this->router->class;
	}
/*
+-----------------------------------------+
	Set Frames for put the data
+-----------------------------------------+
*/	
	public function index()
	{
		$data['selectMenu'] = 'config';  //set controller name for selected menu used in leftbar
		$data['title']      = 'Manage Configuration'; //set title on controller page

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
		$numrows = $this->mdl_file->get_data($this->dbTable, $this->dbTableId, $del_in);
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

		$this->form_validation->set_rules('config_name', 'Config Name', 'required');
		$this->form_validation->set_rules('config_value', 'Config Value', 'required');
		
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
		else //saved data to database
		{
			$returnArr['is_error']=false;
			
			$id = $this->input->post('config_id');
			$data['config_name'] = $this->input->post('config_name');
			$data['config_value'] = $this->input->post('config_value');
			
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
		
		$data = formData($recordId , $this->dbTable, $this->dbTableId);	 //called from db helper
		
		$returnData['htmlContent'] = $this->load->view($this->dataFolder.'tab2', $data, true);
		
		echo json_encode($returnData);
	}

}