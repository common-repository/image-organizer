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

$directory_lists  = mbp_io_dirs();
	$newdirname   = stripslashes(trim($_POST['newdirname']));
	$newdirectory = intval($_POST['newdirectory']);
	if($newdirname!='' && $dir_option != 'null'){
		if(mbp_io_is_valid_name(($newdirname))){
			$remove_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$newdirectory+1]);
			$create_dir_prefix = implode("/",array_slice(explode("/",$remove_dir),0,count(explode("/",$remove_dir))-1));
			if(@rmdir($remove_dir)){
				if(@mkdir(mbp_io_windows_path($create_dir_prefix.'/'.$newdirname),0777)){
					@chmod(mbp_io_windows_path($create_dir_prefix.'/'.$newdirname),0777);
					$newdirectory=0;
					$newdirname='';
					#$organizer_dirs = organizer_get_directories($organizer_files_dir);
					echo '<font color="red">Directory renamed</font>';
				}
			}else{
				echo'<font color="red">Cannot rename directory</font>';
			}
		}else{
			echo '<font color="red">Directory name contains invalid characters</font>';
		}
	}else{
		//echo 'Directory name cannot be empty';
	}	
?>
<script type="text/javascript">
	$('#btn_rename').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_rename_dir.php',
			data:'newdirectory=' + $('#newdirectory').val() + '&dir_option=rename_dir' + '&newdirname=' + $('#newdirname').val(),
			
			complete:function(data){
				$('#rename_dir').html(data.responseText);
			}				
			
		});
		return false;
	});	
</script>
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
<?php $directory_lists  = mbp_io_dirs();?>
<form name="form_rename_dir" method="post">
  <input type="hidden" name="dir_option" id="dir_option" value="rename_dir"/>
  <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
  <table width="50%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="52%">Rename Directory In </td>
	  <td width="48%">
		 <?php 
			print mbp_io_generate_list("newdirectory",array_slice($directory_lists,1),$newdirectory); ?>	  </td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="text" name="newdirname" id="newdirname"/></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><i>Note: Directory name cannot be empty</i></td>
    </tr>
  </table>
<p class="submit">
  <input type="button" name="btn_rename" id="btn_rename" value="Rename Directory" />
</p>		  
</form>