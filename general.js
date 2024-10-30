function mbp_io_jump_directory(jurl,dirno){
	window.location=jurl+'&d='+dirno;
}

function mbp_io_jump_file(jurl,dirno,filenopage){
	var vals=filenopage.split("-");
	window.location=jurl+'&d='+dirno+'&p='+vals[1]+'&f='+vals[0];
}
