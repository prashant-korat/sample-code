<?php
class Mdl_common extends CI_Model
{
	function checkAdminSession()
	{
		if($this->session->userdata('admin_id') == "")
			redirect('admin');
	}
/*
+-----------------------------------------+
	This Function will return all data.
+-----------------------------------------+
*/		
	function queryResult($sql)
	{
		$res = $this->db->query($sql);
		if($res->num_rows() > 0)
		{
			$result = $res->result_array();
		}
		else 
		{
			$result = "";
		}
		
		return $result;
	}
/*
+------------------------------------------------------------------+
	Function will return query result options.
	@params : $str -> pagination base url
			  $num -> Total number of rows table contain.
			  $start -> start segment, position 
			  $segment -> From which segment you want to consider pagination record count ?.
+------------------------------------------------------------------+
*/
	function CustompagiationData($str,$num,$start,$segment,$cur_page=0, $per_page)
	{
		$this->load->library('Custom_Pagination');
		$config['base_url'] = base_url().$str;
		$config['total_rows'] = $num;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = $segment;
		$config['cur_page'] = $cur_page;
		$this->custom_pagination->initialize($config); 
		
		$query = $this->db->last_query()." LIMIT ".$start." , ".$config['per_page'];
		$res = $this->db->query($query);
	
		$data['listArr'] = $res->result_array();
		$data['num'] = $res->num_rows();
		$data['links'] =  $this->custom_pagination->create_links();
		$data['total_rows'] = $num;
		return $data;
	}
/*
+-----------------------------------------+
	This Function will return file upload or not.
	@params : $uploadFile -> input file name
	          $filetype -> file type parameter eg. img, doc..
			  $folder -> upload folder path name
			  $fileName -> file name
+-----------------------------------------+
*/			
	function uploadFile($uploadFile, $filetype, $folder, $watermark=false, $fileName='')
	{
		$resultArr = array();
		
		$config['max_size'] = '1024000';
		if($filetype == 'img') 	$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
		if($filetype == 'All') 	$config['allowed_types'] = '*';
		if($filetype == 'pdf') 	$config['allowed_types'] = 'pdf';
		if($filetype == 'doc') $config['allowed_types'] = 'pdf|doc|docx|xls|ppt|rtf|xlsx|pptx|swf|gif|jpg|png|jpeg|txt|csv|text|TEXT|ACL|AFP|ANS|CSV|CWK|STW|RPT|PDAX|PAP|PAGES|SXW|STW|QUOX|WRI|XML|HTML|MCW|XPS|TXT|ABW|JPEG|PNG|SWF|PPT|PPTX|PDF|DOC|DOCX|XLS|XLSX|TeX';
		if($filetype == 'csv') 	$config['allowed_types'] = 'csv';
		if($filetype == 'swf') 	$config['allowed_types'] = 'swf';
		if($filetype == 'video') $config['allowed_types'] = 'flv|mp4|mov';
		
		$config['upload_path'] = $folder;

		if($fileName != "")
			$config['file_name'] = $fileName;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($uploadFile))
		{
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}
		else //if file upload
		{
			$resArr = $this->upload->data();
			$fullname = $resArr['file_name'];
			
			$resultArr['success'] = true;
			$resultArr['path'] = $folder."/".$fullname;
			
			if($watermark) //if watermark image
				$this->watermark($fullname);
		}
		return $resultArr;
	}
	
/*
+------------------------------------------------------------------+
	Function will be use for single field value. 
	@params-> $field : Name of field you want to fetch.
			  $table : Name of table
			  $wh : Where condition field name 
			  $cond : condition operator value.
+------------------------------------------------------------------+
*/		
	function getField($field,$table,$wh,$cond)
	{
		$this->db->select($field,FALSE);
		if($wh && $cond)
			$this->db->where($wh,$cond);
			
		$res = $this->db->get($table);	
		
		//if we want some aggreagration then we pass field name in $wh
		$result = $res->row_array();
		
		//echo 'ddsfdfd'.$result[$field];die;
		return $result[$field];
	}
