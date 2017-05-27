<?php
namespace Api\Controller;
use Think\Model;

class UserController extends ApiBaseController  {

    //发送短信验证码
    public function sendVCode(){
        $phone = I('post.phone');
        $type = I('type',0);
        $vcode = noRand(6);
        if(check_phone($phone)){
            $result = sendVCode($phone,$vcode,$type);
            if($result['errorCode']==0){
                request_result('发送成功', 0);
            }else{
                request_result('发送失败'.$result['msg'], 1);
            }
        }else{
            request_result('手机号码格式错误',1);
        }
    }

    //检查短信验证码是否正确
    public function checkVCode(){
        $phone = I('post.phone');
        $v_code = I('post.v_code');
        if(check_phone($phone)){
            $query = checkCode($phone,$v_code);
            request_result($query['msg'],$query['errorCode']);
        }else{
            request_result('手机号码格式错误',1);
        }
    }

}
