<?php 
return array(
		'DB_TYPE'=>'mysql',
		'DB_NAME'=>'run',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'',
		'DB_USER'=>'root',
		'DB_PWD'=>'',
		
		'UPLOAD_DIR' => './Public/Upload/', //上传文件路径（后台使用）
		'TMPL_PARSE_STRING' => array(
				'__JS__' => '/Public/js', //JS目录
				'__CSS__' => '/Public/Css', //样式目录
				'__IMG__' => '/Public/Images', //图片目录
				'__THM__' => '/Public/Themes', //主题目录
				'__UP__' => '/Public/Upload', //上传文件目录(前台使用)
				'__DOWN__' => '/Public/Download', //下载文件目录
	),
);



?>