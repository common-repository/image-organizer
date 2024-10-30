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
<script type="text/javascript">
	$('#btn_remove').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_remove_dir.php',
			data:'removedirectory=' + $('#removedirectory').val() + '&dir_option=' + $('#dir_option').val() ,
			
			complete:function(data){
				$('#remove_dir').html(data.responseText);
			}				
			
		});
		return false;
	});	
</script>
<?php
$dir_option 	  = $_POST['dir_option'];
$directory_lists  = mbp_io_dirs();
$removedirectory  = intval($_POST['removedirectory']);
$remove_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$removedirectory+1]);
if ($dir_option != 'null') {
	if(@rmdir($remove_dir)){
		#$organizer_dirs = mbp_original_dir() . mbp_io_get_directories($directory_lists);
		$removedirectory = 0;
		echo '<font color="red">Directory removed</font>';
	}else{
		echo'<font color="red">Cannot delete directory</font>';
	}	
}	
?>
<?php $directory_lists  = mbp_io_dirs();?>
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