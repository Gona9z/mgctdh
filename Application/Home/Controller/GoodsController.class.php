<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends HomeBaseController  {
    public function index(){
    }

    //获取商品分类页
    public function gCatePage(){
        $f_cate_id = I('f_cate_id');
        $c_list = M('GoodsCate')->field('g_cate_id,`name`')
            ->where("parent_id='$f_cate_id' AND sys_value=0")->select();
        foreach($c_list as $key=>$val){
            $temp_id = $val['g_cate_id'];
            $c_list[$key]['cate_list'] = M('GoodsCate')
                ->field('g_cate_id,image,`name`')->where("parent_id='$temp_id'")->select();;
        }
        $this->assign('c_list',$c_list);
        $this->display();
    }

    //获取产品列表
    public function goodsList(){
        $page = I('page',1);
        $cate_id = I('cate_id');
        $methodName = I('methodName');
        $pageSize = 24;
        $user = session('axd_user');

        $where['g_cate_id'] = $cate_id;
        $where['end_time'] = array('EGT',(time()-86400));
        $list = M('Goods')->where($where)->page($page,$pageSize)->select();
        if(!empty($user)){
            $where['user_id'] = $user['user_id'];
            foreach($list AS $key=>$val){
                $where['good_id'] = $val['goods_id'];
                $is_Col = M('GoodsCollect')->where($where)->find();
                $list[$key]['is_col'] = empty($is_Col)?0:1;
            }
        }

        $count = M('Goods')->where($where)->count();
        $show = getGoodsAjaxPageShow($count, $pageSize, $page,$methodName, $cate_id);
        $data = array(
            'goods_list'    =>  $list,
            'page_info' =>  $show,
        );
        $this->ajaxReturn($data);
    }

    //获取系统二级分类页面：1情侣专区、2宿舍专区、3吃货专区
    public function gCatePageSysV(){
        $cate_id = I('cate_id');
        switch ($cate_id){
            case 1:
                $where['_string'] = 'parent_id = 3 OR parent_id = 4';
                break;
            case 2:
                $where['_string'] = 'parent_id = 5 OR parent_id = 6';
                break;
            case 3:
                $where['_string'] = 'parent_id = 7 OR parent_id = 8';
                break;
            default:
                $this->redirect('Index/index');
        }
        $c_list = M('GoodsCate')->field('g_cate_id,image,`name`')
            ->where($where)->select();
        $this->assign('c_list',$c_list);
        $this->display();
    }

    //积分商品列表
    public function IntegralGoods(){
        $page = I('p',1);
        $list = M('IntegralGoods')
            ->field('i_goods_id,name,image,integral,store_num')
            ->page($page,24)->where('onsale = 1')->select();
        $count = M('IntegralGoods')->where('onsale = 1')->count();
        $Page = new \Think\Page($count,24);
        $show = $Page->show();// 分页显示输出
        $this->assign('goods_list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    //搜索商品
    public function searchGoods(){
        $page = I('p',1);
        $keyword = I('keyword');
        $this->assign('keyword',$keyword);
        $where['name']=array('like','%'.$keyword.'%');
        $where['end_time'] = array('EGT',(time()-86400));
        $goods_list = M('Goods')
            ->field('goods_id,name,image,price,tb_link,collect_count')
            ->where($where)->page($page,24)->order('add_time DESC')->select();
        $count = M('Goods')->field('goods_id,name,image,price,tb_link,collect_count')->where($where)->count();
        $Page = new \Think\Page($count,24);
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);
        $this->assign('goods_list',$goods_list);
        $this->assign('URL',__ACTION__);
        $this->display();
    }

    //收藏/取消收藏商品
    public function collectGoods(){
        $user = session('axd_user');
        if(empty($user)){
            $this->ajaxReturn(array('msg'=>'','errorCode'=>101));
        }
        $user_id = $user['user_id'];
        $good_id = I('post.gid');
        $good = M('Goods')->find($good_id);
        if(empty($good)){
            $this->ajaxReturn(array('msg'=>'没有该商品信息','errorCode'=>1));
        }
        $type = I('post.type');
        $query = D('Goods')->good_collect($good_id,$user_id,$type);
        $this->ajaxReturn(array('msg'=>$query['msg'],'errorCode'=>$query['errorCode']));
    }
}