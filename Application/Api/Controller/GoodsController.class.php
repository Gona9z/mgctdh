<?php
namespace Api\Controller;
use Think\Controller;
class GoodsController extends ApiBaseController {

    //获取积分商品列表
    public function getIntegralGoods(){
        $page = I('post.page',1);
        $where['onsale'] = 1;
        $list = M('IntegralGoods')
            ->field('i_goods_id,image,name,integral,store_num')
            ->where($where)
            ->page($page,8)->select();
        if(empty($list)){
            request_result('已加载完所有商品', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //获取商品分类
    public function getGoodsCate(){
        $g_cate_id = I('post.g_cate_id',2);
        $list = M('GoodsCate')
            ->field('g_cate_id,name,image,level')
            ->where("parent_id='$g_cate_id'")->select();
        foreach($list as $key=>$val){
            if($val['level']==3){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
            unset($list[$key]['level']);
        }
        request_result('', 0, $list);
    }

    //获取商品列表
    public function getGoodsList(){
        $sex =  I('post.sex');
        $g_cate_id = I('post.g_cate_id');
        $keyword = I('keyword','').trim();

        $page = I('post.page',1);
        $order_type = I('post.order_type',1);

        if('4'==$order_type){
            $order_str = 'price';
        }elseif('3'==$order_type){
            $order_str = 'price DESC';
        }elseif('2'==$order_type){
            $order_str = 'collect_count DESC';
        }else{
//            $order_str = 'share_count DESC';
            $order_str = 'add_time DESC';
        }
        if(empty($keyword)){
            $where['sex'] = $sex;
            $where['g_cate_id'] = $g_cate_id;
        }else{
            $where['name'] = array('like','%'.$keyword.'%');
        }
        $where['end_time'] = array('EGT',(strtotime(date("Y-m-d", time()))+86399));
        $list = M('Goods')
            ->field('goods_id,name,image,price,collect_count')
            ->where($where)->page($page,8)->order($order_str)->select();
        if(empty($list)){
            request_result('已加载完所有商品', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
            }
        }
        request_result('', 0, $list);
    }

    //商品详情
    public function goodsDetail(){
        $at = I('post.accesstoken');
        $goods_id = I('goods_id');
        $param[] = array('key'=>'goods_id','msg'=>'商品Id','is_str'=>1);
        param_validate($param);//非空判断
        if(!empty($at)){
            $where['user_id'] = getUserIdByAT($at);
            $where['good_id'] = $goods_id;
        }
        //获取商品信息
        $goods = M('Goods')
            ->field('goods_id,name,image,price,collect_count,text_content,tb_link,g_cate_id')
            ->find($goods_id);
        $goods['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $goods['image']);
        $goods['tb_link'] = htmlspecialchars_decode($goods['tb_link']);
        //检查是否收藏商品
        $record = M('GoodsCollect')->where($where)->find();
        if(empty($record)){
            $goods['is_coll'] = 0;
        }else{
            $goods['is_coll'] = 1;
        }
        $where2['g_cate_id'] = $goods['g_cate_id'];
        unset($goods['g_cate_id']);
        //获取推荐商品列表
        $list = M('Goods')
            ->field('goods_id,name,image,price')
            ->where($where2)->limit(4)->select();
        foreach($list as $key=>$val){
            $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
        }
        $data = array(
            'goods_info'=>$goods,
            'tuijian'=>$list,
        );
        request_result('', 0, $data);

    }

    /**
     * 评论商品
     */
    public function goodsComment(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $good_id = I('post.good_id');
        $content = I('post.content');
        $query = D('Goods')->comment_goods($user_id,$content,$good_id);
        request_result($query['msg'],$query['errorCode']);
    }

    /**
     * 获取商品评论列表
     */
    public function getGoodsComment(){
        $page = I('post.page',1);
        $good_id = I('post.good_id');
        $list = M('GoodsComment')
            ->field('gc.content,gc.time,u.nickname,u.image')
            ->join('axd_user u ON u.user_id = gc.user_id')
            ->where("gc.good_id='$good_id'")
            ->page($page,10)->order('gc.time DESC')->alias('gc')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }foreach($list as $key=>$val){
            $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
        }
        request_result('', 0, $list);
    }

    /**
     * 收藏/取消收藏商品
     */
    public function collectGoods(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $good_id = I('post.good_id');
        $good = M('Goods')->find($good_id);
        if(empty($good)){
            request_result('没有该商品信息', 1);
        }
        $type = I('post.type');
        $query = D('Goods')->good_collect($good_id,$user_id,$type);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取我的收藏-商品
    public function getGoodsCollect(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $page = I('post.page',1);

        $list = M('Goods')
            ->field('g.goods_id,g.name,g.image,g.price,g.tb_link,g.collect_count')
            ->join('axd_goods_collect gc ON gc.good_id = g.goods_id')
            ->where("user_id='$user_id'")->page($page,8)->order("gc.time DESC")->alias('g')->select();
        if(empty($list)){
            request_result('已加载完所有商品', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
            }
        }
        request_result('', 0, $list);
    }

    //分享商品
    public function shareGoods(){
        $id = I('id');
        //获取商品信息
        $goods = M('Goods')
            ->field('goods_id,name,image,price,collect_count,text_content,tb_link,g_cate_id')
            ->find($id);
        $where2['g_cate_id'] = $goods['g_cate_id'];
        //获取推荐商品列表
        $list = M('Goods')
            ->field('goods_id,name,image,price')
            ->where($where2)->limit(4)->select();
        $this->assign('goods', $goods);
        $this->assign('list', $list);
        $this->tc_yyb = C('TC_YYB');
        $this->display();
    }

}
