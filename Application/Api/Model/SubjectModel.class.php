<?php
namespace Api\Model;
use Think\Model;
class SubjectModel extends Model{

    /**
     * 美文评论
     * @param $user_id 用户id
     * @param $content 评论内容
     * @param $subject_id 美文id
     */
    public function comment_subject($user_id,$content,$subject_id){
        $data['subject_id'] = $subject_id;
        $data['user_id'] = $user_id;
        $data['content'] = $content;
        $data['time'] = time();
        $res = M('SubjectComment')->add($data);
        if ($res) {
            M('Subject')->where("subject_id='$subject_id'")->setInc('comment_count');
            return array('msg'=>'评论成功','errorCode'=>'0',);
        }else {
            return array('msg'=>'评论失败','errorCode'=>'1');
        }
    }

    /**
     * 收藏/取消收藏美文
     * @param $subject_id 美文id
     * @param $user_id 用户id
     * @param $type 类型 0:收藏 1:取消收藏
     */
    public function subject_collect($subject_id,$user_id,$type){
        $model = new Model();
        $model->startTrans();

        $data['subject_id'] = $subject_id;
        $data['user_id'] = $user_id;
        $coll = $model->table(C('DB_PREFIX').'subject_collect')->where($data)->find();
        if('0'==$type){
            if(empty($coll)){
                $data['time'] = time();
                $res = $model->table(C('DB_PREFIX').'subject_collect')->add($data);
                $res2 = $model->table(C('DB_PREFIX').'subject')
                    ->where("subject_id='$subject_id'")->setInc('collect_count',1);
            }else{
                return array('msg'=>'收藏成功','errorCode'=>'0',);
            }
        }else{
            $str = '取消';
            if(!empty($coll)){
                $res = $model->table(C('DB_PREFIX').'subject_collect')->where($data)->delete();
                $res2 = $model->table(C('DB_PREFIX').'subject')
                    ->where("subject_id='$subject_id'")->setDec('collect_count',1);
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