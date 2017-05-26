<?php
namespace Api\Controller;
use Think\Controller;
use Think\Model;

class UserController extends ApiBaseController  {


    public function weibo_open(){
        $open_token = '2.00fL5BKDI3hJdBb9666a51bd0Le11L1';
        $open_id = '28964931631';
//        $open_token = I('open_token');
        $url = C('WB_GET_INFO')."?access_token=$open_token&uid=$open_id";
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $return_arr = json_decode($output,true);
        $profile_image_url = $return_arr['profile_image_url'];
        $screen_name = $return_arr['screen_name'];
        echo $profile_image_url;
        echo $screen_name;
    }

    public function qq_open(){
        $param_arr['open_token'] = '20999394C269E0F21F9E9E93F74A83101';
        $param_arr['open_id'] = 'CB70CCEEAF5013548DAD1740F647B3371';
        $param_arr['openkey'] = 'etP1cUhzlmcpSmYy';
        $param_arr['appid'] = '1105915210';
        $param_arr['sig'] = '11';
        $param_arr['pf'] = '11';
        $param_arr['param_url']= '';
        $param_str = '';
        foreach($param_arr AS $key=>$val){
            $param = urlencode($val);
            $param_str .= $param_str.$key.'='.$param.'&';
        }
        $url = C('QQ_GET_INFO')."?".$param_str;
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $return_arr = json_decode($output,true);
        dump($return_arr);
        $profile_image_url = $return_arr['profile_image_url'];
        $screen_name = $return_arr['screen_name'];
        echo $profile_image_url;
        echo $screen_name;
    }

