<?php
namespace Admin\Controller;
use Think\Controller;
class AdController extends AdminBaseController  {
    //广告列表
    public function adList(){
        $this->list = M('Banner')->select();
        $this->display();
    }

    //添加编辑广告
    public function addEditAd(){
        $id = I('id');
        $ad = M('Banner')->find($id);
        if(IS_GET){
            $this->assign('ad',$ad);
            $this->display();
        }else{
            $data['link'] = I('link');
            $data['order_n'] = I('order_n');
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'banner');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($partner)){       //编辑---删除原图片
                        unlink('.'.$ad['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            if(empty($ad)){
                $data['add_time'] = time();
                if(false!==M('Banner')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Banner')->where("banner_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除广告
    public function delAd(){
        $id = I('id');
        $ad = M('Banner')->find($id);
        if(false!==M('Banner')->delete($id)){
            unlink('.'.$ad['image']);
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }
}