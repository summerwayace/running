<?php
class BaseAction extends Action {

   // public $page = 1;
   // public $rows = 20;
   // public $order;
    public $condition = array();

    /**
     * 初始化入口
     */
    function _initialize() {
    	//redirect(__APP__ .'/Index/index');
    	$this->_bulidPParams();
    }

    /**
     * 查询参数工厂
     */
   	private function _bulidPParams() {
    	//Q_paramName_EQ_AND
    	foreach ($_POST as $key => $value) {
    		if (strncmp('Q_', $key, 2) == 0 && !empty($value)) {
    			$info = explode('_', $key);
    			if (count($info) == 3) {
    				//$this->addCondition($info[1].'_'.$info[2], $value);
    				$this->condition[$info[1]]=array($info[2],$value. '%');
    			} else if (count($info) > 3) {
    				$cnd = $info[3];
    				if (strripos($cnd, 'like') !== false) {
    					$c = substr_count($cnd, '%');
    					if ($c > 0 && $c == 1) {
    						if (strpos($cnd, '%') == 0) {
    							$value = '%' . $value;
    						} else {
    							$value = $value . '%';
    						}
    					} else {
    						$value = '%' . $value . '%';
    					}
    					$cnd = str_replace('%', '', $cnd);
    				}
    
    				if (count($info) == 5) {
    					$this->addCondition($info[1].'_'.$info[2], array(array(strtolower($cnd), $value), strtolower($info[4])));
    				} else {
    					$this->addCondition($info[1].'_'.$info[2], array(strtolower($cnd), $value));
    				}
    			}
    		}
    	}
    }
    
    /**
     * 添加查询条件
     * @param type $filed 查询的字段
     * @param type $cnd  字段组装条件
     */
    private function addCondition($filed, $cnd) {
    	if (isset($this->condition[$filed])) {
    		$oldCond = $this->condition[$filed];
    		$v = array_pop($this->condition[$filed]);
    
    		if (is_array($cnd[0])) {
    			$_cnd = $cnd[0];
    			$andOr = $cnd[1];
    		} else {
    			$_cnd = $cnd;
    			$andOr = 'and';
    		}
    
    		if (count($oldCond) > 2 && is_string($v) && (strtolower($v) == 'or' || strtolower($v) == 'and')) {
    			$this->condition[$filed][] = $_cnd;
    			$this->condition[$filed][] = $andOr;
    		} else {
    			$this->condition[$filed] = array($oldCond,$_cnd,$andOr);
    		}
    	} else {
    		$this->condition[$filed] = $cnd;
    	}
    }

    /**
     * 返回执行结果
     * @param type $status
     * @param type $msg
     * @param type $data
     */
    protected function returnStatus($status = TRUE, $msg = null, $data = null) {
        parent::ajaxReturn(array('status' => $status, 'data' => $data, 'msg' => $msg), 'JSON');
    }

    /**
     * 返回grid数据
     * @param type $data
     * @param type $total
     */
    protected function returnGridData($data, $total) {
        parent::ajaxReturn(array('rows' => (empty($data) ? array() : $data), 'total' => $total), 'JSON');
    }

}

?>
