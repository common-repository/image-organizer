<?php 
include('../../../../wp-config.php');
include_once('../image-organizer.php');
include_once('../functions.php');
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

<?php
$dir_option 	  = $_POST['dir_option'];
$directory_lists  = mbp_io_dirs();
$dirname   		  = stripslashes(trim($_POST['dirname']));
$directory 		  = intval($_POST['directory']);
if($dirname!='' && $dir_option != 'null'){
		if(mbp_io_is_valid_name(($dirname))){
			$create_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$directory].'/'.$dirname);
			if(@mkdir($create_dir,0777)){
				@chmod($create_dir,0777);
				$dirname     = '';
				$directory   = 0;
				#$mbp_io_dirs = mbp_io_get_directories($directory_lists);
				echo '<font color="red">Directory created</font>';
			}else{
				echo '<font color="red">Directory creation failed</font>';
			}
		}else{
			echo '<font color="red">Directory name contains invalid characters</font>';
		}
	}else{
		//if(!$_POST['dirname']) echo 'Directory name cannot be empty';
	
	}
?>
<script type="text/javascript">
	//for directory management
	$('#btn_create').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_create_dir.php',
			data:'directory=' + $('#directory').val() + '&dir_option=' + $('#dir_option').val() + '&dirname=' + $('#dirname').val(),
			
			complete:function(data){
				$('#create_dir').html(data.responseText);
			}				
		});
		return false;
	});	
</script>
<?php $directory_lists  = mbp_io_dirs();?>
<form name="form_create_dir" method="post">
  <input type="hidden" name="dir_option" id="dir_option" value="create_dir"/>
  <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
  <table width="50%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="52%">Create Directory In </td>
	  <td width="48%">
		 <?php print mbp_io_generate_list("directory",$directory_lists,''); ?>	  </td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="text" name="dirname" id="dirname"/>*</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><i>Note: Directory name cannot be empty</i></td>
    </tr>
  </table>
<p class="submit">
  <input type="button" name="btn_create" id="btn_create" value="Create Directory" />
</p>		  
</form>
