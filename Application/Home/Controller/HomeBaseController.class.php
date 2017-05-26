<?php
namespace Home\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class HomeBaseController extends BaseController {
    //初始化方法
    function _initialize(){
        $this->pro_name = C('PRO_NAME');
    }

    public function _empty(){
        $this->redirect('Index/index');
    }
}

