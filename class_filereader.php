<?php
class MbpFilelist{
	var $path;
	var $list=10;
	var $extensions='jpg png gif';
	var $file_list=array();
	var $page=1;
	var $tpages=0;
	var $tfiles=0;
	function CheckExt($filename, $ext){
		$passed = FALSE;
		$testExt = "\.".$ext."$";
		if (eregi($testExt, $filename)){
			$passed = TRUE;
		}
		return $passed;
	}
	function get_directory_files(){
		$file_array=array();
		$file_count=1;
		$scan_ext = explode(" ",$this->extensions);
		if ( substr($this->path, -1) != '/') $this->path.= '/';
				if ($handle = opendir($this->path)) { 
		   while (false !== ($file = readdir($handle))) { 
				if ( !($file == "." || $file == ".." || is_dir($this->path.$file)) ) { 
					foreach ($scan_ext as $value) {
						if ($this->CheckExt($file, $value)) {
							$file_array[$file_count]["name"]=$file;
							$file_array[$file_count]["time"]=filemtime($this->path.$file); 
							$file_array[$file_count]["size"]=filesize($this->path.$file);
							$file_array[$file_count]["write"]=is_writable($this->path.$file);
							$file_count++;
							break; 
						}
					}
				}
		   } 
		}
		sort($file_array); 
		$this->file_list=$file_array;
		$this->tfiles=count($this->file_list);
		$this->tpages =floor($this->tfiles/$this->list)<($this->tfiles/$this->list)?floor($this->tfiles/$this->list)+1:floor($this->tfiles/$this->list);
	}
	function get_directory_page(){
		if($this->page > 0 && $this->page <= $this->tpages){
			$start_from = (($this->page-1) * $this->list);
			$end_to = $this->page * $this->list;
			if ($end_to > $this->tfiles) {
				$end_to=$this->tfiles;
			}
			return array_slice($this->file_list,$start_from,$end_to-$start_from);      
		}else{
			return array();
		}
	}
	function get_file_index($filename){
		foreach ($this->file_list as $key => $value) {
			if($value[name]==$filename){
				return $key;
			}
		}
		return 0;
	}
	function get_file($file_no){
		$file_no=$file_no+1;
		if($file_no > 0 && $file_no <= $this->tfiles){
			return array_slice($this->file_list,$file_no-1,1);  
		}
	}
	function get_file_page($file_no){
		$file_no=$file_no+1;
		return floor($file_no/$this->list)<($file_no/$this->list)?floor($file_no/$this->list)+1:floor($file_no/$this->list);
	}
	
	function get_file_loc($file_no){
		$file_no=$file_no+1;
		return ($file_no-(($this->get_file_page($file_no - 1) - 1) * $this->list))-1;
	}
}
?>