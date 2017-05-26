<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends ApiBaseController {



    //获取首页广告
    public function homeBanner(){
        $list = M('Banner')->field('image,link')->order('order_n')->select();
        foreach ($list AS $key=>$val){
            $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
        }
        request_result('', 0, $list);
    }

    //获取启动页
    public function getStartPage(){
        $page = M('StartPage')->where("status=1")->getField('image');
        $page = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $page);
        request_result('', 0, $page);
    }

    //首页搜素-宝贝美文  type:1美文2商品
    public function searchGoodsSubject(){
        $page = I('post.page',1);
        $type = I('post.type',1);
        $keyword = I('post.keyword','');
        if('1'==$type){
            $where['s.name'] = array('like','%'.$keyword.'%');
            $list = M('Subject')
                ->field('s.subject_id,s.image,s.`name`,s.user_nickname,s.user_nickname,s.user_image,s.text_content,s.collect_count')
                ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
                ->order('s.add_time DESC')
                ->where($where)->alias('s')->page($page,8)->select();
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['user_image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['user_image']);
            }
        }else{
            $where['name'] = array('like','%'.$keyword.'%');
            $list = M('Goods')
                ->field('goods_id,name,image,price,tb_link,collect_count')
                ->where($where)->page($page,8)->order('collect_count DESC')->select();
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
            }
        }
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }
        request_result('', 0, $list);
    }

    //搜索关键字
    public function hotKeyword(){
        $list = M('HotKeyword')->getField('name',true);
        request_result('', 0, $list);
    }

    //快递列表
    public function expressList(){
        $list = M('Express')->getField('name',true);
        request_result('', 0, $list);
    }

    //获取服务协议
    public function getService(){
        $service = M('Service')->where("id=1")->find();
        request_result('', 0, $service['service']);
    }

    //获取客服热线
    public function customerPhone(){
        $phone = M('Customer')->where("phone_id=1")->find();
        request_result('', 0, $phone['phone']);
    }

    //提交淘口令
    public function submitTaoCommand(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);

        $param[] = array('key'=>'tao_command','msg'=>'淘口令','is_str'=>1);
        param_validate($param);//非空判断

        $data['command'] = I('tao_command');
        $data['user_id'] = $user_id;
        $data['time'] = date('Y-m-d H:i:s',time());
        $data['status'] = 0;

        if(false!==M('TaoCommand')->add($data)){
            request_result('提交成功', 0);
        }else{
            request_result('提交失败,请重试', 1);
        }
    }

    //检查版本号 type:1 iOS ，2 Android
    public function checkVersion(){
        $type = I('type',1);
        $where['type'] = $type;
        $version = M('Version')->where($where)->find();
        if('2'==$type){
            $url = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $version['url']);
            request_result('', 0, array('version'=>$version['version'],'url'=>$url,'note'=>$version['note']));
        }else{
            request_result('', 0, array('version'=>$version['version'],'note'=>$version['note']));
        }
    }

}