<?php
	
	function upload_file($file,$dir,$file_base_name,$expected_file_type = array()){

		$upload['status'] = 'Upload successfully';	
		$upload['error'] = 0;
		$upload['result_path'] = '';

		// if file is not uploaded
		if(!isset($file['error']) || $file['error'] > 0){

			$upload['status'] = 'Undeteced file';	
			$upload['error'] = 4;
			$upload['result_path'] = '';

			return $upload;
		}
		
		// set target directory
		$target_dir = $dir."/";

		// get file type
		$file_type = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

		// if file type is exist in given list
		if(count($expected_file_type) > 0 && !in_array($file_type, $expected_file_type)){

			$upload['status'] = 'File type not supported';	
			$upload['error'] = 2;
			return $upload;
		}

		// set target file name with full path
		$target_filename = $target_dir.$file_base_name.'.'.$file_type;

		// if taget file is not moved
		if(!move_uploaded_file($file['tmp_name'], $target_filename)){

			$upload['status'] = 'Failed to upload';	
			$upload['error'] = 3;
			return $upload;

		}

		$upload['result_path'] = $file_base_name.'.'.$file_type;

		return $upload;

	}

	function valid_file_type($file,$file_type_list){

		$file_type = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));		

		if(in_array($file_type, $file_type_list)) return true;

		return false;
	}

	function delete_file($path){

		try {
			// Hide warnings
		    error_reporting(E_ERROR | E_PARSE);	

		    // delete existing document
		    unlink(FCPATH.$path);	

		} catch (Exception $e) {
		    
		}
	}
?>