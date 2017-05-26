<?php
namespace Common\Controller;
use Think\Controller;
/**
 * admin 基类控制器
 */
class BaseController extends Controller{
    /**
     * @param array $data ajaxReturn返回数据
     * @param string $msg 提示信息
     * @param int $errorCode 错误码
     */
    function request_ajaxReturn($msg='',$errorCode=0,$data=array()){
        $return_arr = array(
            'msg'   =>  $msg,
            'errorCode' =>  $errorCode,
            'data'  =>  $data,
        );
        $this->ajaxReturn($return_arr);
    }

    /**
     * 判断是否为空
     * @param array $param_arr
     * @param array $msg_arr
     */
    function empty_ajaxReturn($param_arr=array(),$msg_arr=array()){
        foreach($param_arr AS $key=>$val){
            if(empty($val)&&'0'!==$val){
                $return_arr = array(
                    'msg'   =>  (empty($msg_arr[$key])?$key:$msg_arr[$key]).'不能为空',
                    'errorCode' =>  1,
                );
                $this->ajaxReturn($return_arr);
            }
        }
    }
}

