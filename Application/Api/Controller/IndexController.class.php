<?php
namespace Api\Controller;
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

}