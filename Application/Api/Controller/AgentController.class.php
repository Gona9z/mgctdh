<?php
namespace Api\Controller;
use Think\Controller;
class AgentController extends ApiBaseController {

    //代理登录
    public function loginAgent(){
        $account = I('account');
        $password = I('password');
        $param[] = array('key'=>'account','msg'=>'账号','is_str'=>1);
        $param[] = array('key'=>'password','msg'=>'密码','is_str'=>1);
        param_validate($param);//非空判断

        $where['account'] = $account;
        $agent = M('Agent')
            ->field('a.school_id,a.agent_id,a.agent_accesstoken,a.account,a.long_link,a.short_link,s.name AS school_name,a.password')
            ->join('axd_school s ON s.school_id = a.school_id')
            ->alias('a')->where($where)->find();
        if(md5($password)!==$agent['password']){
            request_result('登录密码错误', 1);
        }else{
            $today = strtotime(date('Y-m-d',time()));
            $tomorrow = strtotime(date("Y-m-d", time()))+86399;
            //天件数
            $where_day['finish_time'] = array('BETWEEN',array($today,$tomorrow));
            $where_day['type'] = 2;
            $where_day['by_myself'] = 0;
            $where_day['school_id'] = $agent['school_id'];
            $day_count = M('AgentOrder')->where($where_day)->count();
            $agent['day_cout'] = $day_count;
            //周件数
            $where_week['finish_time'] = array('BETWEEN',array($today,$tomorrow));
            $where_week['type'] = 2;
            $where_week['by_myself'] = 0;
            $where_week['school_id'] = $agent['school_id'];
            $weeks_count = M('AgentOrder')->where($where_week)->count();
            $agent['weeks_count'] = $weeks_count;
            //累计件数
            $where_all['type'] = 2;
            $where_all['by_myself'] = 0;
            $where_all['school_id'] = $agent['school_id'];
            $all_count = M('AgentOrder')->where($where_all)->count();
            $agent['all_count'] = $all_count;

            unset($agent['password']);
            $agent['agent_accesstoken'] = $data['agent_accesstoken']=noRand(30,1);
            $agent_id = $agent['agent_id'];
            M('Agent')->where("agent_id='$agent_id'")->save($data);
            request_result('', 0, $agent);
        }
    }

    //获取代理订单
    public function agentOrder(){
        $page = I('page',1);
        $agent_at = I('post.agent_accesstoken');
        $where['agent_accesstoken'] = trim($agent_at);
        $agent = M('Agent')->where($where)->find();
        if(empty($agent))
            request_result( "账号在其他终端登录，重新登录" , 101);
        $type = I('type');//0:待处理1:配送中2:已完成3:全部
        $where2['ao.school_id'] = $agent['school_id'];
        if('3'!=$type){
            $where2['ao.type'] = $type;
        }
        $agent_order = M('AgentOrder')
            ->field('s.name AS school_name,ao.a_order_id,ao.username,ao.phone,ao.s_phone,ao.room_num,
                ao.express_address,ao.send_time,ao.note,ao.order,ao.add_time,ao.type,ao.by_myself')
            ->join('axd_school s ON s.school_id = ao.school_id')
            ->alias('ao')->where($where2)->page($page,10)->select();
        if (empty($agent_order)){
            request_result('已加载完全部数据', 1);
        }else{
            request_result('', 0, $agent_order);
        }
    }

    //获取代理信息
    public function getAgentInfo(){
        $at = I('post.accesstoken');
        $where['u.user_id'] = getUserIdByAT($at);

        $agent = M('Agent')
            ->field('a.account,a.long_link,a.short_link,s.name AS school_name')
            ->join('axd_user u ON u.school_id = a.school_id')
            ->join('axd_school s ON s.school_id = a.school_id')
            ->where($where)->alias('a')->find();
        if(empty($agent)){
            request_result('没有查询到代理信息',1);
        }else{
            request_result('', 0, $agent);
        }
    }

    //确认发货
    public function sendGoods(){
        $agent_at = I('post.agent_accesstoken');
        $where['agent_accesstoken'] = trim($agent_at);
        $a_order_id = I('a_order_id');

        $param[] = array('key'=>'a_order_id','msg'=>'订单Id','is_str'=>1);
        param_validate($param);//非空判断

        $order = M('AgentOrder')->find($a_order_id);
        if(empty($order)||'0'!=$order['type']){
            request_result('订单状态错误',1);
        }else{
            $data['type'] = 1;
            $res = M('AgentOrder')->where("a_order_id='$a_order_id'")->save($data);
            if(false!==$res){
                request_result('操作成功',0);
            }else{
                request_result('操作失败,请刷新后重试',1);
            }
        }
    }

    //获取代理信息
    public function agentInfo(){
        $agent_at = I('post.agent_accesstoken');
        $where['agent_accesstoken'] = trim($agent_at);
        $agent = M('Agent')
            ->field('a.school_id,a.agent_id,a.account,a.long_link,a.short_link,s.name AS school_name,a.password')
            ->join('axd_school s ON s.school_id = a.school_id')
            ->alias('a')->where($where)->find();
        if(empty($agent))
            request_result( "账号在其他终端登录，重新登录" , 101);
        $today = strtotime(date('Y-m-d',time()));
        $tomorrow = strtotime(date("Y-m-d", time()))+86399;
        //天件数
        $where_day['finish_time'] = array('BETWEEN',array($today,$tomorrow));
        $where_day['type'] = 2;
        $where_day['by_myself'] = 0;
        $where_day['school_id'] = $agent['school_id'];
        $day_count = M('AgentOrder')->where($where_day)->count();
        $agent['day_cout'] = $day_count;
        //周件数
        $where_week['finish_time'] = array('BETWEEN',array($today,$tomorrow));
        $where_week['type'] = 2;
        $where_week['by_myself'] = 0;
        $where_week['school_id'] = $agent['school_id'];
        $weeks_count = M('AgentOrder')->where($where_week)->count();
        $agent['weeks_count'] = $weeks_count;
        //累计件数
        $where_all['type'] = 2;
        $where_all['by_myself'] = 0;
        $where_all['school_id'] = $agent['school_id'];
        $all_count = M('AgentOrder')->where($where_all)->count();
        $agent['all_count'] = $all_count;

        request_result('', 0, $agent);
    }
}
