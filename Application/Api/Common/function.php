<?php
/**
 * 通过accesstoken获取用户id
 */
function getUserIdByAT($at){
    $where['accesstoken'] = trim($at);
    $user = M('User')->where($where)->find();
    if(empty($user))
        request_result( "账号在其他终端登录，重新登录" , 101);
    if('1'==$user['disable'])
        request_result( "该账号已被禁用" , 104);
    return $user['user_id'];
}
/**
 * 通过accesstoken获取用户信息
 */
function getUserInfoByAT($at){
    $where['accesstoken'] = trim($at);
    $user = M('User')->where($where)->find();
    if(empty($user))
        request_result( "账号在其他终端登录，重新登录" , 101);
    if('1'==$user['disable'])
        request_result( "该账号已被禁用" , 104);
    return $user;
}
/*
 * 检查手机号码格式
 */
function check_phone($phone){
    if(!preg_match("/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|70)\\d{8}$/",$phone)){
        return false;
    }else{
        return true;
    }
}
/*
 * 发送验证码
 */
function sendVCode($account,$v_code,$type){
    $where['phone'] = $account;
    $user = M('User')->where($where)->find();
    if($type==0){
        if($user){
            return array('msg'=>',该账号已经注册过了','errorCode'=>1);
        }
    }else{
        if(empty($user)){
            return array('msg'=>',该账号还未注册','errorCode'=>1);
        }
    }
    $data['account'] = $account;
    $data['v_code'] = $v_code;
    $data['time'] = time();
    $query = M('Vcode')->where("account=$account")->find();
    if(empty($query)){
        $res = M('Vcode')->add($data);
    }else{
        $data['id'] = $query['id'];
        $res = M('Vcode')->save($data);
    }
    if (false!==$res) {
        $content = '【A梦校园】您的短信验证码为:'.$v_code.',请于20分钟内进行验证';
        $tkey = date('YmdHis');
        $username = C('ZT_SMS_USERNAME');
        $password = md5(md5(C('ZT_SMS_PASSWORD')).$tkey);
        $tpl_value = urlencode('#tpl_value#='.$v_code);
        $url = C('VCODE_URL')."?username=$username&tkey=$tkey&password=$password";
        $url .= "&mobile=$account&content=$content&productid=676767&xh=";
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 5);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
//            print_r($output);
        $arr = explode(',',$output);
//            print_r($arr);
        if(empty($arr[2])){
            return array('errorCode'=>1);
        }
        return array('errorCode'=>0);
    }else {
        return array('msg'=>'','errorCode'=>1);
    }
}
/**
 * 检查验证码
 * true 符合  false 不符合
 */
function checkCode($account,$code){
    $verify=M('Vcode')->where("account='$account'")->find();
    if($verify['v_code']!=$code) return array('msg'=>'验证码错误，请重新获取','errorCode'=>1);
    if($verify['time']+1200<time()) return array('msg'=>'验证码超时，请重新获取','errorCode'=>1);
    return array('msg'=>'验证码正确','errorCode'=>0);
}

/**
 * 参数为空提示
 * @param $param 参数数组
 */
function param_validate($param){
    foreach ( $param as $val){
        if($val['is_str']){
            $paramval =  I("post.{$val['key']}",'','strip_tags');
        }else{
            $paramval =  I("post.{$val['key']}",'','intval');
        }
        if(empty($paramval)){
            request_result($val['msg'].'不能为空' , 1);
        }
    }
    return;
}
