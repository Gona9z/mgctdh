<?php
namespace Api\Controller;
use Api\Logic\UserLogic;

class UserController extends ApiBaseController  {
    public $userLogic;
    public function _initialize(){
        $this->userLogic = new UserLogic();
    }

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
            request_result('error number format',1);
        }
    }

    //用户登录(包含注册:未注册用户直接注册) The 4-digit code you've entered is incorrect.
    public function userLogin(){
        $account = I('account');
        $v_code = I('v_code');

    }

    //获取用户信息
    public function getUserInfo(){
        $at = I('accesstoken');
        $user = getUserInfoByAT($at);
        $data = array(
            'image'  =>  $user['image'],
            'ar_id'  =>  $user['ar_id'],
            'integral'  =>  $user['integral'],
            'nickname'  =>  $user['nicknanme'],
            'pizza'  =>  $user['pizza'],
            'account'   =>  $user['account'],
            'birthday'  =>  $user['birthday'],
            'email'     =>  $user['email'],
            'favorite_food' =>  $user['favorite_food'],
            'favorite_restaurants'  =>  $user['favorite_restaurants'],
        );
        request_result('', 0, $data);
    }

    //用户签到
    public function userSign(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->userLogic->user_sign($user_id,$merchant_id);
            request_result($query['msg'],$query['errorCode']);
        }
    }

    //餐厅签到好友列表
    public function mFriendSignList(){
        //TODO 缺少好友链表
        $at = I('accesstoken');
        $where['user_id'] = getUserIdByAT($at);
        $where['merchant_id'] = I('merchant_id');
        $page = I('page', 1);
        $list = M('UserSignCount')
            ->join('ar_user_fiend')
            ->where($where)->page($page,10)->select();
        if(empty($list)){
            request_result('load complete', 1);
        }else{
            request_result('', 0, $list);
        }
    }

    //更新心情
    public function updateEmoji(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $emoji_type = I('type');
        $param[] = array('key'=>'type','msg'=>'emoji type','is_str'=>1);
        param_validate($param);//非空判断
        $this->userLogic->update_emoji($user_id,$merchant_id,$emoji_type);
    }
}
