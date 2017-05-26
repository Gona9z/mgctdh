<?php
namespace Api\Model;
use Think\Model;
class GoodsModel extends Model{

    /**
     * 商品评论
     * @param $user_id 用户id
     * @param $content 评论内容
     * @param $good_id 商品id
     * @return array
     */
    public function comment_goods($user_id,$content,$good_id){
        $data['good_id'] = $good_id;
        $data['user_id'] = $user_id;
        $data['content'] = $content;
        $data['time'] = time();
        $res = M('GoodsComment')->add($data);
        if ($res) {
            return array('msg'=>'评论成功','errorCode'=>'0',);
        }else {
            return array('msg'=>'评论成功','errorCode'=>'1');
        }
    }

    /**
     * 商品收藏/取消收藏
     * @param $good_id 商品id
     * @param $user_id 用户id
     * @param $type 类型 0:收藏 1:取消收藏
     */
    public function good_collect($good_id,$user_id,$type){
        $model = new Model();
        $model->startTrans();

        $data['good_id'] = $good_id;
        $data['user_id'] = $user_id;
        $coll = $model->table(C('DB_PREFIX').'goods_collect')->where($data)->find();
        if('0'==$type){
            if(empty($coll)){
                $data['time'] = time();
                $res = $model->table(C('DB_PREFIX').'goods_collect')->add($data);
                $res2 = $model->table(C('DB_PREFIX').'goods')->where("goods_id='$good_id'")->setInc('collect_count',1);
            }else{
                return array('msg'=>'收藏成功','errorCode'=>'0',);
            }
        }else{
            $str = '取消';
            if(!empty($coll)){
                $res = $model->table(C('DB_PREFIX').'goods_collect')->where($data)->delete();
                $res2 = $model->table(C('DB_PREFIX').'goods')->where("goods_id='$good_id'")->setDec('collect_count',1);
            }else{
                return array('msg'=>$str.'收藏成功','errorCode'=>'0',);
            }
        }
        if ($res && $res2) {
            $model->commit();
            return array('msg'=>$str.'收藏成功','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>$str.'收藏失败','errorCode'=>'1');
        }
    }
}