<?php
namespace Admin\Controller;
use Think\Controller;
class AgentController extends AdminBaseController  {
    //代理列表
    public function agentList(){
        $page = I('p',1);
        $this->list = M('Agent')
            ->field('a.*,s.name AS school')
            ->join('LEFT JOIN axd_school s ON s.school_id = a.school_id')
            ->alias('a')->page($page,20)->select();
        $this->display();
    }

    //添加编辑代理信息
    public function addEditAgent(){
        $id = I('id');
        $agent = M('Agent')->find($id);
        if(IS_GET){
            $this->school_list = M('School')->select();
            $this->assign('agent',$agent);
            $this->display();
        }else{
            $param_arr = array(
                $data['account'] = I('account'),
                $data['school_id'] = I('school_id'),
                $data['long_link'] = I('long_link'),
                $data['short_link'] = I('short_link'),
            );
            $msg_arr = array('代理名称','学校选项','长号','短号');
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            $where['school_id'] = I('school_id');
            $record = M('Agent')->where($where)->find();
            if(empty($record)||$record['agent_id']==$id){
                if(empty($agent)){
                    $this->empty_ajaxReturn(array(I('password'),),array('新增代理密码'));
                    $data['password'] = md5(I('password'));
                    $data['add_time'] = time();
                    if(false!==M('Agent')->add($data)){
                        $this->request_ajaxReturn('添加成功', 0);
                    }else{
                        $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                    }
                }else{
                    if(!empty(I('password'))){
                        $data['password'] = md5(I('password'));
                    }
                    if(false!==M('Agent')->where("agent_id='$id'")->save($data)){
                        $this->request_ajaxReturn('编辑成功', 0);
                    }else{
                        $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                    }
                }
            }else{
                $this->request_ajaxReturn('一个学校只能存在一个代理账号', 1);
            }

        }
    }

    //删除代理
    public function delAgent(){
        $id = I('id');
        $this->empty_ajaxReturn(array($id),array('代理Id'));
        if(false!==M('Agent')->delete($id)){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    //代理订单列表
    public function agentOrderList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['ao.order'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->school_list = M('School')->select();
        $this->list = M('AgentOrder')
//            ->join('LEFT JOIN axd_user u ON u.user_id = ao.user_id')
            ->where($where)->alias('ao')->order('add_time DESC')->page($page,20)->select();
        //数据分页
        $count = M('AgentOrder')
//            ->join('LEFT JOIN axd_user u ON u.user_id = ao.user_id')
            ->where($where)->alias('ao')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }
}