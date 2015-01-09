//让页面加载的显示等待信息
$(function(){
	$.messager.progress({
		text:'loading...',
		interval:100  //读条时间
	})
});
//页面渲染完毕关闭等待信息
$.parser.onComplete=function(){
	window.setTimeout(function(){
		$.messager.progress('close');
	},500)  
}

//扩张datetimebox
$.extend($.fn.datagrid.defaults.editors,{
	datetimebox:{
		init: function(container, options){
			var editor = $('<input/>').appendTo(container);
			options.editable = false;
			editor.datetimebox(options);
			return editor;
		},
		getValue: function(target){
			return $(target).datetimebox('getValue');
		},
		setValue: function(target,value){
			$(target).datetimebox('setValue',value);
		},
		resize: function(target,width){
			$(target).datetimebox('resize',width);
		},
		destory: function(target){
			$(target).datetimebox('destroy');
		}
	},
	combocheckboxtree:{
		init: function(container, options){
			var editor = $('<input/>').appendTo(container);
			options.multiple = false;
			editor.combotree(options);
			return editor;
		},
		getValue: function(target){
			return $(target).combotree('getValue').join(',');
		},
		setValue: function(target,value){
			$(target).datetimebox('setValue',value);
		},
		resize: function(target,width){
			$(target).datetimebox('resize',width);
		},
		destory: function(target){
			$(target).datetimebox('destroy');
		}
	}
});
//动态控制datagrid编辑项
$.extend($.fn.datagrid.methods,{
	addEditor:function(jq,param){
		if(param instanceof Array){
			$.each(param,function(index,item){
				var e=$(jq).datagrid('getColumnOption',item.field);
				e.editor = item.editor;
			});
		}else{
			var e=$(jq).datagrid('getColumnOption',param.field);
			e.editor=param.editor;
		}
	},
	removeEditor:function(jq,param){
		if(param instanceof Array){
			$.each(param,function(index,item){
				var e=$(jq).datagrid('getColumnOption',item);
				e.editor = {};
			});
		}else{
			var e=$(jq).datagrid('getColumnOption',param);
			e.editor={};
		}
	}
	
});

$.fn.toJson = function() {
    var arrayValue = $(this).serializeArray();
    var json = {};
    $.each(arrayValue, function() {
        var item = this;
        if (json[item["name"]]) {
            json[item["name"]] += "," + item["value"];
        } else {
            json[item["name"]] = item["value"];
        }
    });
    return json;
};

