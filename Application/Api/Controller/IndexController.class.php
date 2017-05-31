<?php
namespace Api\Controller;
use Think\Model;

class IndexController extends ApiBaseController {

    public function index(){
        $this->display();
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

    //获取前缀
    public function getPrefix(){
        $prefix = C('WEB_URL');
        request_result('', 0, $prefix);
    }

    //意见反馈
    public function addOpinion(){
        $at = I('accesstoken');
        $data['user_id'] = getUserIdByAT($at);
        $data['opinion'] = I('opinion');
        //非空判断
        $param[] = array('key'=>'opinion', 'msg'=>'opinion', 'is_str'=>1);
        param_validate($param);
        //添加意见反馈
        $data['add_time'] = date('Y-m-d H:i:s',time());
        if(false!==M('Opinion')->add($data)){
            request_result('反馈成功', 0);
        }else{
            request_result('反馈失败', 1);
        }
    }

    //提交餐厅建议
    public function updateRestaurant(){
        $at = I('accesstoken');
        $data['user_id'] = getUserIdByAT($at);
        $data['merchant_name'] = I('merchant_name');
        $data['description'] = I('description');
        $data['image_str'] = I('image_str');
        $data['type'] = I('type',0);
        //非空判断
        $param[] = array('key'=>'merchant_name', 'msg'=>'restaurant name', 'is_str'=>1);
        $param[] = array('key'=>'description', 'msg'=>'description', 'is_str'=>1);
        param_validate($param);
        $data['add_time'] = date('Y-m-d H:i:s',time());
        $model = new Model();
        $model->startTrans();
        //TODO 图片上传未处理

    }
}