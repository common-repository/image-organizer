<?php
include('../../../../wp-config.php');
include_once('../image-organizer.php');
$photo 			= $_POST['photo'];
if (is_writable($photo)) {
	unlink($photo);
}
$image_parts = explode("/",$path);
$image_name  = $image_parts[sizeof($image_parts)-1];
@unlink(CLONE_UPLOAD_DIR . $image_name);
$page				= 1;
$directory_no		= $_POST['directory_no'];
$directory_lists 	= mbp_io_dirs();
$files 				= new MbpFilelist;
$files->path		= mbp_original_dir() . mbp_io_windows_path($directory_lists[$directory_no]);
$files->get_directory_files();
$files->page = $page;
$file_list 	 = $files->get_directory_page();
echo sizeof($file_list);
?>