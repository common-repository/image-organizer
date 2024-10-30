<?php
$directory_lists 	= mbp_io_dirs();
global $wp_version;
if ($wp_version < 2.7) {
	$body_width = '800px';
} else {
	$body_width = '570px';
}
?>
<style type="text/css">
p {
	padding: 0 0 1em;
}
.msg_list {
	margin: 0px;
	padding: 0px;
	width: auto;
}
.msg_head {
	padding: 5px 10px;
	cursor: pointer;
	position: relative;
	background-color:#F1F1F1;
	margin:1px;
}
.msg_body {
	padding: 5px 10px 15px;
	background-color:#FFF;
}
<?php if ($wp_version < 2.7) { ?>
.about_us {
	margin:170px 0px 0px 0px;
}
<?php } ?>
</style>
<div class="wrap">
<h2>Image Organizer</h2>
<table border="0" width="100%" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5">
     <tr >
   <td colspan="2" style="padding:4px 4px 4px 4px;background-color:#f1f1f1;">
   <strong>BACK >> 
   		<a href="?page=image-organizer">Home Page</a>
		&nbsp;|&nbsp; <INPUT type="button" value="Upload Photos" onclick="window.location='?page=image-organizer.php&action=upload'">
   </strong></td>
  </tr>
</table>
<br/>

<div class="clear"/>
	<div class="msg_list">
			<p id="msg_head_create" class="msg_head"><strong>Create Directory</strong></p>
			<div class="msg_body" id="msg_body_create">
				<div id="create_dir">
						<form name="form_create_dir" method="post">
						  <input type="hidden" name="dir_option" id="dir_option" value="create_dir"/>
						  <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
						  <table width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="52%">Create Directory In </td>
							  <td width="48%">
								 <?php print mbp_io_generate_list("directory",$directory_lists,''); ?>
							  </td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td><input type="text" name="dirname" id="dirname"/></td>
							</tr>
						  </table>
						<p class="submit">
						  <input type="button" name="btn_create" id="btn_create" value="Create Directory" />
						</p>		  
						</form>
			  </div>				
		</div> <!-- end msg_body -->
	
		
			<p id="msg_head_rename" class="msg_head"><strong>Rename Directory</strong></p>
			<div class="msg_body" id="msg_body_rename">
				<div id="rename_dir">
						<form name="form_rename_dir" method="post">
						  <input type="hidden" name="dir_option" id="dir_option" value="rename_dir"/>
						  <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
						  <table width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="52%">Rename Directory In </td>
							  <td width="48%">
								 <?php 
									print mbp_io_generate_list("newdirectory",array_slice($directory_lists,1),$newdirectory); ?>
							  </td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td><input type="text" name="newdirname" id="newdirname"/></td>
							</tr>
						  </table>
						<p class="submit">
						  <input type="button" name="btn_rename" id="btn_rename" value="Rename Directory" />
						</p>		  
						</form>
			  </div>					

			</div><!-- end msg_body -->
		
	
			<p id="msg_head_remove" class="msg_head"><strong>Remove Directory</strong></p>
			<div class="msg_body" id="msg_body_remove">
				<div id="remove_dir">
						<form name="form_rename_dir" method="post">
						  <input type="hidden" name="dir_option" id="dir_option" value="remove_dir"/>
						  <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
						  <table width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="52%">Remove Directory</td>
							  <td width="48%">
								 <?php 
									print mbp_io_generate_list("removedirectory",array_slice($directory_lists,1),$removedirectory); ?>
							  </td>
							</tr>
						  </table>
						<p class="submit">
						  <input type="button" name="btn_remove" id="btn_remove" value="Remove Directory" />
						</p>		  
						</form>
			  </div>					
			</div><!-- end msg_body -->
	</div>
</div>	
<br/>
<?php if ($wp_version < 2.7) { ?>
<div class="about_us">
<?php } else {?>
<div align="center" style="background-color:#f1f1f1; padding:5px 0px 5px 0px" >
<?php } ?>
<p align="center"><strong><?php echo MBP_IO_NAME.' '.MBP_IO_VERSION; ?> by <a href="http://www.maxblogpress.com" target="_blank">MaxBlogPress</a></strong></p>
<p align="center">This plugin is the result of <a href="http://www.maxblogpress.com/blog/219/maxblogpress-revived/" target="_blank">MaxBlogPress Revived</a> project.</p>
</div>