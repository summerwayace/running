<?php

class GlobalAction extends BaseAction {

    /**
     * 初始化入口
     */
    function _initialize() {
       
    }


    function SaveOptions() {
        $tmeValue = $_POST['value'];
        if(!empty($tmeValue)){
        	$_SESSION['theme']=$tmeValue;
        	$this->returnStatus(true);
        }else{
        	$this->returnStatus(false);
        }
        
    }

}
?>