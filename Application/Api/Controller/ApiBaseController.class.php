<?php
namespace Api\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class ApiBaseController extends BaseController {
    //空接口
    public function _empty($name){
        request_result('接口不存在', 102);
    }

}

