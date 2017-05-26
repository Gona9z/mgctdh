<?php
namespace Admin\Controller;
use Think\Controller;
class IntegralController extends AdminBaseController {
    //积分商品列表
    public function iGoodsList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('IntegralGoods')->where($where)->page($page,20)->select();
        //数据分页
        $count = M('IntegralGoods')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //添加编辑积分商品
    public function addEditIGoods(){
        $id = I('id');
        $i_goods = M('IntegralGoods')->find($id);
        if(IS_GET){
            $this->assign('i_goods',$i_goods);
            $this->display();
        }else{
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'integral_goods');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败,'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($i_goods)){       //编辑---删除原图片
                        unlink('.'.$i_goods['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            $param_arr = array(
                $data['name'] = I('name'),
                $data['integral'] = I('integral'),
                $data['store_num'] = I('store_num'),
                $data['onsale'] = I('onsale'),
            );
            $msg_arr = array('商品名称','积分','库存','商品状态');
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            if(empty($i_goods)){
                $this->empty_ajaxReturn(array($data['image']),array('商品图片'));
                $data['add_time'] = time();
                if(false!==M('IntegralGoods')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('IntegralGoods')->where("i_goods_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除积分商品
    public function delIGoods(){
        $id = I('id');
        $i_goods = M('IntegralGoods')->find($id);
        if(false!==M('IntegralGoods')->delete($id)){
            unlink('.'.$i_goods['image']);
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //积分订单列表
    public function iOrderList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['good_name'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['link_name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('IntegralOrder')->where($where)->page($page,20)->order('time DESC')->select();
        //数据分页
        $count = M('IntegralOrder')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //处理积分订单
    public function dealIOrder(){
        $io_id = I('io_id');
        if(IS_GET){
            $this->order = M('IntegralOrder')->find($io_id);
            $this->display();
        }else{
            $this->empty_ajaxReturn(array($data['admin_note'] = I('admin_note')),array('管理员备注'));
            $data['type'] = 1;
            $res = M('IntegralOrder')->where("i_order_id='$io_id'")->save($data);
            if(false!==$res&&'0'!=$res){
                $this->request_ajaxReturn('编辑成功'.$io_id, 0);
            }else{
                $this->request_ajaxReturn('编辑失败', 1);
            }
        }
    }

    //导出积分订单Excel
    public function exportExcelIOrder(){
        $keyword = I('get.keyword','');
        $where['good_name'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['link_name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $data = M('IntegralOrder')
            ->field('i_order_id,good_name,link_name,link_phone,address,admin_note,type')
            ->where($where)->select();
        foreach($data AS $key=>$val){
            $data[$key]['type'] = $val['type']==0?'未处理':'已处理';
        }

        $title_arr = array('ID','积分商品','联系人','联系电话','地址','后台备注','处理状况');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,30,10,15,30,20,10),'兑换订单列表'.date("Ymd", time()));
    }

    //淘宝订单列表
    public function tbOrderList(){
        $keyword = I('get.keyword','');
        $where['u.nickname'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['g.name'] = array('like','%'.$keyword.'%');
        $this->assign('keyword',$keyword);

        $page = I('p',1);
        $this->tb_list = M('TbOrder')
            ->field('u.nickname,u.image,g.name,g.image,g.price,g.tb_link,tor.add_time,tor.order')
            ->join('axd_user u ON u.user_id = tor.user_id')
            ->join('axd_goods g ON g.goods_id = tor.goods_id')
            ->alias('tor')->where($where)->page($page,20)->select();;
        //数据分页
        $count = M('TbOrder')
            ->join('axd_user u ON u.user_id = tor.user_id')
            ->join('axd_goods g ON g.goods_id = tor.goods_id')
            ->alias('tor')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //送呗拿快递历史
    public function songbeiList(){
        $keyword = I('get.keyword','');
        $where['username'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['phone'] = array('like','%'.$keyword.'%');
        $this->assign('keyword',$keyword);

        $page = I('p',1);
        $this->list = M('Songbei')->where($where)->page($page,20)->select();
        //数据分页
        $count = M('Songbei')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }
}