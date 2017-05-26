<?php
namespace Api\Model;
use Think\Model;
class CollocationModel extends Model{

    /**
     * 搭配收藏/取消收藏
     * @param $collocation_id 搭配id
     * @param $user_id 用户id
     * @param $type 类型 0:收藏 1:取消收藏
     */
    public function collocation_collect($collocation_id,$user_id,$type){
        $model = new Model();
        $model->startTrans();

        $data['collocation_id'] = $collocation_id;
        $data['user_id'] = $user_id;
        $coll = $model->table(C('DB_PREFIX').'collocation_collect')->where($data)->find();
        if('0'==$type){
            if(empty($coll)){
                $data['time'] = time();
                $res = $model->table(C('DB_PREFIX').'collocation_collect')->add($data);
                $res2 = $model->table(C('DB_PREFIX').'collocation')->where("collocation_id='$collocation_id'")->setInc('collect_count',1);
            }else{
                return array('msg'=>'收藏成功','errorCode'=>'0',);
            }
        }else{
            $str = '取消';
            if(!empty($coll)){
                $res = $model->table(C('DB_PREFIX').'collocation_collect')->where($data)->delete();
                $res2 = $model->table(C('DB_PREFIX').'collocation')->where("collocation_id='$collocation_id'")->setDec('collect_count',1);
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

    /**
     * 评论搭配
     * @param $user_id 用户id
     * @param $content 评论内容
     * @param $collocation_id 搭配id
     */
    public function comment_collocation($user_id,$content,$collocation_id){
        $model = new Model();
        $model->startTrans();

        $data['collocation_id'] = $collocation_id;
        $data['user_id'] = $user_id;
        $data['content'] = $content;
        $data['time'] = time();

        $res = $model->table(C('DB_PREFIX').'collocation_comment')->add($data);
        $res2 = $model->table(C('DB_PREFIX').'collocation')
            ->where("collocation_id='$collocation_id'")->setInc('comment_count',1);

        if ($res && $res2) {
            $model->commit();
            return array('msg'=>'评论成功','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>'评论失败','errorCode'=>'1');
        }
    }
}