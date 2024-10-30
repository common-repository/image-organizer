<?php 
$page				= isset($_REQUEST['p'])?intval($_REQUEST['p']):1;
$current_dir 		= isset($_REQUEST['d'])?intval($_REQUEST['d']):0;
$directory_lists 	= mbp_io_dirs();
$files 				= new MbpFilelist;
$files->path		= mbp_original_dir() . mbp_io_windows_path($directory_lists[$current_dir]);
$files->list 		= 20;
$files->get_directory_files();
$files->page = $page;
$file_list 	 = $files->get_directory_page();

$this_page_url 		= "?page=image-organizer";
$view_page_url 		= "?page=image-organizer/page/view.php";
$directory_jump_js  = " onchange=\"mbp_io_jump_directory('$this_page_url',this.value);\" ";
?>
<script type="text/javascript" src="<?php echo MBP_IO_LIBPATH . 'page/wz_tooltip.js'?>"></script>
<style type="text/css">
<!--
.style1 {
	color: #0066CC;
	font-weight: bold;
	background-color:#f1f1f1;
	height:33px;
}
-->
</style>
<div class="wrap">
<h2><?php echo MBP_IO_NAME.' '.MBP_IO_VERSION; ?></h2>
<br/>
<strong><img src="<?php echo MBP_AIT_LIBPATH;?>image/how.gif" border="0" align="absmiddle" /> <a href="http://wordpress.org/extend/plugins/image-organizer/other_notes/" target="_blank">How to use it</a>&nbsp;&nbsp;&nbsp;
		<img src="<?php echo MBP_AIT_LIBPATH;?>image/comment.gif" border="0" align="absmiddle" /> <a href="http://www.maxblogpress.com/forum/forumdisplay.php?f=29" target="_blank">Community</a></strong>
<br/>
<br/>	

<table border="0" width="100%" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5">
     <tr >
   <td colspan="2" style="padding:4px 4px 4px 4px;background-color:#f1f1f1;">
   		<strong>
			BACK >> <a href="?page=image-organizer">Home Page</a>
			&nbsp;&nbsp; | <INPUT type="button" value="Manage Directory" onclick="window.location='?page=image-organizer.php&action=dir'">
		</strong>
   </td>
  </tr>
</table>
<br/>

<div class="tablenav">
	<div class="alignleft actions">
		<?php print mbp_io_generate_list("current_dir",$directory_lists,$current_dir,$directory_jump_js); 
		?>
		
		<input value="Upload to directory" type="button" onclick="window.location.href='?page=image-organizer&d=<?php echo $current_dir;?>&action=upload'" />
		
	</div>
</div>
<div class="clear"></div>

<form name="form1">
<input type="hidden" id="directory_no" name="directory_no" value="<?php echo $current_dir;?>" />
 <input type="hidden" name="path" id="path" value="<?php echo MBP_IO_LIBPATH . 'page/';?>"/>
<table width="100%" border="0" cellpadding="2" cellspacing="4" id="photo_table" style="border:1px solid #e5e5e5">
	<tr>
	  <td width="9%" class="style1"><div align="center">Delete</div></td>
	<td width="11%" class="style1"><div align="center">S.no</div></td>
	<td width="17%" class="style1"><div align="left">File Name</div></td>
	<td width="40%" class="style1" align="center">Size</td>
	<td width="23%" class="style1" align="center">Action</td>
	</tr>
	<tbody>

<?php 
$row = 0;
$i = 0;
foreach($file_list as $flno => $file) { 
		$row++;
		$row_bgcolor = ($row%2 == 0)?' #FFF' : '#CCC';
		$thumb_url   = MBP_IO_LIBPATH . "/image.php?m=t&p=".urlencode(mbp_original_dir() .$directory_lists[$current_dir])."&f=".urlencode($file[name]);
		//get image information
		$image_path = mbp_original_dir() .$directory_lists[$current_dir] . '/' . $file[name];
		list($width, $height, $type, $attr) = getimagesize($image_path);
		$image_info = 'Image Width:' . $width . '<br/>';
		$image_info.= 'Image Height:' . $height . '<br/>';
		$image_info.= 'Date:' . date("F j, Y, g:i a",$file["time"]) . '<br/>';
		
?>
<tr id="link-2" valign="middle" bgcolor="<?php echo $row_bgcolor; ?>">
  <th scope="row" class="remove column-rel"><input id="del" type="checkbox" name="del" value="<?php echo mbp_original_dir() .$directory_lists[$current_dir] . '/' .  $file[name];?>" /></th>
  <th scope="row" class="check-column"><div align="center"><?php echo $row;?></div><div align="center"></div></th>
  <td class="column-name"><strong><a class='row-title' href='#' onmouseover="Tip('<?php echo $image_info; ?>');" onmouseout="UnTip();" >
  		<img border="0" src="<?php echo $thumb_url; ?>"/>
  </a></strong><br />  </td><td class="column-categories" align="center">
  <?php echo number_format($file["size"]/1024)." KB";?>
  </td>
  <td class="column-rel"  align="center"><span class="column-visible"><a href="?page=image-organizer.php&action=resize&d=<?php echo $current_dir;?>&image=<?php echo $file[name];?>">Resize</a></span></td>  
  </tr>
<?php } ?>	
	</tbody>
</table>
</form>


<?php if (sizeof($file_list) == 0) { ?>
	<div class="message" align="center">No Image uploaded</div>
<?php } ?>

<?php if (sizeof($file_list) > 0) { ?>
<br/>
<br/>
<table id="image_paging" width="100%" border="0" bgcolor="#f1f1f1" style="border:1px solid #e5e5e5" cellspacing="1" cellpadding="4">
		  <tr>
		    <td width="33%" align="center"><?php if ($page-1 > 0){?><a href="<?php print $this_page_url."&p=".($page-1)."&d=".$current_dir;?>" class="edit">previous</a><?php }else{ ?>&nbsp;<?php }?></td>
		    <td width="33%" height="30" align="center"><?php  _e('Page','organizer'); ?> <?php print $page; ?> <?php _e('of','organizer');?> <?php print $files->tpages;?></td>
		    <td width="33%" align="center"><?php if ($page+1 <= $files->tpages){?><a href="<?php print $this_page_url."&p=".($page+1)."&d=".$current_dir;?>" class="edit">next</a><?php }else{ ?>&nbsp;<?php }?></td>
		  </tr>
		</table>
<?php } ?>

<br/>
<div align="center" style="background-color:#f1f1f1; padding:5px 0px 5px 0px" >
<p align="center"><strong><?php echo MBP_IO_NAME.' '.MBP_IO_VERSION; ?> by <a href="http://www.maxblogpress.com" target="_blank">MaxBlogPress</a></strong></p>
<p align="center">This plugin is the result of <a href="http://www.maxblogpress.com/blog/219/maxblogpress-revived/" target="_blank">MaxBlogPress Revived</a> project.</p>
</div>
</div><!-- wrap ends -- >

