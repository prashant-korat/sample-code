<?php
function access_denied()
{
	echo "<h1>Access Denied</h1> 
			<a href='".base_url()."home'>Go to Home</a>";
	die;
}
/*
+-----------------------------------------------+
	Alter file name, remove special character from
	file name and append some random key to file.
+-----------------------------------------------+
*/
function alterFileName($fileName)
{
	$fileName2 = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $fileName);
	
	$info = pathinfo($fileName2);
	$p = $info['extension'];
	$fileName1 =  basename($fileName2,'.'.$p);
	$fileName1.="_".time().".".$p; 

	return $fileName1;
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	This function will call any url using php
	curl and return result as string.
	@params : pass any url Ex. http://www.google.com
++++++++++++++++++++++++++++++++++++++++++++++
*/
function call_url($url)
{
	$ch = curl_init ($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$out = curl_exec($ch);
	curl_close($ch);
	
	return  $out;
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	This function is displaying error message,
	keep data in session.
	@params : 
		@Key : Key name of the variable
++++++++++++++++++++++++++++++++++++++++++++++
*/

function getFlashMessage($key)
{
	$C =& get_instance();
	if($C->session->userdata('flash_'.$key))
	{
		$msg = $C->session->userdata('flash_'.$key);
		$C->session->unset_userdata('flash_'.$key);
	}
	return @$msg;
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	This function is setting error,notification,
	information message,
	keep data in session.
	@params : 
		@Key : Key name of the variable
		@msg : Which message you want to dispaly 
				in next page without pass query string.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function setFlashMessage($key,$msg)
{
	$C = & get_instance();
	$C->session->set_userdata('flash_'.$key,$msg);
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Function will return first form error which
	are validated with formValidation in codeigniter.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function get_single_form_error()
{
	$CI = & get_instance();
	
	pr($CI->form_validation);
	  if(count($CI->form_validation->_error_array) > 0 )
	  {
		  foreach($CI->form_validation->_error_array as $er)
		  {
			  return $er;
			  break;
		  }
	  }
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Function will detect device is ipad or not.
	@params : None.
	@returrn : TRUE OR FALSE
++++++++++++++++++++++++++++++++++++++++++++++
*/
function is_ipad()
{
	$CI =& get_instance();
	$CI->load->library('user_agent');
	
	if($CI->agent->mobile('ipad'))
		return true;
	else
		return false;
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Load thumb url of uploaded image. there is 
	fix syntax with image name. we are uploading 
	thumb image with same name but with "thumb"
	named folder. If there is no image then it will
	load default thumb image.
	@params : $url -> URL of image [url will be relative].
			  $fl -> Flag stand for return thumb path only.
	@returrn : Path of thumb image
++++++++++++++++++++++++++++++++++++++++++++++
*/
function load_thumb($url,$fl= 0)
{
	$info = pathinfo($url);
	$th = $info['dirname']."/thumb_".$info['filename'].".".$info['extension'];
	if($fl == 1)
		return $th;
		
	$thumb_path =  base_url().$th; 
	if(file_exists('./'.$th))
		return $thumb_path;
	else
		return base_url()."images/no-imges.jpg";
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Load image from url. if not file exist then
	it will load default selected image.
	
	@params : $url -> URL of image [url will be relative].
			  $fl -> Flag stand for return image path only.
	@returrn : Path of image
++++++++++++++++++++++++++++++++++++++++++++++
*/
function load_image($url,$fl= 0)
{		
	$thumb_path =  base_url().$url; 
	if(file_exists('./'.$url) && $url)
		return $thumb_path;
	else
		return base_url()."images/no-imges.jpg";
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Just dropdown of per page listing, you can 
	set how many records you want to see on page.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function per_page_drop()
{
	$dropdown = array('20'=>'20 Records Per Page','40'=>'40 Records Per Page','60'=>'60 Records Per Page','100'=>'100 Records Per Page');
	//$dropdown = array('2'=>'2 Per Page','4'=>'4 Per Page','6'=>'6 Per Page','10'=>'10 Per Page');
	return $dropdown;
}


/*
++++++++++++++++++++++++++++++++++++++++++++++
	Shortcut function for print data.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function pr($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Image resizing fuction. will resize image.
	@params : $source -> relative path of source image
			  $dest -> Setination path of image.
			  $width -> Width of the image you want to achieve.
			  $height - > height of the image you want to achieve;.
	@return : Resized image array.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function resize_image($source,$dest,$width,$height)
{
	$C = & get_instance();
	
	$config['image_library'] = 'gd2';
	$config['source_image']	= $source;
	$config['create_thumb'] = TRUE;
	$config['new_image'] = $dest;
	$config['maintain_ratio'] = TRUE;
	$config['width']	 = $width;
	$config['height']	= $height;
	$config['thumb_marker'] = '';

	
	$C->load->library('image_lib'); 
	$C->image_lib->initialize($config);
	$rt = $C->image_lib->resize();
	
	unset($C);
	return $rt;
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Mail send shortcut function.
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function sendMail($toEmail,$subject,$mail_body,$from_email='',$from_name = '',$file_path = '')
{
	$C =& get_instance();
	
	$C->load->library('email');
	if($from_email != '')
		$fromEmail = $from_email;
	else
		$fromEmail = getField('config_value','config','config_keyword','admin_email');
	
	if($from_name == '')
		$from_name = 'Libaas';

	$config['mailtype'] = 'html';
	$config['protocol'] = 'mail';
	$config['mailpath'] = '/usr/sbin/sendmail';
	
	$C->email->initialize($config);
	//$C->email->cc('another@another-example.com');
	$C->email->from($fromEmail, $from_name);
	$C->email->to($toEmail);
	$C->email->subject($subject);
	$C->email->message($mail_body);
	$C->email->reply_to($fromEmail,'');
	if($file_path)
		$C->email->attach($file_path,'');
	
	$C->email->send();
//	echo $C->email->print_debugger();
	unset($C);
}

function sendMail1($emailId,$subject,$mail_body)
{
	   //$fromEmail = $this->queryResult('select value from configuration where name="from_email"','value');
	   $fromEmail = strip_tags(getField('config_value','config','config_keyword','admin_email')); //get admin email
	   
	   $C =& get_instance();
	   $C->load->helper('phpmailer');
	   $mail = new PHPMailer();
		
	   $mail->IsSMTP();
	   $mail->IsHTML(true); // send as HTML
	   
	   $mail->SMTPAuth   = true;                  // enable SMTP authentication
	   $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	   $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	   $mail->Port       = 465;                   // set the SMTP port 
	   $mail->Username   = "hitesh.khunt@artoonsolutions.com";                                     // GMAIL username
	   $mail->Password   = "artoonartoon";                                           // GMAIL password

	   $mail->From       = $fromEmail;
	   $mail->FromName   = "CVP";
	   $mail->Subject    = $subject;
	   $mail->Body       = $mail_body;           //HTML Body
	   
	   $emails  = explode(",",$emailId);
	   foreach($emails as $email)
			   $mail->AddAddress($email);
	   
	   if(!$mail->Send())
		 echo "Mailer Error: " . $mail->ErrorInfo;
}
	
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Function will return text which are fully 
	closed tag. functio will automatically close
	all tags which are not closed. 
++++++++++++++++++++++++++++++++++++++++++++++
*/
function __MCEText($string,$length)
{
		if( !empty( $string ) && $length>0 ) 
		{ 
			$isText = true; 
			$ret = ""; 
			$i = 0; 
			
			$currentChar = ""; 
			$lastSpacePosition = -1; 
			$lastChar = ""; 
			
			$tagsArray = array(); 
			$currentTag = ""; 
			$tagLevel = 0; 
			
			$noTagLength = strlen( strip_tags( $string ) ); 
			
			// Parser loop 
			for( $j=0; $j<strlen( $string ); $j++ ) 
			{ 
				$currentChar = substr( $string, $j, 1 ); 
				$ret .= $currentChar; 
				
				// Lesser than event 
				if( $currentChar == "<") $isText = false; 
				
				// Character handler 
				if( $isText ) 
				{ 	
					// Memorize last space position 
					if( $currentChar == " " ) { $lastSpacePosition = $j; } 
					else { $lastChar = $currentChar; } 
					$i++; 
				} 
				else  
					$currentTag .= $currentChar; 
			
			
				// Greater than event 
				if( $currentChar == ">" ) 
				{ 
					$isText = true; 
				
					// Opening tag handler 
					if( ( strpos( $currentTag, "<" ) !== FALSE ) && ( strpos( $currentTag, "/>" ) === FALSE ) &&  ( strpos( $currentTag, "</") === FALSE ) ) 
					{ 
						// Tag has attribute(s) 
						if( strpos( $currentTag, " " ) !== FALSE )
							$currentTag = substr( $currentTag, 1, strpos( $currentTag, " " ) - 1 ); 
						else 
							$currentTag = substr( $currentTag, 1, -1 );  // Tag doesn't have attribute(s) 
	
						array_push( $tagsArray, $currentTag ); 
					
					} 
					else if( strpos( $currentTag, "</" ) !== FALSE ) 
						array_pop( $tagsArray ); 
						
					$currentTag = ""; 
				} 
				
				if( $i >= $length) 
					break; 
			} 
			
			// Cut HTML string at last space position 
			if( $length < $noTagLength ) 
			{ 
				if( $lastSpacePosition != -1 ) 
					$ret = substr( $string, 0, $lastSpacePosition ); 
				else 
					$ret = substr( $string, $j ); 
					
			} 
			if(strlen($string) > $length)
				$ret.='...';
			// Close broken XHTML elements 
			while( sizeof( $tagsArray ) != 0 ) 
			{ 
				$aTag = array_pop( $tagsArray ); 
				$ret .= "</" . $aTag . ">\n"; 
			} 
			
		} 
		else 
			$ret = ""; 
		
		return( $ret ); 
}
/*
+-----------------------------------------+
	This Function will return get sort order.
	@params. $sort - sort by
	         $postField - post field name
			 $field - db field name
+-----------------------------------------+
*/
function get_sort_order($sort, $postField, $field)
{
	if($postField == $field)
	{
		if($sort == 'ASC')
			$sort = 'DESC';
		else 
			$sort = 'ASC';	
	}
	return $sort;
}

/*
+-----------------------------------------+
	This Function will return file extension 
	wise final image source.
+-----------------------------------------+
*/
function image_src_common($filepath)
{
	$ext = strtolower(substr(strrchr(basename($filepath), '.'), 1));
	$imageArr = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'JPEG');
	$docArr   = array('doc', 'docx', 'ppt');
	$pdfArr   = array('pdf');
	$xlsArr   = array('xls', 'xlsx', 'txt', 'csv');
	$videoArr = array('mp4', 'flv', 'mov');
	switch($ext)
	{
		case in_array($ext, $imageArr) :
			$img_src = $filepath;
			break;
		case in_array($ext, $docArr) :
			$img_src = 'images/admin/doc.png';
			break;
		case in_array($ext, $pdfArr) :
			$img_src = 'images/admin/pdf.png';
			break;
		case in_array($ext, $xlsArr) :
			$img_src = 'images/admin/xls.png';
			break;
		case in_array($ext, $videoArr) :
			$img_src = 'images/admin/video.png';
			break;
		default :
			$img_src = 'images/admin/unknown.png';
			break;
	}
	return $img_src;
	
}

function userIsLoggedIn()
{
	$C =& get_instance();
	
	$str = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
	
	if($C->session->userdata('user_id') == '')
		redirect('/?redirect_to='.base64_encode(current_url().$str));
}
/*
+-----------------------------------------+
	This Function is return Set Full http url.
+-----------------------------------------+
*/
function fullHttpUrl($url)
{
	$u = parse_url($url);
	$protocol = (!isset($u['scheme'])) ? 'http://' : $u['scheme']."://";
	$d = (!isset($u['host'])) ? $u['path'] : $u['host'];
	$path = (isset($u['host']) && isset($u['path'])) ? $u['path'] : '';
	$query = (isset($u['query'])) ? '?'.$u['query'] : '';
	
	$domain = (substr_count($d,'www.') == 0) ? 'www.'.$d : $d;
	
	$url = $protocol.$domain.$path.$query;
	
	$finalUrl = (substr($url,-1) != '/') ? $url."/" : $url;	
	return $finalUrl;

}
/*
+-----------------------------------------+
	This Function is view part for Image Upload.
+-----------------------------------------+
*/
function uploadPreview($img_src, $link, $id)
{
	$htmlCont =  '<img src="'.base_url().$img_src.'" class="preview" width="156" style="max-height:160px;">
    				<!--<span>'.basename($link).'</span>-->
					<input type="hidden" id="video_path" name="video_path" value="'.$link.'" />
					<a class="remove_ajax_img" rel="ajax_uploaded_remove_video" href="javascript:void(0);" data-="'.@$id.'"></a>';
					
	return $htmlCont;
}


/**
 * Returns the string with URL's replaced with actual HTML link tags
 * @param string $string The string to parse for URL's
 * @param boolean $noFollow Whether or not to add the rel="nofollow" 
 * attribute to the tag
 * @param boolean $newWindow Whether or not to make the link open in a new
 * window
 * @return string
 */
function getStringWithUrlLinks($s, $noFollow = true, $newWindow = true) {
    return preg_replace('/https?:\/\/[\w\-\.!~?&+\*\'"(),\/]+/','<a href="$0"'
																	. (($noFollow) ? ' rel="nofollow"' : '')
																	. (($newWindow) ? ' target="_blank"' : '')
																	. '>$0</a>',$s);
}
/*
+-----------------------------------------+
	This Function will be use for decrypt the column
+-----------------------------------------+
*/
function DecryptColumn($str,$key = 'asdzxc') 
{
	if(trim($str))
		return trim(mcrypt_decrypt(MCRYPT_DES, $key, hex2bin1($str), MCRYPT_MODE_ECB));
	else
		return '';	
}

/*
+-----------------------------------------+
	This Function will be use for encrypt the column
+-----------------------------------------+
*/
function EncryptColumn($str,$key = 'asdzxc') 
{
	if(trim($str))
		return trim(bin2hex(mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB)));	 
	else
		return '';	
}

/*
+-----------------------------------------+
	This Function will be use for convert
	hexadecimal to binary string
+-----------------------------------------+
*/
function hex2bin1($hexstr) 
{ 
	$n = strlen($hexstr); 
	$sbin="";   
	$i=0; 
	while($i<$n) 
	{       
		$a =substr($hexstr,$i,2);           
		$c = pack("H*",$a); 
		if ($i==0){$sbin=$c;} 
		else {$sbin.=$c;} 
		$i+=2; 
	} 
	return $sbin; 
}

function Messages($id='')
{
	$dropdown = array( 1 => 'Could not find activation key. Please try again.',// not found activation key
			2 => "We could not find information about this activation key. Please verify your activation email.",//for wrong activation key
			3 => "Invalid username or password combination.", //wrong user name and password
			4 => "Please activate your account first. You should have received activation link in your email.",//account without activation
			5 => "We could not find information related to this email address. Kindly check your email address registered with us.",//for wrong email address in forgot password
			11 => "Your account is activated successfully.",//After activation
			13 => "Your password information is sent to your email address. Please check your mailbox.",//In forgot password
			14 => "Your password reset successfully.", //reset password
			15 => "Your profile updated successfully.",
			16 => "Your password updated successfully.",
			20 => "Account activation link is sent to your email. Please check your mailbox.",//simple register
			21 => "You have successfully signed up with facebook. Your password details are sent to your email, please check your mailbox.",//signup through facebook
			22 => "Your account information is updated successfully.",//edit profile
			23 => "Thank you for reporting issue(s). We would try to resolve them as soon as possible.",//Contact us reporting bug
			24 => "Thank you for contacting us. We would get in touch with you soon.",//Contact us Feed back or other
			);
	if($id)
		return $dropdown[$id];
	else
		return $dropdown;
}

?>