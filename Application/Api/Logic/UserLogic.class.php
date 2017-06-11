<?php

namespace Api\Logic;
use Think\Model;
use Think\Model\RelationModel;

class UserLogic extends RelationModel {
    /**
     * 用户登录
     * @param $account
     * @param $open_id
     */
    public function user_login($account,$open_id){

    }

    /**
     * 用户签到
     * @param $user_id
     * @param $merchant_id
     */
    public function user_sign($user_id,$merchant_id){
        $data['user_id'] = $where['user_id'] = $user_id;
        $data['merchant_id'] = $where['merchant_id'] = $merchant_id;
        $where['add_time'] = array('LIKE',date('Y-m-d',time()).'%');
        $record = M('SignRecord')->where($where)->find();
        if(empty($record)){
            $model = new Model();
            $model->startTrans();
            $data['add_time'] = date('Y-m-d H:i:s',time());
            //添加用户个人添加记录
            $res1 = $model->table(C('DB_PREFIX').'sign_record')->add($data);
            if(false===$res1){
                $model->rollback();
                return array('msg'=>'already checked in today','errorCode'=>'1');
            }
            $data2['user_id'] = $where2['user_id'] = $user_id;
            $data2['merchant_id'] = $where2['merchant_id'] = $merchant_id;
            $m_record = M('UserSignCount')->where($where2)->find();
            if(empty($m_record)){//在当前商家未签到过
                $data2['last_time'] = date('Y-m-d H:i:s',time());
                $data2['sign_count'] = 1;
                $res2 = $model->table(C('DB_PREFIX').'user_sign_count')->add($data2);
                if(false===$res2){
                    $model->rollback();
                    return array('msg'=>'checked in fails','errorCode'=>'1');
                }
            }else{//在当前商家签到过,更新天道时间,增加签到统计
                $where3['usc_id'] = $m_record['usc_id'];
                $res3 = $model->table(C('DB_PREFIX').'user_sign_count')->where($where3)->setInc('sign_count',1);
                if(false===$res3){
                    $model->rollback();
                    return array('msg'=>'checked in fails','errorCode'=>'1');
                }
            }
            $model->commit();
            return array('msg'=>'checked in','errorCode'=>'0');
        }else{
            return array('msg'=>'already checked in today','errorCode'=>'1');
        }
    }

    /**
     * 更新签到心情
     * @param $user_id
     * @param $merchant_id
     * @param $type
     */
    public function update_emoji($user_id,$merchant_id,$emoji_type){
        $where['user_id'] = $user_id;
        $where['merchant_id'] = $merchant_id;
        $where['add_time'] = array('LIKE',date('Y-m-d',time()).'%');
        $record = M('SignRecord')->where($where)->find();
        if(empty($record)){//用户未签到,无法更新心情
            return array('msg'=>"you have't checked in today",'errorCode'=>'1');
        }else{
            if(!empty($record['emoji_type'])){//判断今天是否更新过心情
                return array('msg'=>"you have been updated",'errorCode'=>'1');
            }
            $model = new Model();
            $model->startTrans();
            $where2['merchant_id'] = $merchant_id;
            switch ($emoji_type){
                case '1':
                    $update_str = 'emoji_one';
                    break;
                case '2':
                    $update_str = 'emoji_two';
                    break;
                case '3':
                    $update_str = 'emoji_three';
                    break;
                case '4':
                    $update_str = 'emoji_four';
                    break;
                case '5':
                    $update_str = 'emoji_five';
                    break;
            }
            //添加餐厅心情数量
            $res = $model->table(C('DB_PREFIX').'merchant')->where($where2)->setInc($update_str,1);
            if(false===$res){
                $model->rollback();
                return array('msg'=>"you have't checked in today",'errorCode'=>'1');
            }
            //添加个人签到心情
            $where3['sign_record_id'] = $record['sign_record_id'];
            $data3['emoji_type'] = $emoji_type;
            $res2 = $model->table(C('DB_PREFIX').'sign_record')->where($where3)->save($data3);
            if(false===$res2){
                $model->rollback();
                return array('msg'=>"you have't checked in today",'errorCode'=>'1');
            }
            $model->commit();
            return array('msg'=>"you have't checked in today",'errorCode'=>'0');
        }
    }
}