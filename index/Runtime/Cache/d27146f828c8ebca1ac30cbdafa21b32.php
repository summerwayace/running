<?php if (!defined('THINK_PATH')) exit();?><script language="javascript" type="text/javascript"> 
$(function() {
    //主题切换
    $('.theme').click(function() {
        name = $(this).attr('name');
        var $easyuiTheme = $('#easyuiTheme');
        $.post('__APP__/Global/SaveOptions', {value: name}, function(rsp) {
            if (rsp.status) {
                var href = '__ROOT____THM__/' + name + '/easyui.css';
                $easyuiTheme.attr('href',href);
                var $iframe = $('iframe');
                if ($iframe.length > 0) {
                    for ( var i = 0; i < $iframe.length; i++) {
                        var ifr = $iframe[i];
                        $(ifr).contents().find('#easyuiTheme').attr('href', href);
                    }
                }
            } else {
                $.alert(rsp.msg);
            }
        }, "JSON");

    });

});
</script>
<div style="position: absolute;right: 0;bottom: 0;">
    <a href"javascript:void(0);" class="easyui-menubutton" menu="#north_menu" iconCls="icon-help">控制面板</a>
</div>

<div id="north_menu" style="display: none; width:135px">  
    <div data-options="iconCls:'icon-user'" onclick="">个人信息</div>
    <div data-options="iconCls:'icon-setting'" onclick="">个人设置</div>
    <div data-options="iconCls:'icon-theme'">
        <span>主题切换</span>
        <div style="width:100px;">  
            <div class="theme" name="default" >default</div>  
            <div class="theme" name="bootstrap" >bootstrap</div>  
            <div class="theme" name="black" >black</div>  
            <div class="theme" name="gray" >gray</div>
            <div class="theme" name="metro" >metro</div>
        </div> 
    </div>
    <div class="menu-sep"></div> 
    <div data-options="iconCls:'icon-lock'" ><a href="__ROOT__/index.php/" >返回前台</a></div>
    <div data-options="iconCls:'icon-exit',href:''">退出系统</div>
</div>