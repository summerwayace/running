<?php

function excel_file($file,$file_type,$file_name){

	$tmp_file = $file;
	//判别是不是.xls文件，判别是不是excel文件
	if (strtolower ( $file_type ) != "xlsx" && strtolower ( $file_type ) != "xls")
	{
		//$this->returnStatus(false, $_FILES ['file_stu'] ['tmp_name']);
		//$this->error('上传文件不是excel文件');
		return -1;
	}

	//设置上传路径
	$savePath =  './Public/Upload/';

	//是否上传成功
	if (! copy ( $tmp_file, $savePath . $file_name ))
	{
		//$this->returnStatus(false, '上传失败');
		//$this->error('上传失败');
		return 0;
	}else{
		return 1;
	}
}


?>
