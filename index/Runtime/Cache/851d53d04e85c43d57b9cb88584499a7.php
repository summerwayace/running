<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<head>
<meta charset="utf-8">
<title><?php echo ($title); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="__ROOT____IMG__/ky.ico" />

<!-- Le styles -->
<style type="text/css">

</style>
<!-- Css 导入 -->
<link href="__ROOT____CSS__/bootstrap.min.css" rel="stylesheet"
    media="screen">
<link href="__ROOT____CSS__/bootstrap-responsive.min.css" rel="stylesheet">
<link  id="easyuiTheme" href="__ROOT____THM__/bootstrap/easyui.css" rel="stylesheet" type="text/css" media="screen" >
<link href="__ROOT____THM__/icon.css" rel="stylesheet">

<!-- Js 导入 -->
<script src="__ROOT____JS__/core/jquery-1.8.0.min.js"></script>
<script src="__ROOT____JS__/core/bootstrap.min.js"></script>
<script src="__ROOT____JS__/core/jquery.easyui.min.js"></script>
<script src="__ROOT____JS__/locale/easyui-lang-zh_CN.js"></script>
<script src="__ROOT____JS__/core/myjs.js"></script>

<script>
    var _THEME_PATH_ = '__ROOT____THM__';
</script>
<script language="javascript" type="text/javascript"> 

</script>
<script type="text/javascript" src="__ROOT____JS__/common/global.js"></script>




</head>
<body class="easyui-layout">  
    <div data-options="region:'north'" href="north.html" style="height:50px;"></div>  
    <div data-options="region:'south'" href="foot.html" style="height:100px;"></div>  
    </div>  
    <div id="index_layout_center" data-options="region:'center',title:'欢迎'" style="background:#eee;"
    	href="home.html"></div>  
</body> 
</html>