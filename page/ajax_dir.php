<?php 
include_once('../config.php');
include_once('../functions.php');
?>
<script type="text/javascript">
	//for directory management
	$('#btn_create').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_dir.php',
			data:'directory=' + $('#directory').val() + '&dir_option=' + $('#dir_option').val() + '&dirname=' + $('#dirname').val(),
			
			complete:function(data){
				$('#create_dir').html(data.responseText);
			}				
		});
		return false;
	});
	
	$('#btn_rename').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_dir.php',
			data:'newdirectory=' + $('#newdirectory').val() + '&dir_option=' + $('#dir_option').val() + '&newdirname=' + $('#newdirname').val(),
			
			complete:function(data){
				$('#rename_dir').html(data.responseText);
			}				
			
		});
		return false;
	});	
	
	$('#btn_remove').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_dir.php',
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
if ($dir_option == 'create_dir') {

	$dirname   		 = stripslashes(trim($_POST['dirname']));
	$directory 		 = intval($_POST['directory']);
	if($dirname!=''){
		if(mbp_io_is_valid_name(($dirname))){
			$create_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$directory].'/'.$dirname);
			if(@mkdir($create_dir,0777)){
				@chmod($create_dir,0777);
				$dirname     = '';
				$directory   = 0;
				#$mbp_io_dirs = mbp_io_get_directories($directory_lists);
				echo 'Directory created';
			}else{
				echo 'Directory creation failed';
			}
		}else{
			echo 'Directory name contains invalid characters';
		}
	}else{
		echo 'Directory name cannot be empty';
	}
}

if ($dir_option == 'rename_dir') {
	$newdirname   = stripslashes(trim($_POST['newdirname']));
	$newdirectory = intval($_POST['newdirectory']);
	if($newdirname!=''){
		if(mbp_io_is_valid_name(($newdirname))){
			$remove_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$newdirectory+1]);
			$create_dir_prefix = implode("/",array_slice(explode("/",$remove_dir),0,count(explode("/",$remove_dir))-1));
			if(@rmdir($remove_dir)){
				if(@mkdir(mbp_io_windows_path($create_dir_prefix.'/'.$newdirname),0777)){
					@chmod(mbp_io_windows_path($create_dir_prefix.'/'.$newdirname),0777);
					$newdirectory=0;
					$newdirname='';
					#$organizer_dirs = organizer_get_directories($organizer_files_dir);
					echo 'Directory renamed','organizer';
				}
			}else{
				echo'Cannot rename directory';
			}
		}else{
			echo 'Directory name contains invalid characters';
		}
	}else{
		echo 'Directory name cannot be empty';
	}	
}

if ($dir_option == 'remove_dir') {
	$removedirectory = intval($_POST['removedirectory']);
	$remove_dir = mbp_original_dir() . mbp_io_windows_path($directory_lists[$removedirectory+1]);
	if(@rmdir($remove_dir)){
		#$organizer_dirs = mbp_original_dir() . mbp_io_get_directories($directory_lists);
		$removedirectory = 0;
		echo 'Directory removed';
	}else{
		echo'Cannot delete directory';
	}	
}
include_once('directory.php');
?>
