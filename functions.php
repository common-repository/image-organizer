<?php
function mbp_io_create_dir() {
	if (!file_exists(UPLOAD_DIR)) {
		mkdir(UPLOAD_DIR);
		@chmod(UPLOAD_DIR,0666);
	}
	
	if (!file_exists(CLONE_UPLOAD_DIR)) {
		mkdir(CLONE_UPLOAD_DIR);
		@chmod(CLONE_UPLOAD_DIR,0666);
	}	
}

function mbp_io_dirs() {
	#$organizer_files_dir	= mbp_io_windows_path($_SERVER['DOCUMENT_ROOT'] . '/wordpress-test/wordpress2.8.4/wp-content/uploads/');
	$organizer_files_dir	= mbp_io_windows_path(UPLOAD_DIR);	
	$organizer_dirs 		= mbp_io_get_directories($organizer_files_dir); 
	return $organizer_dirs;
}

function mbp_original_dir() {
	#return mbp_io_windows_path($_SERVER['DOCUMENT_ROOT'] . '/wordpress-test/wordpress2.8.4/' .  '/wp-content/uploads/');
	return mbp_io_windows_path(UPLOAD_DIR);	
}

function mbp_clone_dir() {
	#return mbp_io_windows_path($_SERVER['DOCUMENT_ROOT'] . '/wordpress-test/wordpress2.8.4/' .  '/wp-content/clone-upload/');
	return mbp_io_windows_path(CLONE_UPLOAD_DIR);	
}

function mbp_io_windows_path($path){
	$path = str_replace("\\","/",$path);
	$path = str_replace("//","/",$path);
	$path = str_replace("//","/",$path);
	$path = str_replace("//","/",$path);
	if(substr($path, -1)=='/'){
		$path = substr($path,0,strlen($path)-1);
	}
	return $path;
}

function mbp_io_get_directories($path){	 
	$folders  = array();
	$i = 0;
	
	if ($handle = opendir($path)){
		while ( false !== ($file = readdir($handle)) ){
			if (filetype($path."/".$file) == 'dir'){
				if ($file != '..' && $file != '.' && $file != '' && (substr($file,0,1) != '.')){
					$folders[$i] = mbp_io_windows_path($path."/".$file);
					$i++;
				}
			}
		}
		closedir($handle);
		for ( $u = 0; $u < $i; $u++ ){
			if ($handle = opendir($folders[$u])){
				while ( false !== ($file = readdir($handle)) ){
					if (filetype($folders[$u]."/".$file) == 'dir'){
						if ($file != '..' && $file != '.' && $file != '' && (substr($file,0,1) != '.')){
							$folders[$i] = mbp_io_windows_path($folders[$u]."/".$file);
							$i++;
						}
					}
				}
				closedir($handle);
			}
		}
	}
	$folder_without_path=array("/");
	foreach($folders as $folder){
		$folder_without_path[]=str_replace($path,"",$folder);
	}
	return $folder_without_path;
}

function mbp_io_generate_list($listname,$list,$value,$extras=''){
	$retval = "<select name=\"$listname\" id=\"$listname\" $extras>\n";
	foreach ($list as $key => $val){
		$selected = ($key==$value)? 'selected' : '';
		$retval .= "<option value=\"$key\" $selected>$val</option>\n";
	}
	$retval .= "</select>\n";
	print $retval;
}

/**
* checks valid directory name
*/
function mbp_io_is_valid_name($name){
	if(ereg('[^[:space:]a-zA-Z0-9_.-]{1,}', $name)){
		return false;
	}else{
		return true;
	}
}

/**
* get file extensions
*/
function mbp_io_get_file_ext($filename){
	$file_parts=pathinfo($filename);
	return  $file_parts['extension'];
}
?>