    public function qq_getSign(){
        $host_url_encode = urlencode('/v3/user/get_info');
        $param_arr['appid'] = '1105915210';
        $param_arr['open_id'] = 'CB70CCEEAF5013548DAD1740F647B337';
        $param_arr['openkey'] = 'etP1cUhzlmcpSmYy';
        $param_arr['pf'] = '11';
        $param_str = '';
        foreach($param_arr AS $key=>$val){
            $param_str .= $param_str.$key.'='.$val.'&';
        }
        $str = $host_url_encode.'?'.$param_str;
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
            request_result('手机号码格式错误',1);
        }
    }

    //注册用户
    public function registUser(){
        $phone = I('post.phone');
        $password = I('post.password');
        $open_id = I('post.openid');
        $image_url = I('post.image_url');
        $nickname = I('post.nickname');
        if(empty($open_id)&&'0'!==$open_id){
            $param[] = array('key'=>'phone','msg'=>'账号','is_str'=>1);
            $param[] = array('key'=>'password','msg'=>'密码','is_str'=>1);
        }else{
            $param[] = array('key'=>'openid','msg'=>'openid','is_str'=>1);
            $param[] = array('key'=>'image_url','msg'=>'头像地址','is_str'=>1);
            $param[] = array('key'=>'nickname','msg'=>'用户昵称','is_str'=>1);
        }
        param_validate($param);//非空判断
        $query = D('User')->user_register($phone, $password, $open_id,$image_url,$nickname);
        request_result($query['msg'],$query['errorCode']);
    }

    //用户登录
    public function loginUser(){
        $phone = I('post.phone');
        $password = I('post.password');

        $param[] = array('key'=>'phone','msg'=>'账号','is_str'=>1);
        $param[] = array('key'=>'password','msg'=>'密码','is_str'=>1);
        param_validate($param);//非空判断

        $query = D('User')->user_login($phone, $password);
        $user = $query['user'];
        $data = array(
            'uid'   =>  $user['user_id'],
            'accesstoken'   =>  $user['accesstoken'],
            'phone'   =>  $user['phone'],
            'sex'   =>  $user['sex'],
            'integral'   =>  $user['integral'],
            'school_id'   =>  $user['school_id'],
        );
        request_result($query['msg'],$query['errorCode'],$query['errorCode']==0?$data:'');
    }

    //编辑用户信息
    public function editUserInfo(){
        $phone = I('post.phone');
        $nickname = I('post.nickname');
        $sex = I('post.sex');
        $birthday = I('post.birthday');
        $single = I('post.single');
        $school_id = I('post.school_id');
        $image = I('post.image');
        $query = D('User')->editUserInfo($phone,$nickname,$sex,$birthday,$single,$school_id,$image);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取学校列表
    public function getSchoolList(){
        $data = M('School')->select();
        request_result('', 0, $data);
    }

    //用户签到
    public function userSign(){
        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);
        $query = D('User')->user_sign($user);
        request_result($query['msg'],$query['errorCode']);
    }

    //积分兑换商品
    public function exchangeGoods(){
        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);

        $i_goods_id = I('post.i_goods_id');
        $name = I('post.name');
        $link_phone = I('post.link_phone');
        $address = I('post.address');
        if(''==$name||''==$link_phone||''==$address){
            request_result('必须填写完整的订单信息', 1);
        }
        if(!check_phone($link_phone)){
            request_result('手机号码格式错误', 1);
        }
        $good = M('IntegralGoods')->find($i_goods_id);
        if(empty($good)){
            request_result('没有该商品信息', 1);
        }
        if($user['integral']<$good['integral']){
            request_result('抱歉！您的积分不足', 1);
        }
        $query = D('User')->exchange_goods($user,$good,$name,$link_phone,$address);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取积分历史记录
    public function getIntegralList(){
        $at = I('post.accesstoken');
        $page = I('post.page',1);
        $id = getUserIdByAT($at);
        $list = M('Sign')
            ->field('integral,time,note')
            ->page($page,10)->where("user_id='$id'")->order('time DESC')->select();
        request_result('', 0, $list);
    }

    //修改密码
    public function editPassword(){
        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);
        $o_password = I('post.o_password');
        $n_password = I('post.n_password');
        if($user['password']!=md5($o_password)){
            request_result('原密码错误！', 1);
        }
        $query = D('User')->modify_password($user['user_id'], $n_password);
        request_result($query['msg'],$query['errorCode']);
    }

    //忘记密码
    public function forgetPassword(){
        $phone = I('post.phone');
        $password = I('post.password');
        $id = M('User')->where("phone='$phone'")->getField('user_id');
        if(''==$id||empty($id)){
            request_result('没有该账号信息', 1);
        }
        $query = D('User')->modify_password($id, $password);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取用户本月签到历史
    public function getMonthSign(){
        $at = I('post.accesstoken');
        $id = getUserIdByAT($at);
        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-d H:i:s');

        $list = M('Sign')
            ->where("user_id='$id' AND type=0 AND time >= unix_timestamp('$start') AND time <= unix_timestamp('$end')")
            ->getField('time',true);
        request_result('', 0, $list);
    }

    //获取个人信息
    public function getUserInfo(){
        $at = I('post.accesstoken');
        $where['accesstoken'] = trim($at);
        $user = M('User')
            ->field('u.phone,u.image,u.nickname,u.sex,u.birthday,u.single,u.school_id,s.name AS school_name')
            ->join('LEFT JOIN axd_school s ON s.school_id = u.school_id')
            ->alias('u')
            ->where($where)->find();
        if(empty($user))
           request_result( "账号在其他终端登录，重新登录" , 101);
        if('1'==$user['disable'])
           request_result( "该账号已被禁用" , 104);
        $user['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $user['image']);
        request_result('', 0, $user);
    }

    //获取积分订单
    public function getInteractOrder(){
        $at = I('post.accesstoken');
        $page = I('post.page',1);
        $id = getUserIdByAT($at);
        $list = M('IntegralOrder')
            ->field('i_order_id,good_name,image,integral,link_name,link_phone,address,order_no,time,admin_note')
            ->where("user_id='$id'")->page($page,10)->select();
        if(empty($list)){
            request_result('已加载完所有订单', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //意见反馈
    public function feedback(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $content = I('post.content');

        $param[] = array('key'=>'content','msg'=>'反馈内容','is_str'=>1);
        param_validate($param);//非空判断

        $query = D('User')->submitFeed($user_id,$content);
        request_result($query['msg'],$query['errorCode']);
    }

    //三方登录
    public function openLogin(){
        $open_id = I('post.openid');
        $query = D('User')->open_login($open_id);
        $user = $query['user'];
        $data = array(
            'uid'   =>  $query['user']['user_id'],
            'accesstoken'   =>  $query['user']['accesstoken'],
            'phone'   =>  $query['user']['phone'],
            'sex'   =>  $query['user']['sex'],
            'integral'   =>  $query['user']['integral'],
            'school_id'   =>  $user['school_id'],
        );
        request_result($query['msg'],$query['errorCode'],$query['errorCode']==0?$data:'');
    }

    //添加分享记录
    public function addShare(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $type = I('post.type');
        $id = I('post.id');
        $query = D('User')->add_share($user_id, $type,$id);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取分享记录
    public function getShareRecord(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $type = I('post.type');//1美文2商品3帖子
        $page = I('post.page',1);
        $where['sr.type'] = $type;
        $where['sr.user_id'] = $user_id;
        if('1'==$type){
            $list = M('ShareRecord')
                ->field('sr.record_id,g.goods_id,g.name,g.image,g.price,g.tb_link,g.collect_count')
                ->join('axd_goods g ON g.goods_id = sr.type_id')
                ->alias('sr')->where($where)->page($page,10)->select();
        }elseif('2'==$type){
            $list = M('ShareRecord')
                ->field('sr.record_id,s.subject_id,s.image,s.`name`,s.collect_count,s.user_image,user_nickname,s.text_content')
                ->join('axd_subject s ON s.subject_id = sr.type_id')
                ->alias('sr')->where($where)->page($page,10)->select();
        }else{
            $list = M('ShareRecord')
                ->field('sr.record_id,c.collocation_id,c.title,c.image,c.introduce')
                ->join('axd_collocation c ON c.collocation_id = sr.type_id')
                ->alias('sr')->where($where)->page($page,10)->select();
            foreach($list as $key=>$val){
                $list[$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
                $collocation_id = $val['collocation_id'];
                $label_list = M('CollocationLabel')->where("collocation_id='$collocation_id'")->getField('label_text',true);
                $list[$key]['label_str'] = implode('+', $label_list);
            }
        }
        if(empty($list)){
            request_result('已加载完所有记录', 1);
        }else{
            foreach($list as $key=>$val){
                if('2'==$type){
                    $list[$key]['user_image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['user_image']);
                }
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //删除分享记录
    public function delShareRecord(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $record_id = I('post.record_id');
        $res = M('ShareRecord')->delete($record_id);
        request_result('删除成功', 0);
    }

    //获取基本信息
    public function getInfo(){
        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);
        $user_id = $user['user_id'];
        $sign_record = M('Sign')->where("user_id=$user_id")->order('time DESC')->limit(1)->getField('time');
        $sign_time = date("Y-m-d", $sign_record);
        $time = date("Y-m-d", time());
        $data = array(
            'image'  =>  str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $user['image']),
            'integral'  =>  $user['integral'],
            'server_time'  =>  time(),
            'is_sign'  =>  $sign_time == $time?1:0,
            'school_id'  =>  $user['school_id'],
        );
        request_result('', 0, $data);
    }


    //提交代拿快递
    public function submitExpress(){

    }

    //添加淘宝订单
    public function addTBOrder(){
        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);
        $goods_id = I('goods_id');
        $tb_order = I('tb_order');

        $data['user_id'] = $user['user_id'];
        $data['nickname'] = $user['nickname'];
        $data['goods_id'] = $goods_id;
        $data['order'] = $tb_order;
        $data['add_time'] = time();
        $data['is_deal'] = 0;

        $where['order'] = $data['order'];
        $record = M('TbOrder')->where($where)->find();
        if(!empty($record)){
            request_result('订单已经存在', 1);
        }
        if(false!==M('TbOrder')->add($data)){
            request_result('添加成功',0);
        }else{
            request_result('添加失败,请刷新后重试',1);
        }
    }

    //添加代拿订单记录
    public function addOrderDaina(){
        $model = new Model();
        $model->startTrans();

        $at = I('post.accesstoken');
        $user = getUserInfoByAT($at);
        $data['school_id'] = $school_id = I('school_id');
        $agent = M('Agent')->where("school_id='$school_id'")->find();
        if(empty($agent)){
            request_result('本学校没有代理人员，无法提供代拿服务', 1);
        }

        $data['user_id'] = $user['user_id'];
        $data['username'] = I('username');
        $data['phone'] = I('phone');
        $data['s_phone'] = I('s_phone');
        $data['school_name'] = M('School')->where("school_id='$school_id'")->getField('name');
        $data['room_num'] = I('room_num');
        $data['express_address'] = I('express_address');
        $data['send_time'] = I('send_time');
        $data['note'] = I('note');
        $order = I('order');
        $data['order'] = $order;
        $data['type'] = 0;
        $data['add_time'] = time();

        $where3['order'] = $order;
        $record = M('AgentOrder')->where($where3)->find();
        if(!empty($record)){
            request_result('订单已经提交过拿快递记录', 1);
        }

        $where['order'] = $order;
        $data2['is_deal'] = 1;
        $res1 = $model->table(C('DB_PREFIX').'tb_order')->where($where)->save($data2);
        $res2 = $model->table(C('DB_PREFIX').'agent_order')->add($data);
        //==========================================
        try{
            $content = '您好,您有新的订单消息,请及时处理';
            $app_key = C('JG_APP_KEY');
            $master_secret = C('JG_MASTER_SECRET');
            $client = new \Common\JPush\Client($app_key, $master_secret);
            $ios_notification = array(
                'alert' => C('PRO_NAME').'-系统推送',
                'sound' => 'newOrder.caf'
            );
            $android_notification = array(
                'title' => C('PRO_NAME').'系统推送',
            );
            $result = $client->push()
                ->setPlatform('all')
                ->addAlias('agent_'.$school_id)
//                ->androidNotification($content,$android_notification)
                ->message($content,$android_notification)
                ->iosNotification($content,$ios_notification)
//                ->setOptions(null,null,null,false,null)
                ->send();
        }catch (\Exception $e){
//            request_result('本学校没有代理人员，无法提供代拿服务',1);
            if ($res1!==false && $res2!==false) {
                $model->commit();
                request_result('提交成功', 0 );
            }else {
                $model->rollback();
                request_result('提交失败', 1 );
            }
        }
        //==========================================

        if ($res1!==false && $res2!==false) {
            $model->commit();
            request_result('提交成功', 0 );
        }else {
            $model->rollback();
            request_result('提交失败', 1 );
        }
    }

    //检查订单是否存在
    public function checkOrderExist(){
        $where['order'] = I('post.order');
        $res = M('TbOrder')->where($where)->find();
        if(empty($res)){
            request_result('没有该订单信息', 1);
        }else{
            if('1'==$res['is_deal']){
                request_result('该订单已提交过申请', 1);
            }
            request_result('', 0);
        }
    }

    //确认代理订单
    public function confirmAgentOrder(){
        $at = I('post.accesstoken');
        $where['user_id'] = getUserIdByAT($at);
        $where['a_order_id'] = I('a_order_id');

        $param[] = array('key'=>'a_order_id','msg'=>'订单Id','is_str'=>1);
        param_validate($param);//非空判断

        $data['type'] = 2;
        $data['finish_time'] = time();
        if(false!==M('AgentOrder')->where($where)->save($data)){
            request_result('确认成功', 0);
        }else {
            request_result('确认失败', 1);
        }
    }

    //获取我的订单
    public function myAgentOrder(){
        $page = I('page', 1);
        $at = I('post.accesstoken');
        $where['ao.user_id'] = getUserIdByAT($at);

        $type = I('type');
        if('3'!=$type){
            $where['ao.type'] = $type;
        }

        $agent_order = M('AgentOrder')
            ->field('s.name AS school_name,ao.a_order_id,ao.username,ao.phone,ao.s_phone,ao.room_num,
                ao.express_address,ao.send_time,ao.note,ao.order,ao.add_time,ao.type,ao.by_myself')
            ->join('axd_school s ON s.school_id = ao.school_id')
            ->alias('ao')->where($where)->page($page,10)->select();
        if (empty($agent_order)){
            request_result('已加载完全部数据', 1);
        }else{
            request_result('', 0, $agent_order);
        }
    }

    //自己拿快递
    public function aOrderByMyself(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $a_order_id = I('a_order_id');

        $param[] = array('key'=>'a_order_id','msg'=>'订单Id','is_str'=>1);
        param_validate($param);//非空判断

        $agent_order = M('AgentOrder')->find($a_order_id);
        if('2'==$agent_order['type']){
            request_result('该订单已经完成,请刷新重试',1);
        }else{
            $data['type'] = 2;
            $data['by_myself'] = 1;
            $data['finish_time'] = time();
            $where['a_order_id'] = $a_order_id;
            $where['user_id'] = $user_id;
            if(false!==M('AgentOrder')->where($where)->save($data)){
                request_result('确认成功', 0);
            }else {
                request_result('确认失败', 1);
            }
        }
    }

}
