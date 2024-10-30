<?php
$d 				 = $_GET['d'];
$image  		 = $_GET['image']; 
$directory_lists =  mbp_io_dirs();
$source_dir		 = mbp_clone_dir() . '/' . $image; 
$destination_dir = mbp_original_dir() . $directory_lists[$d] . '/' . $image;
@copy($source_dir, $destination_dir);
header("location:?page=image-organizer.php");
?>