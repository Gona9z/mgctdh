<?php
namespace Api\Controller;
use Think\Controller;
class CollocationController extends ApiBaseController {

    //搭配分类列表
    public function collocationCate(){
        $list = M('CollocationCate')->field('order_n',true)->order('order_n')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
            request_result('', 0, $list);
        }
    }

    //搭配列表
    public function collocationList(){
        $page = I('page',1);
        $c_cate_id = I('c_cate_id');
        if(!empty($c_cate_id)){
            $where['c_cate_id'] = $c_cate_id;
            $order_str = 'collect_count DESC';
        }else{
            $order_str = 'add_time DESC';
        }
        $list = M('Collocation')
            ->field('collocation_id,title,image,introduce')
            ->where($where)->order($order_str)->page($page,20)->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['is_coll'] = 0;
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $where2['user_id'] = 1;
                $where2['collocation_id'] = $val['collocation_id'];
                $record = M('CollocationCollect')->where($where2)->find();
                if(!empty($record)){
                    $list[$key]['is_coll'] = 1;
                }
                $collocation_id = $val['collocation_id'];
                $label_list = M('CollocationLabel')->where("collocation_id='$collocation_id'")->getField('label_text',true);
                $list[$key]['label_str'] = implode('+', $label_list);
            }
            request_result('', 0, $list);
        }
    }

    //搭配收藏/取消收藏
    public function collectCollocation(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $collocation_id = I('post.collocation_id');
        $collocation = M('Collocation')->find($collocation_id);
        if(empty($collocation)){
            request_result('没有该搭配信息', 1);
        }
        $type = I('post.type');
        $query = D('Collocation')->collocation_collect($collocation_id,$user_id,$type);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取搭配收藏列表
    public function getCollocationCollect(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $page = I('post.page',1);

        $list = M('CollocationCollect')
            ->field('c.collocation_id,title,image,introduce')
            ->join('axd_collocation c ON c.collocation_id = cc.collocation_id')
            ->where("cc.user_id='$user_id'")->page($page,8)->order("cc.time DESC")->alias('cc')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
                $collocation_id = $val['collocation_id'];
                $label_list = M('CollocationLabel')->where("collocation_id='$collocation_id'")->getField('label_text',true);
                $list[$key]['label_str'] = implode('+', $label_list);
            }
        }
        request_result('', 0, $list);
    }

    //搭配详情
    public function collocationDetail(){
        $collocation_id = I('post.collocation_id');
        $collocation = M('Collocation')
            ->field('title,introduce,image')
            ->find($collocation_id);
        $label_text = M('CollocationLabel')->where("collocation_id='$collocation_id'")->getField('label_text',true);
        $collocation['label_text'] = $label_text;
        $node_list = M('CollocationNode')
            ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text')
            ->join('axd_goods g ON g.goods_id = cn.goods_id')
            ->where("collocation_id='$collocation_id'")->alias('cn')->select();
        $collocation['node_list'] = $node_list;

        $collocation['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $collocation['image']);

        request_result('', 0, $collocation);
    }

    //评论搭配
    public function collocationComment(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $collocation_id = I('post.collocation_id');
        $content = I('post.content');

        $param[] = array('key'=>'collocation_id','msg'=>'搭配id','is_str'=>1);
        $param[] = array('key'=>'content','msg'=>'评论内容','is_str'=>1);
        param_validate($param);//非空判断

        $query = D('Collocation')->comment_collocation($user_id,$content,$collocation_id);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取搭配评论列表
    public function getCollocationComment(){
        $page = I('post.page',1);
        $collocation_id = I('post.collocation_id');
        $list = M('CollocationComment')
            ->field('cc.content,cc.time,u.nickname,u.image')
            ->join('axd_user u ON u.user_id = cc.user_id')
            ->where("cc.collocation_id='$collocation_id'")
            ->page($page,10)->order('time DESC')->alias('cc')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //分享搭配
    public function shareCollocation(){
        $id = I('id');
        $collocation = M('Collocation')
            ->field('title,introduce,image')
            ->find($id);
        $label_text = M('CollocationLabel')->where("collocation_id='$id'")->getField('label_text',true);
        $collocation['label_text'] = $label_text;
        $node_list = M('CollocationNode')
            ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text')
            ->join('axd_goods g ON g.goods_id = cn.goods_id')
            ->where("collocation_id='$id'")->alias('cn')->select();
        $collocation['node_list'] = $node_list;

        $this->assign('collocation',$collocation);
        $this->tc_yyb = C('TC_YYB');
        $this->display();
    }

    //获取商品节点
    public function getCGoodsNode(){
        $id = I('id');
        $node_list = M('CollocationNode')
            ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text,g.name')
            ->join('axd_goods g ON g.goods_id = cn.goods_id')
            ->where("collocation_id='$id'")->alias('cn')->select();
        $this->request_ajaxReturn('', 0, $node_list);
    }
}