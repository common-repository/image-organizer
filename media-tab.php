<?php
/* Popop Tab */

add_filter('media_upload_tabs', 'imageorganizer_wp_upload_tabs'); 
add_action('media_upload_imageorganizer', 'media_upload_imageorganizer');

function imageorganizer_wp_upload_tabs ($tabs) {
	$newtab = array('imageorganizer' => __('Image Organizer','nggallery'));
    return array_merge($tabs,$newtab);
}

function media_upload_imageorganizer() {
	return wp_iframe( 'media_upload_imageorganizer_form', $errors );
}

/* Main core file 
-- drop down tab. 
-- Image listing.
 */
function media_upload_imageorganizer_form($errors) {
	media_upload_header();
	$post_id 			= intval($_REQUEST['post_id']);
	$page				= isset($_REQUEST['p'])?intval($_REQUEST['p']):1;
	$current_dir 		= isset($_REQUEST['current_dir'])?intval($_REQUEST['current_dir']):0;
	$directory_lists 	= mbp_io_dirs();
	$directory_jump_js  = " onchange=\"form1.submit();\" ";
	$files 				= new MbpFilelist;
	$files->path		= mbp_original_dir() . mbp_io_windows_path($directory_lists[$current_dir]);
	$files->list 		= 30;
	$files->get_directory_files();
	$files->page = $page;
	$file_list 	 = $files->get_directory_page();
?>
<script type="text/javascript">
	function post_url(image_url) {
		document.getElementById('hidden_image_url').value = image_url;
		document.form_image.submit();
		return true;
	}
</script>
<form name="form1" method="post" action="">
<?php print mbp_io_generate_list("current_dir",$directory_lists,$current_dir,$directory_jump_js);?>
</form>
<?php if (sizeof($file_list) > 0) { 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hidden_image_url'])) {
	$image = $_POST['hidden_image_url'];
	$html = "<img src='{$image}'/>";
	return media_send_to_editor($html);
}
?>
<form name="form_image" method="post" action="">
<input type="hidden" id="hidden_image_url" name="hidden_image_url" value="" />
<table>
<?php 
foreach($file_list as $flno => $file) { 
	$thumb_url   = MBP_IO_LIBPATH . "/image.php?m=t&p=".urlencode(mbp_original_dir() .$directory_lists[$current_dir])."&f=".urlencode($file[name]);	
	$image_full_url = UPLOAD_URL . $directory_lists[$current_dir] . '/' .  $file[name];	
?>
	<tr>
		<td width="42">
		<img src="<?php echo $thumb_url;?>" />		</td>
		<td width="242"><?php echo $file[name];?></td>
		<td width="142">
			<input type="hidden" id="image_url" name="image_url" value="<?php echo $image_full_url;?>" />			
			<input class="button" onclick="javascript:return post_url('<?php echo $image_full_url;?>');" type="button" name="btl_post" value="Insert in post" />
			</td>
	</tr>	
<?php } ?>	
</table>
</form>
<?php
	} else {
?>	
		<div style="margin:0 0 0 10px">No Image Found</div>
<?php } ?>
<?php } ?>
