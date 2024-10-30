<?php
$directory_lists 	= mbp_io_dirs();
$selected_dir		= $_GET['d'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
	$directory = intval($_POST['directory']);
	$overwrite = isset($_POST['overwrite'])?true:false;
	if($_FILES['upload_file']['tmp_name']!=''){
		if(strpos(strtolower(FILE_EXT),strtolower(mbp_io_get_file_ext($_FILES['upload_file']['name'])))===false){
			echo "<div class='updated fade'>Filetype not allowed to upload</div>";
		}else{		 
			if($_FILES['upload_file']['size'] < MAX_UPLOAD_BYTES){
					if(is_writable(mbp_original_dir() . mbp_io_windows_path($directory_lists[$directory]))){
						$create_file 	   = mbp_original_dir() . mbp_io_windows_path($directory_lists[$directory]).'/'.$_FILES['upload_file']['name'];	
						$create_clone_file = mbp_clone_dir() . '/'.$_FILES['upload_file']['name'];							
						if(is_file($create_file)){
							if($overwrite){
								if(is_writable($create_file)){
									@unlink($create_file);
									if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $create_file)){
										copy($create_file, $create_clone_file);
										@chmod($create_file,0666);
										@chmod($create_clone_file,0666);
										$directory=0;
										echo "<div class='updated fade'>File uploaded</div>";
									}else{
										echo "<div class='updated fade'>File uploaded error</div>";
									}
								}else{
									echo "<div class='updated fade'>Existing file is not writable</div>";
								}
							}else{
								echo "<div class='updated fade'>File already exists</div>";
							}
						}else{
							if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $create_file)){
								copy($create_file, $create_clone_file);
								@chmod($create_file,0666);
								@chmod($create_clone_file,0666);
								$directory=0;
								echo "<div class='updated fade'>File uploaded</div>";
							}else{
								echo "<div class='updated fade'>File uploaded error</div>";
							}
						}
					}else{
						echo "<div class='updated fade'>Destination folder is not writable</div>";
					}
			}else{
				echo "<div class='updated fade'>File size exceeds upload limits</div>";
			}
		}
	}else{
		echo "<div class='updated fade'>Select a file to upload</div>";
	}

}
?>
<style type="text/css">
<!--
.style1 {
	color: #0066CC;
	font-weight: bold;
}
-->
</style>

<form name="frmdir" id="frmdir" method="POST" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data"> 
<div class="wrap">
<h2>Image Organizer</h2>
    <table border="0" width="100%" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5">
     <tr >
   <td colspan="2" style="padding:4px 4px 4px 4px;background-color:#f1f1f1;">
   
   <strong>BACK >> 
   		<a href="?page=image-organizer">Home Page</a>
		&nbsp;|&nbsp; 			
		<INPUT type="button" value="Manage Directory" onclick="window.location='?page=image-organizer.php&action=dir'">
   </strong>
   </td>
  </tr>
  </table>
<br/>

<table width="100%" border="0" cellpadding="2" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5">
	<tr>
	  <td align="right">
	  <div align="left" class="style1">Upload Image &gt;&gt; </div></td>
	  <td width="78%">&nbsp;</td>
	  </tr>
	<tr>
		<td align="right" width="22%"><div align="left"><strong>Upload file to : </strong></div></td>
		<td><?php print mbp_io_generate_list("directory",$directory_lists, $selected_dir); ?></td>
	</tr>
	<tr>
		<td align="right" width="22%"><div align="left"><strong>Upload file</strong></div></td>
		<td><input type="file" name="upload_file" id="upload_file" /></td>
	</tr>
	<tr>
		<td align="right" width="22%">&nbsp;</td>
		<td><input type="checkbox" name="overwrite" value="1" />
	    Overrite existing file</td>
	</tr>
	<tr>
	  <td align="right"><div align="left"><span class="submit">
	    <input type="submit" name="upload" value="Upload"/>
	    </span></div></td>
	  <td>&nbsp;</td>
	  </tr>
</table>
	
</div>
</form>
<br/>
<div align="center" style="background-color:#f1f1f1; padding:5px 0px 5px 0px" >
<p align="center"><strong><?php echo MBP_IO_NAME.' '.MBP_IO_VERSION; ?> by <a href="http://www.maxblogpress.com" target="_blank">MaxBlogPress</a></strong></p>
<p align="center">This plugin is the result of <a href="http://www.maxblogpress.com/blog/219/maxblogpress-revived/" target="_blank">MaxBlogPress Revived</a> project.</p>
</div>