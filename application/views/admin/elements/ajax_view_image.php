<?php
/*
+----------------------------------------------------------+
	image uploading for check file type wise preview image.
	@prams : $link -> name of image path
	         $id -> is id of record
+----------------------------------------------------------+
*/	
	$img_src = image_src_common($link); //called from common_helper
	
	echo uploadPreview($img_src, $link, @$id); //called from common_helper

	//echo json_encode($data);
?>
