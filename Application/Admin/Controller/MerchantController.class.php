<?php
namespace Admin\Controller;
use Think\Controller;
class MerchantController extends AdminBaseController  {
    //商家列表
    public function merchantList(){
        $page = I('p',1);
        $this->list = M('Merchant')->page($page,10)->select();
        //数据分页
        $this->display();
    }

    //添加编辑商家
    public function addEditMerchant(){
        $id = I('id');
        if(IS_GET){
            $this->merchant = M('Merchant')->find($id);
            $this->display();
        }else{

        }
    }
}