/*
+------------------------------------------------------------------+
	Function will be use for ajax uploading image. 
	@params-> $module : Name of module name for upload image
			  $fileType : Name of file type
			  $inputFile : Input file name
			  $watermark = false : if not watermark image
+------------------------------------------------------------------+
*/	
	function ajaxUploading($module, $fileType, $inputFile, $watermark=false)
	{
		//print_r($_FILES);die;
		if($_FILES[$inputFile]["name"])
			$new_file_name = alterFileName($_FILES[$inputFile]["name"]);
		else
			$new_file_name = '';
			
		$data['type'] = $_FILES[$inputFile]["type"];
		$folder = 'uploads/'.$module;
		if(!file_exists($folder))
		{
			mkdir($folder,0777,true);
			chmod($folder,0777);
		}
		$res = $this->mdl_common->uploadFile($inputFile, $fileType, $folder, $watermark, $new_file_name);
		
		if($res['success'])
		{
			$data['link'] = $res["path"];
			$data['input'] = $inputFile;
			return $this->load->view('admin/elements/ajax_view_image',$data,true);
		}
		else
		{
			$res['error'] = strip_tags($res['error']);
			return $res;
		}
	}
/*
+------------------------------------------------------------------+
	Function will be use for delete uploaded image. 
	@params-> $field : Name of input field name
			  $table : Name of table in db
			  $tableId : Name of field name in db
+------------------------------------------------------------------+
*/	
	function deleteUploaderImage($field, $table, $tableId)
	{
		//detect ajax request
		if($this->input->is_ajax_request()):
			
			//if in edit mode
			if($this->input->post('auto_id') != '')
				$image = $this->mdl_common->getField($field, $table, $tableId, $this->input->post('auto_id'));
			else //simple in form functionality
				$image = $this->input->post('path');
			
			//remove image static ajax upload
			if(substr_count($image,'./') > 0)
				@unlink($image);
			else 
				@unlink('./'.$image);
			
			$thumb_img = $this->load_image($image);
			@unlink('./'.$thumb_img);
			
			//making this field null for edit reference
			if($this->input->post('auto_id') != '')
				$this->db->set($field,'')->where($tableId,$this->input->post('auto_id'))->update($table);
		
		endif;
		
	}
	
	// LOAD THUMB IMAGE
	function load_image($path = '',$type = 'thumb')
	{
		   if($path != '')
		   {
				   $pathArr = explode('/',$path);
				   $file_name = array_pop($pathArr);
				   return implode('/',$pathArr).'/'.$type.'/'.$file_name;
		   }
	}
	
/*
+------------------------------------------------------------------+
	Function will be use for generate export excel file. 
	@params-> $fileName : download file name
			  $columns : column field name in file 
			  $listArr : list data of array
+------------------------------------------------------------------+
*/
	function exportExcel($fileName,$columns,$listArr)
	{
		$this->load->helper('download');
		$handle1 = fopen($fileName,'w');
	
		$fileTextArray = array_values($columns);
		$fileText = implode("\t",$fileTextArray)."\n";
		fwrite($handle1, $fileText);
		
		foreach($listArr as $list)
		{
			$fileText = implode("\t",$list)."\n";
			fwrite($handle1, $fileText);
		}
		
		fclose($handle1);
	
		$this->force_download($fileName);
		unlink($fileName);
	}
/*
+------------------------------------------------------------------+
	Function will be use for excel download. 
	@params-> $file : download file name
+------------------------------------------------------------------+
*/	
	function force_download($file)
	{  
		if ((isset($file))&&(file_exists($file))) 
		{
			$fileName = str_replace("./","",$file);
						
		   header("Content-length: ".filesize($file));  
		   header('Content-Type: application/octet-stream');
		   header('Content-Disposition: attachment; filename="'.$fileName.'"');
		   
		   readfile($file);
		} 
		else 
		   echo "No file selected";
	}
	
	
	
	
}