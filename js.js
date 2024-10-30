$(document).ready(function() {
	//for directory management
	$('#btn_create').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_create_dir.php',
			data:'directory=' + $('#directory').val() + '&dir_option=' + $('#dir_option').val() + '&dirname=' + $('#dirname').val(),
			
			complete:function(data){
				 var img = "<img src='" + $('#path') .val() + "ajax-loader.gif'/>";
				 $("#create_dir").empty().html(img);
				 $('#create_dir').html(data.responseText);
			}				
			
		});
		return false;
	});
	
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
	
	$('#btn_remove').click(function() {
		$.ajax({
			type:'POST',
			url: $('#path') .val() + 'ajax_remove_dir.php',
			data:'removedirectory=' + $('#removedirectory').val() + '&dir_option=remove_dir' ,
			
			complete:function(data){
				$('#remove_dir').html(data.responseText);
			}				
			
		});
		return false;
	});		
	
	//for deleting image in index page
	$('#photo_table tr .remove input').click(function() {
		var image_path = $(this).val();
		var confirm_delete = window.confirm("Are you sure to delete?");
		if (confirm_delete == true) {
		$.ajax({
				type:'POST',
				url:$('#path').val() + 'ajax_photo.php',
				data:'photo=' + image_path + '&directory_no=' + $('#directory_no').val(),
				success:function() {
					$("#photo_table tr .remove input[value=" + image_path + "]").parent().parent().fadeOut(500,function() {
					$(this).remove();
		});
				},
				
				complete:function(data){
					if (data.responseText == 0) {
						$('#image_paging').hide();
					}
				}					
			});
		} else {
			return false;
		}
		
	});
	
	//For directory page toggle
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		var attr_id = $(this).attr("id");
		if (attr_id == 'msg_head_create') {
			$('#msg_body_rename').hide();
			$('#msg_body_remove').hide();			
			$.ajax({
				type:'POST',
				url: $('#path') .val() + 'ajax_create_dir.php',
				data:'directory=' + $('#directory').val() + '&dir_option=null'  + '&dirname=' + $('#dirname').val(),
				
				complete:function(data){
					 var img = "<img src='" + $('#path') .val() + "ajax-loader.gif'/>";
					 $("#create_dir").empty().html(img);
					 $('#create_dir').html(data.responseText);
				}				
				
			});			
		}
		
		if (attr_id == 'msg_head_rename') {
			$('#msg_body_create').hide();
			$('#msg_body_remove').hide();				
			$.ajax({
				type:'POST',
				url: $('#path') .val() + 'ajax_rename_dir.php',
				data:'directory=' + $('#directory').val() + '&dir_option=null'  + '&dirname=' + $('#dirname').val(),
				
				complete:function(data){
					 var img = "<img src='" + $('#path') .val() + "ajax-loader.gif'/>";
					 $("#rename_dir").empty().html(img);
					 $('#rename_dir').html(data.responseText);
				}				
				
			});			
		}	
		
		if (attr_id == 'msg_head_remove') {
			$('#msg_body_create').hide();
			$('#msg_body_rename').hide();					
			$.ajax({
				type:'POST',
				url: $('#path') .val() + 'ajax_remove_dir.php',
				data:'directory=' + $('#directory').val() + '&dir_option=null'  + '&dirname=' + $('#dirname').val(),
				
				complete:function(data){
					 var img = "<img src='" + $('#path') .val() + "ajax-loader.gif'/>";
					 $("#remove_dir").empty().html(img);
					 $('#remove_dir').html(data.responseText);
				}				
				
			});			
		}		
		
		$(this).next(".msg_body").slideToggle(100);
	});	
});