<?php

header("Content-Type:text/html; charset=utf8");
mb_convert_encoding('中文编码转化','UTF-8','GBK');
//项目名称和路径
define('APP_NAME','index');
define('APP_PATH','./index/');
define('APP_DEBUG',TRUE); // 调试模式开启，需区分大小写
//加载框架入口文件
require '/ThinkPHP/ThinkPHP.php';

?>