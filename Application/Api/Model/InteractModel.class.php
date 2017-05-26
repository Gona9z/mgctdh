<?php
namespace Api\Model;
use Think\Model;
class InteractModel extends Model{

    /**
     * 帖子点赞
     * @param $interact_id 帖子id
     * @param $user_id 用户id
     * @param $type 类型 0:点赞 1:取消点赞
     */
    public function interact_praise($interact_id,$user_id,$type){
        $model = new Model();
        $model->startTrans();

        $data['interact_id'] = $interact_id;
        $data['user_id'] = $user_id;
        $interact = $model->table(C('DB_PREFIX').'interact_praise')->where($data)->find();
        if('0'==$type){
            if(empty($interact)){
                $res = $model->table(C('DB_PREFIX').'interact_praise')->add($data);
                $res2 = $model->table(C('DB_PREFIX').'interact')
                    ->where("interact_id='$interact_id'")->setInc('praise_count',1);
            }else{
                return array('msg'=>'','errorCode'=>'0',);
            }
        }else{
            if(!empty($interact)){
                $res = $model->table(C('DB_PREFIX').'interact_praise')->where($data)->delete();
                $res2 = $model->table(C('DB_PREFIX').'interact')
                    ->where("interact_id='$interact_id'")->setDec('praise_count',1);
            }else{
                return array('msg'=>'','errorCode'=>'0',);
            }
        }
        if (false!==$res && false!==$res2) {
            $model->commit();
            return array('msg'=>'','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>'','errorCode'=>'1');
        }
    }

    /**
     * 评论帖子
     * @param $user_id 用户id
     * @param $content 评论内容
     * @param $interact_id 帖子id
     */
    public function comment_interact($user_id,$content,$interact_id){
        $model = new Model();
        $model->startTrans();

        $data['interact_id'] = $interact_id;
        $data['user_id'] = $user_id;
        $data['content'] = $content;
        $data['time'] = time();

        $res = $model->table(C('DB_PREFIX').'interact_comment')->add($data);
        $res2 = $model->table(C('DB_PREFIX').'interact')
            ->where("interact_id='$interact_id'")->setInc('comment_count',1);

        if ($res && $res2) {
            $model->commit();
            return array('msg'=>'评论成功','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>'评论成功','errorCode'=>'1');
        }
    }
}