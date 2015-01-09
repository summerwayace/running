<?php

class IndexAction extends BaseAction {

	public function index(){
		$this->assign('title','easyui-datagrid');
		$this->assign('title','晨跑信息管理中心');
		$this->display();
	}
	
	public function home(){
		$this->assign('title','晨跑信息统计');
		$this->display();
	}
	
	//获取导入的9位课号信息(prime)
	public function getData(){
		$info = M('info');
		//分页条件
		$page=$_POST['page'];
		$rows=$_POST['rows'];
		//排序条件
		$sort=$_POST['sort'];
		$order=$_POST['order'];
		
		if(isset($this->condition['start_time'])){
			if($this->condition['start_time'][1][0]=='elt'){
				$tarr = explode("-",$this->condition['start_time'][1][1]);
				$tarr[2] = strval(intval($tarr[2])+1);
				$this->condition['start_time'][1][1] = join("-",$tarr);
				
			}
		}
		
		$firstRow=($page-1)*$rows;
		$listRows=$rows;
		$infoList = $info->where($this->condition)->order($sort.' '.$order)->limit($firstRow.','.$listRows)->select();  //分页显示控制
		$count= $info->where($this->condition)->order($sort.' '.$order)->count();
		$_SESSION['file_export']=$info->where($this->condition)->order($sort.' '.$order)->select(); ;
		$this->returnGridData($infoList,$count);
	}
	
	//excel导入(prime)
	public function excel_add(){
		$file = $_FILES ['file_stu'] ['tmp_name'];
		$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
		//文件类型
		$file_type = $file_types [count ( $file_types ) - 1];
		//以时间来命名上传的文件
		$str = date ( 'Ymd' );
		$file_name = $str . "." . $file_type;
		//判断文件类型
		$result=excel_file($file,$file_type,$file_name);
		//$result=1 上传excel到服务器成功
		if($result==-1){
			$this->error('上传文件不是excel文件');
		}else if($result==0){
			$this->error('上传文件失败');
		}
		 
		//获取excel内容
		$excel = new ExcelAction();
		$list = $excel ->getData($file_name,$file_type);
		
		if(!empty($list)){
			
			$source = M('source');//M方法
			$info = M('info');
			//清空source表
			$source->execute("TRUNCATE table source");
			
			//excel数据
			foreach ( $list as $k => $val) //循环excel表
			{
				if(!empty($val[1])){
					$data['sno'] = trim($val[1]);
					$data['ymd'] = trim($val[2]);
					$data['hms'] = trim($val[3]);
					$source->add($data);
				}
				
			}
			
			$slist = $source->order('ymd,sno,hms asc')->select();
			for($i=0;$i<count($slist);){
				unset($data);
				$data['stu_no'] = $slist[$i]['sno'];
					
				$time = $slist[$i]['ymd']." ".$slist[$i]['hms'];
				$data['start_time'] = $time;
				$data['date'] = $slist[$i]['ymd'];
				
				if($slist[$i]['ymd']==$slist[$i+1]['ymd']&&$slist[$i]['sno']==$slist[$i+1]['sno']){
					
					$flag=true;
					$n=2;
					while($flag){	
						if($slist[$i]['ymd']==$slist[$i+$n]['ymd']&&$slist[$i]['sno']==$slist[$i+$n]['sno']){
							$n++;
						}else{
							$time = $slist[$i+$n-1]['ymd']." ".$slist[$i+$n-1]['hms'];
							$data['finish_time'] = $time;
							$flag=false;
						}
					}
					$data['running']  = $this->getRunning($data['start_time'],$data['finish_time']);
					$data['status']  = $this->getStatus($data['start_time'],$data['finish_time']);
					
					$i += $n;
					
				}else{
					$data['status'] = 1;
					$i++;
				}
				
				$info->add($data);
				
				
			}

			$this->success('数据导入成功'.$msg);
		}else{
			//$this->error('excel没有可用数据');
		}
	}
	
	protected function getRunning($start,$end){
		$hour=floor((strtotime($end)-strtotime($start))%86400/3600);
		$minute=floor((strtotime($end)-strtotime($start))%86400/60);
		$second=floor((strtotime($end)-strtotime($start))%86400%60);
		$running = $hour.":".$minute.":".$second;
		return $running;
	}
	
	protected function getStatus($start,$end){
		$hour=floor((strtotime($end)-strtotime($start))%86400/3600);
		$minute=floor((strtotime($end)-strtotime($start))%86400/60);
		if($hour<=0){
			if($minute>9)
				$status=3;
			else
				$status = 2;
		}else{
			$status = 3;
		}

		return $status;
	}
	
}