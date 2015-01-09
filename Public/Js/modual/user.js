var datagrid,viewDialog;
	var editRow ;
	//添加事件
	var addView = function() {
		if(editRow==undefined){
			changeEditorAddrow();
			$('#dg').datagrid('insertRow',{
				index:0,
				row:{
					user_name:'input your username',
					user_pwd:'input your password',
					user_email:'input your email'
				}
			});

			$('#dg').datagrid('beginEdit',0);
			editRow=0;	
		}else{
			alert('请保存数据');
		}
	};

	//编辑事件
	var editView = function(){
		rows= $('#dg').datagrid('getSelections');
		if(rows.length<1){
			alert('请选择编辑行');
		}else if(rows.length>1){
			alert('请只选择一行编辑')
		}else{
			changeEditorEditrow();
			if(editRow==undefined){
				var index =$('#dg').datagrid('getRowIndex',rows[0]);
				$('#dg').datagrid('beginEdit',index);
				editRow=index;

			}else{
				alert('请保存数据');
			}
		}
	};

	//删除事件
	var delView = function(){
		rows= $('#dg').datagrid('getSelections');
		if(rows.length>0){
			$.messager.confirm('确认','确定要删除当前选中的项目',function(b){
				if(b){
					var ids=[];
					for(var i=0;i<rows.length;i++){
						ids.push(rows[i].user_id);
					}
					console.info(ids.join(','));
					$.ajax({
				        type: "POST",   //重点
				        url: '__URL__/todelete',
				        data:{ids:ids.join(',')},
				        dataType:'json',
				        success:function(r){
				        	if(r&&r.status){
				        		$('#dg').datagrid('load');
				        		$.messager.show({
				        			msg: r.msg,
				        			title:'成功'
				        		});
				        	}else{
				            	//
				            }
				            $('#dg').datagrid('unselectAll');
				        }
				    })

				}
			})

		}else{
			$.messager.alert('提示','请选择要删除的行','warning');
		}
		};

	$(function(){

		$('#dg').datagrid({
			url: '__URL__/getData',
			title: 'user' ,
			iconCls : 'icon-save' ,
			pagination: true  ,//是否显示分页
			pageSize :10 ,
			fit :true ,
			fitColumns :true, //横向滚动条（列多的时候不用设置）
			sortName:'user_id',
			sortOrder:'desc',

			columns:[[  
				{field:'user_id',title:'ID',sortable:true,checkbox:true},
        		{field:'user_name',title:'用户名',width:100,align: 'center',sortable:true,},  
        		{field:'user_pwd',title:'密码',width:100,align: 'center',sortable:true},
        		{field:'user_email',title:'电子邮箱',width:100,align: 'center'},
        		{field:'user_createtime',title:'修改时间',width:130,align: 'center'} 
    		]],
    		toolbar: [{
                text: '新增',
                iconCls: 'icon-add',
                handler: addView
            }, '-',{
                text: '删除',
                iconCls: 'icon-remove',
                handler: delView
            },  '-',{
                text: '修改',
                iconCls: 'icon-edit',
                handler: editView
            },'-', {
                text: '保存',
                iconCls: 'icon-save',
                handler: function(){
                	if(editRow!=undefined){
                		$('#dg').datagrid('endEdit',editRow);
                	}	
                }
            },'-', {
                text: '取消编辑',
                iconCls: 'icon-redo',
                handler: function(){
                	editRow=undefined
                	$('#dg').datagrid('rejectChanges');
                	$('#dg').datagrid('unselectAll');
                	
                }
            }] ,
            onAfterEdit:function(rowIndex, rowData, changes){
            	var inserted=$('#dg').datagrid('getChanges','inserted');
            	var updated = $('#dg').datagrid('getChanges','updated');
            	var url='';
            	if(inserted.length>0){
            		url='__URL__/toadd';
            		console.info(inserted);
            	}
            	if(updated.length>0){
            		url='__URL__/toedit'
            		//console.info(updated);
            	}
            	if(url==''){
            		editRow=undefined;
            		$('#dg').datagrid('unselectAll');
            		return;
            	}
            	$.ajax({
            		type: "POST",   //重点
            		url: url,
            		data:rowData,
            		dataType:'json',
            		success:function(r){
            			if(r&&r.status){
            				$('#dg').datagrid('acceptChanges');
            				$('#dg').datagrid('reload');
            				$.messager.show({
            					msg: r.msg,
            					title:'成功'
            				});
            			}else{
            				$('#dg').datagrid('rejectChanges');
            				$.messager.alert('错误',r.msg,'error');
            			}
            			editRow=undefined;
            			$('#dg').datagrid('unselectAll');
            		}
            	})
            	//console.info(rowData);
            	
            },
            //双击编辑事件
            onDblClickRow: function(rowIndex,rowData){
            	changeEditorEditrow();
            	if(editRow==undefined){
            		$('#dg').datagrid('beginEdit',rowIndex);
            		editRow=rowIndex;

            	}else{
                	alert('请保存数据');
                }
            },
            //右击事件
            onRowContextMenu:function(e,rowIndex,rowData){
            	e.preventDefault();
            	$(this).datagrid('unselectAll');
            	$(this).datagrid('selectRow',rowIndex);
            	$('#rcmenu').menu('show',{
            		left: e.pageX,
            		top: e.pageY
            	});
            }

		});

		//动态定义添加列
		changeEditorAddrow=function(){
			$('#dg').datagrid('addEditor',[{
				field:'user_name',
				editor:{
					type:'validatebox',
					options:{
						required:true
					}
				}
			},{
				field:'user_pwd',
				editor:{
					type:'validatebox',
					options:{
						required:true
					}
				}
			},{
				field:'user_email',
				editor:{
					type:'validatebox',
					options:{
						required:true
					}
				}
			}]
			);
			$('#dg').datagrid('removeEditor','user_createtime');

		};
		//动态定义编辑列
		changeEditorEditrow=function(){
			$('#dg').datagrid('removeEditor','user_pwd');
			$('#dg').datagrid('addEditor',[{
				field:'user_name',
				editor:{
					type:'validatebox',
					options:{
						required:true
					}
				}
			},{
				field:'user_email',
				editor:{
					type:'validatebox',
					options:{
						required:true
					}
				}
			},{
				field:'user_createtime',
				editor:{
					type:'datetimebox',
					options:{
						required:true
					}
				}
			}]
			);
		};
		$('#dg2').datagrid({
			url: '',
			title: 'class' ,
			iconCls : 'icon-edit' ,
			pagination: true  ,//是否显示分页
			pageSize :10 ,
			fit :true ,
			fitColumns :true, //横向滚动条
			columns:[[  
        		{field:'code',title:'Code',width:100},  
        		{field:'name',title:'Name',width:100},  
        		{field:'price',title:'Price',width:100} 
    		]]  
		});

		
	});

	//数组序列化对象
	serializeObject = function (form){
		var o={};
		console.info(form.serializeArray());
		$.each(form.serializeArray(),function(index){
			if(o[this['name']]){
				o[this['name']]=o[this['name']]+","+this['value'];
			}else{
				o[this['name']]=this['value'];
			}
		})
		return o;
	}
	//查询按钮点击事件
	usersearch　=function(){
		if(editRow==0){
			alert('先保存数据，或取消编辑');
		}else{
			var searchform = $('#user_searchForm');
		$('#dg').datagrid('load',serializeObject(searchform));
		}
		
	};
	//清空按钮点击事件
	info_clear = function(){
	//	$('#user_searchForm').form('clear');
		if(editRow==0){
			alert('先保存数据，或取消编辑');
		}else{
			$('#user_searchForm').find('input').val('');
		$('#dg').datagrid('load',{});
		}
		
	};