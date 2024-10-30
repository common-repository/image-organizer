<?php
$current_dir  		= $_GET['d'];
$image				= $_GET['image'];
$directory_lists 	= mbp_io_dirs();
$resize_level = isset($_POST['resize_level'])?intval($_POST['resize_level']):100;

if ($_GET['task'] == 'resize') {
	$source_dir		 = mbp_clone_dir() . '/' . $image; 
	$destination_dir = mbp_original_dir() . $directory_lists[$current_dir] . '/' . $image;
	@copy($source_dir, $destination_dir);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$image_path = mbp_original_dir() . $directory_lists[$current_dir];
	$open_image	= mbp_io_open_image_file($image_path,$image);	
	$white 		= imagecolorallocate($open_image , 255, 255, 255);
	imagefill($open_image, 0, 0, $white);
	$resized_image = mbp_io_resize_image($open_image,$resize_level);
	mbp_io_save_image_file($image_path,$image,$resized_image);
	@imagedestroy($open_image);
	@imagedestroy($resized_image);
	@imagedestroy($new_resized_image);
	echo "<div class='updated fade'>Image resized</div>";	
}
$image_path = UPLOAD_URL .$directory_lists[$current_dir] . '/' .  $image;
?>
<div class="wrap">
<h2>Image Organizer</h2>
<br/>
<strong><img src="<?php echo MBP_AIT_LIBPATH;?>image/how.gif" border="0" align="absmiddle" /> <a href="http://wordpress.org/extend/plugins/affiliate-image-tracker/other_notes/" target="_blank">How to use it</a>&nbsp;&nbsp;&nbsp;
		<img src="<?php echo MBP_AIT_LIBPATH;?>image/comment.gif" border="0" align="absmiddle" /> <a href="http://www.maxblogpress.com/forum/forumdisplay.php?f=27" target="_blank">Community</a></strong>
<br/>
<br/>	

<table border="0" width="100%" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5">
     <tr >
   <td colspan="2" style="padding:4px 4px 4px 4px;background-color:#f1f1f1;">
   		<strong>
			BACK >> <a href="?page=image-organizer">Home Page</a>
			&nbsp; 
			| 
			<INPUT type="button" value="Manage Directory" onclick="window.location='?page=image-organizer.php&action=dir'">
			&nbsp;&nbsp; 
						<INPUT type="button" value="Upload Photo" onclick="window.location='?page=image-organizer.php&action=upload'">
		</strong>
   </td>
  </tr>
</table>
<br/>

<table bgcolor="#f1f1f1" border="0" cellspacing="1" cellpadding="4" style="border:1px solid #e5e5e5">
	<tr>
		<td bgcolor="#FFFFFF"><img src="<?php print $image_path;?>" alt="image"></img></td>
	</tr>
</table>
 <form method="post" action="<?php echo $PHP_SELF;?>" name="form_file_rename" id="form_file_rename">
<table width="100%" border="0" cellspacing="1" cellpadding="4">

	<tr>
		<td width="50%">Resize to 
			<select name="resize_level" id="resize_level">
				<option value="0">Select</option>
				<?php
				for($level=10;$level<=100;$level=$level+5){
					if($resize_level==$level){
						print '<option value="'.$level.'" selected>'.$level.' %</option>';
					}else{
						print '<option value="'.$level.'">'.$level.' %</option>';
					}
				}
				?>
		  </select>		</td>
	</tr>
	<tr>
		<td align="left"><input type="submit" name="save" id="save" value="Save">

			<input type="button" onclick="window.location.href='?page=image-organizer.php&action=resize&d=<?php echo $_GET['d'];?>&image=<?php echo $_GET['image'];?>&task=resize'" value="Resize to Original" />
			
		</td>

		<td align="center">	</td>
	</tr>
</table>
</form>
</div>
<br/>
<div align="center" style="background-color:#f1f1f1; padding:5px 0px 5px 0px" >
<p align="center"><strong><?php echo MBP_IO_NAME.' '.MBP_IO_VERSION; ?> by <a href="http://www.maxblogpress.com" target="_blank">MaxBlogPress</a></strong></p>
<p align="center">This plugin is the result of <a href="http://www.maxblogpress.com/blog/219/maxblogpress-revived/" target="_blank">MaxBlogPress Revived</a> project.</p>
</div>