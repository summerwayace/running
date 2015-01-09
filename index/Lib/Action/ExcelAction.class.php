<?php 

/**
 * 作者：summer
 */

/**
 * ExcelAction
 *
 * @author summer
 */
class ExcelAction extends BaseAction {
	public function __construct()
	{
		import('@.Org.ExcelToArray');//导入excelToArray类
		import('@.Org.PHPExcel');
	}

	public function index()
	{
		$this->display();
	}
	
	public function getData($file_name,$file_type){
	
		$savePath =  './Public/Upload/';
		$ExcelToArrary=new ExcelToArrary();//实例化
		$res=$ExcelToArrary->read($savePath.$file_name,"UTF-8",$file_type);
		return $res;
	}
	
	public function export(){
		$data=$_SESSION['file_export'];
		$title = '晨跑数据';
		$filename = '晨跑数据';
		$type = '2003';
		$fields = array('stu_no','date','start_time','finish_time','running','status');
		$head = array('学号','日期','开始时间','结束时间','跑步时间','状态');

		unset($_SESSION['excel']);
		unset($_SESSION['file_export']);
		
		error_reporting(E_ALL); //开启错误
		set_time_limit(0); //脚本不超时
		date_default_timezone_set('Europe/London'); //设置时间
		
		$objPHPExcel = new PHPExcel();
		$objActSheet = $objPHPExcel->getActiveSheet();
		
		$objPHPExcel->getProperties()->setCreator($_SESSION['teacher_info']['tea_name'])
		->setLastModifiedBy($_SESSION['teacher_info']['tea_name'])
		->setTitle($title)
		->setSubject($title)
		->setDescription("NULL")
		->setKeywords("")
		->setCategory("Excel");
		// Add some data
		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		//$title=array('7位课号','考核方式','课程负责人','教材');
		//$field=array('si_sid','tea_name','si_mode','tb_name');
		// $options=array('cet4_id','cet4_en','cet4_cn','cet4_day')
		 
		//设置默认行高
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
		//设置表头行高
		$objActSheet->getRowDimension(1)->setRowHeight(32);
		 
		// dump($data);
		$i = 2;
		$j = 0;
		if($data){
			 
			foreach ($data as $key => $value) {
				$newobj =  $objPHPExcel->setActiveSheetIndex(0);
				 
				for($j=0;$j<count($head);$j++){
					$index = $letter[$j]."$i";
					if( $value[$fields[$j]]=="1"){
						$value[$fields[$j]]="早退";
					}else if($value[$fields[$j]]=="2") {
						$value[$fields[$j]]="未完成";
					}else if($value[$fields[$j]]=="3") {
						$value[$fields[$j]]="完成";
					}
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($index, $value[$fields[$j]]);
				}
				$i++;
			}
		}
		//设置格式
		$style_obj = new PHPExcel_Style();
		$style_array = array(
				'borders' => array(
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
				),
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
				)
		);
		$style_obj->applyFromArray($style_array);
		$j=$j-1;$i=$i-1;
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($style_obj, "A1:".$letter[$j]."$i");
		
		//设置EXCEL表头
		foreach($head as $k=>$val){
			$index=$letter[$k].'1';
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($index, $val);
			//设置列宽
			$objActSheet->getColumnDimension($letter[$k])->setWidth(20);
			//设置字体大小
			$objPHPExcel->getActiveSheet()->getStyle($letter[$k].'1')->getFont()->setSize(12);
			//设置粗体
			$objPHPExcel->getActiveSheet()->getStyle($letter[$k].'1')->getFont()->setBold(true);
		}
		$date = date('Y-m-d',time());
		
		//excel标签设置
		$objActSheet->setTitle($title);
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		if($type == '2007') { //导出excel2007文档
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		} else {  //导出excel2003文档
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		
		}

    }

}
