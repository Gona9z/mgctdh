<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminBaseController  {
    public function index(){
        $this->redirect('Admin/Index/welp');
    }

    //登录页面
    public function login(){
        $this->display();
    }

    //欢迎页
    public function welp(){
        $this->display();
    }

    //启动页列表
    public function startPageList(){
        $page = I('p',1);
        $this->list = M('StartPage')->order('add_time DESC')->page($page,20)->select();
        $this->display();
    }

    //添加新启动页
    public function addEditStartPage(){
        $page_id = I('id');
        $page = M('StartPage')->find($page_id);
        if(IS_GET){
            $this->assign('page',$page);
            $this->display();
        }else{
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'start_page');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->ajaxReturn(array('msg'=>'编辑失败,'.$res['msg'],'errorCode'=>1));
                }else{          //文件上传成功
                    $data['image'] = $res['file_name'];
                    if(!empty($page)){
                        unlink('.'.$page['image']);
                    }
                }
            }
            $data['status'] = I('status',0);
            if('1'==$data['status']){
                M('StartPage')->where("status=1")->setField('status',0);
            }
            if(empty($page)){
                $this->empty_ajaxReturn(array($data['image']),array('搭配图片'));
                $data['add_time'] = date('Y-m-d H:i:s', time());
                if(false!==M('StartPage')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('StartPage')->where("page_id='$page_id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
            if('1'==$data['status']){
                M('StartPage')->where("status=1")->setField('status',0);
            }
    }

    //删除启动页
    public function delStartPage(){
        $page_id = I('id');
        if(false!==M('StartPage')->delete($page_id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //礼品卡列表
    public function giftCardList(){
        $page = I('p',1);
        $this->list = M('GiftCard')->page($page,10)->select();
        $this->display();
    }

    //添加编辑礼品卡
    public function addEditGiftCard(){
        $id = I('id');
        if(IS_GET){
            $gc = M('GiftCard')->find($id);
            $this->assign('gc',$gc);
            $this->display();
        }else{

        }
    }
}