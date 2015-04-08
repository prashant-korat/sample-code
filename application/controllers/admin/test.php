<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller {
	
	var $dbTable = 'test';
	var $dbTableId = 'test_id';
	var $controller = '';
	var $dataFolder = 'admin/pages/test/'; //controller view part on this path


	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/mdl_'.$this->router->class, 'mdl_file');
		
		$this->controller = $this->router->class; //current controller name
		
		$this->dataFolder = 'admin/pages/'.$this->controller.'/'; //controller view part on this path
		
		$this->mdl_file->dbTable = $this->dbTable;
		$this->mdl_file->dbTableId = $this->dbTableId;
		
	}
/*
+-----------------------------------------+
	Set Frames for put the data
+-----------------------------------------+
*/
	public function index()
	{
		$data['selectMenu'] = $this->controller; //set controller name for selected menu used in leftbar
		$data['title']      = 'Questions'; //set title on controller page
		
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
	function ajaxDataLoad($parent_id = 0, $start = 0)
	{	

		$numrows = $this->mdl_file->getData($parent_id);
		if($start == "s")
			$start = 0;
		
		$perPage = $this->input->post('perPage');
		if(!$perPage)
			$perPage = 20;	
		
		$data = $this->mdl_common->CustompagiationData('admin/'.$this->controller.'/ajaxDataLoad/'.$del_in,$numrows->num_rows(),$start, 5, $start, $perPage);

		$data['parent_id'] = $parent_id;

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
		$returnData['popupData'] = $this->load->view('admin/elements/popupData', array(), true); //popup data
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
	function addData($parent_id = 0)
	{
		$returnArr=array();

		$this->form_validation->set_rules('test_name', 'Test Name', 'trim|required');
		$this->form_validation->set_rules('test_release_on', 'Release Date-Time', 'trim|required');
		$this->form_validation->set_rules('test_cat_id', 'Select Category', 'trim|required');
		$this->form_validation->set_rules('test_timer', 'Select Category', 'trim|required');
//		$this->form_validation->set_rules('question_txt', 'Questions', 'trim|required');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$error_msg=$this->form_validation->_error_array;
			foreach($error_msg as $key=>$val){
				$returnArr['obj']=$key;		
				$returnArr['msg']=$val;		
				break;
			}
			$returnArr['is_error']=true;						
		}
		else //saved data to database
		{
			$returnArr['is_error']=false;

			$postData = array('test_name', 'test_cat_id', 'test_release_on', 'test_timer');
			
			$saveData = array();
			foreach($postData as $data)
				$saveData[$data] = $this->input->post($data);
				
			$saveData['test_que_ids'] = implode(',',$this->input->post('test_que_ids'));	
			$saveData['test_release_on'] = date('Y-m-d H:i:s', strtotime($saveData['test_release_on']));

			$recordId = $this->input->post('recordId');
			
			$que_is = saveData($recordId, $saveData, $this->dbTable, $this->dbTableId); //called from db helper
			
			foreach($_POST['ans'] as $index=>$val){
				$ansData = array();
				$ansData['question_id'] = $que_is;
				$ansData['ans_txt'] = $_POST['ans'][$index];
				$ansData['is_true'] = $_POST['is_true'][$index];
				
				saveData($_POST['ans_id'][$index], $ansData, 'answers', 'answer_id'); //called from db helper
			}
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
	function deleteData($record_id = '')
	{
		if($record_id == "") //if multiple delete
			$ids = $this->input->post('recordId');
		else
			$ids = array($record_id);

		foreach($ids as $id)
		{
			deleteData($id , $this->dbTable, $this->dbTableId); //called from db helper
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
		$data['ansData'] = $this->db->where('question_id', $recordId)->get('answers')->result_array();
		
		$returnData['htmlContent'] = $this->load->view($this->dataFolder.'tab2', $data, true);
		echo json_encode($returnData);
	}

// update sorting order 
	function updateOrder()
	{
		$dataId  = $this->input->post('row');
		$lastOrderId = minOrderId(min($dataId),max($dataId), $this->dbTable, $this->dbTableId)->row_array();

//		$dataId = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8);
		foreach($dataId as $orderId=>$recordId){
			$orderId = $orderId+$lastOrderId['sort_order'];
			updateDisplayOrder($recordId, $orderId, $this->dbTable, $this->dbTableId);
		}
	}

/*		START		FILE UPLOADING FUNCTION COMMON FOR ALL 			*/

	function ajaxUploading($folderName, $typeUpload, $fileName)
	{
		if($folderName == 'false')
		  $resultArr = $this->mdl_common->ajaxUploading('album', $typeUpload, $fileName); //controller name used to upload foldername, filetype, inputfile
		else
		  $resultArr = $this->mdl_common->ajaxUploading('album/'.$folderName, $typeUpload, $fileName); //controller name used to upload foldername, filetype, inputfile
		  
		if(is_array($resultArr))
			echo json_encode($resultArr);
		else
			echo $resultArr;
	}
	
 	function ajax_uploaded_remove($name)
	{
		$this->mdl_common->deleteUploaderImage($name, $this->dbTable, $this->dbTableId); //image link field name
	}
	
/*		END 		FILE UPLOADING FUNCTION COMMON FOR ALL 			*/
	
	
	function ajaxLoadCategory(){
		$sVal = $this->input->post('cat_id');
		
		$this->mdl_file->loadCategory($sVal);
	}
	
	function ajaxLoadQue($sVal = ''){
		if($sVal == '')
		  $sVal = $this->input->post('cat_id');
		
		$this->mdl_file->loadQue($sVal);
	}
}