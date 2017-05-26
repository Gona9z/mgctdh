<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends HomeBaseController  {
    //用户登陆
    public function userLogin(){
        $phone = I('phone');
        $password = I('password', '', 'md5');
        $query = D('User')->user_login($phone, $password);
        if('0'==$query['errorCode']){
            $user = $query['user'];
            session('axd_user',$user);
        }
        $data = array(
            'msg'   =>  $query['msg'],
            'errorCode' =>  $query['errorCode']
        );
        $this->ajaxReturn($data);
    }

    //注销登录
    public function logout(){
        session('axd_user',null);
        $this->redirect('Index/index');
    }

    //检查是否登录状态
    public function checkIsLogin(){
        $user = session('axd_user');
        $status = 0;
        if(!empty($user)){
            $status = 1;
        }
        $this->ajaxReturn(array('status'=>$status));
    }

    //积分兑换商品
    public function exchangeGoods(){
        $link_name = I('name');
        $link_phone = I('phone');
        $address = I('address');
        $i_goods_id = I('i_gid');

        $user = session('axd_user');
        $user = M('User')->find($user['user_id']);

        if(''==$link_name||''==$link_phone||''==$address){
            $this->ajaxReturn(array('msg'=>'必须填写完整的订单信息','errorCode'=>1));
        }
        $good = M('IntegralGoods')->find($i_goods_id);
        if(empty($good)){
            $this->ajaxReturn(array('msg'=>'没有该商品信息','errorCode'=>1));
        }
        if($user['integral']<$good['integral']){
            $this->ajaxReturn(array('msg'=>'抱歉！您的积分不足','errorCode'=>1));
        }
        if(!preg_match("/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|70)\\d{8}$/",$link_phone)){
            $this->ajaxReturn(array('msg'=>'手机号码格式错误','errorCode'=>1));
        }
        $query = D('User')->exchange_goods($user,$good,$link_name,$link_phone,$address);
        $data = array(
            'msg'   =>  $query['msg'],
            'errorCode' =>  $query['errorCode']
        );
        $this->ajaxReturn($data);
    }

    //获取我的积分
    public function myIntegral(){
        $user = session('axd_user');
        $page = I('p',1);
        if(empty($user)){
            $this->redirect('Index/index');
        }else{
            $user_id = $user['user_id'];
            $this->user = M('User')->field('integral')->find($user_id);
            $list = M('Sign')
                ->field('integral,time,note')
                ->page($page,10)->where("user_id='$user_id'")->order('id DESC')->select();
            $this->assign('list',$list);
            //数据分页
            $count = M('Sign')->where("user_id='$user_id'")->count();
            $Page = new \Think\Page($count,10);
            $show = $Page->show();// 分页显示输出
            $this->assign('page',$show);
            $this->display();
        }
    }

    //获取我的收藏
    public function getMyCollect(){
        $user = session('axd_user');
        $page = I('p',1);
        $type = I('type',2);
        $this->assign('type',$type);
        if(empty($user)){
            $this->redirect('Index/index');
        }else{
            $user_id = $user['user_id'];
            if('2'==$type){
                $this->list = M('Goods')
                    ->field('g.goods_id,g.name,g.image,g.price,g.tb_link,g.collect_count')
                    ->join('axd_goods_collect gc ON gc.good_id = g.goods_id')
                    ->where("user_id='$user_id'")->page($page,24)->order("gc.time DESC")->alias('g')->select();
            }else{
                $this->list = M('Subject')
                    ->field('s.subject_id,s.image,s.`name`,s.text_content')
                    ->join('axd_subject_collect sc ON sc.subject_id = s.subject_id')
                    ->where("user_id='$user_id'")->page($page,24)->order("time DESC")->alias('s')->select();
            }
            $this->display();
        }
    }

}