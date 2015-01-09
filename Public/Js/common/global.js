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
