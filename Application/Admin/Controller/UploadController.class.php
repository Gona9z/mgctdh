<?php
namespace Admin\Controller;
use Think\Controller;
class UploadController extends AdminBaseController  {
    //图片上传
    public function imageUpload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/uploads/interact/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            foreach($info as $file){
                $url = C('WEB_URL').'Public/uploads/recipe_content/'.$file['savepath'].$file['savename'];
                //预留接口 ************
                //在这里可以把图片地址写入数据库 或者对图片进行操作 例如生成缩略图

                //这里返回每一次的URL pulpload 规则 参见 编辑器js
                $this->ajaxReturn($url,'EVAL');
            }
        }
    }
}