<?php

namespace Api\Logic;
use Think\Model\RelationModel;

class MerchantLogic extends RelationModel {
    /**
     * 更新餐厅签到时间
     * @param $user_id 更新用户Id
     * @param $wait_time 等待时间
     * @param $merchant_id 商家Id
     */
    public function update_wait_time($user_id,$wait_time,$merchant_id){
        $where['merchant_id'] = $merchant_id;
        $data['wait_time_user_id'] = $user_id;
        $data['wait_time'] = $wait_time;
        $data['wait_time_update'] = date('Y-m-d H:i:s',time());
        if(false!==M('Merchant')->where($where)->save($data)){
            return array('msg'=>'updated','errorCode'=>'0');
        }else{
            return array('msg'=>'updated fails','errorCode'=>'1');
        }
    }

    /**
     * 更新餐厅描述信息
     * @param $user_id 更新用户Id
     * @param $description 信息描述
     * @param $merchant_id 商家Id
     */
    public function update_description($user_id,$description,$merchant_id){
        $where['merchant_id'] = $merchant_id;
        $data['description_user_id'] = $user_id;
        $data['description'] = $description;
        $data['description_update'] = date('Y-m-d H:i:s',time());
        if(false!==M('Merchant')->where($where)->save($data)){
            return array('msg'=>'updated','errorCode'=>'0');
        }else{
            return array('msg'=>'updated fails','errorCode'=>'1');
        }
    }

    /**
     * 上传餐厅图片
     * @param $user_id 用户Id
     * @param $merchant_id 商家Id
     * @param $image 图片
     * @param $introduce 图片介绍
     */
    public function upload_merchant_photo($user_id,$merchant_id,$image,$introduce){
        if($image!=''){
            $imageList=explode(",",$image);
            //将base64解析为图片，存进相应的文件夹，并把路径保存在数据里
            foreach($imageList as $key=>$val){
                $pic_url=file_upload($val,"png","merchant_image");   //生成图片并保存在相应的文件夹，file_upload()返回图片保存过后的链接
            }
            $data['image'] = $pic_url;
        }
        $data['user_id'] = $user_id;
        $data['merchant_id'] = $merchant_id;
        $data['introduce'] = $introduce;
        $data['praise_count'] = 0;
        $data['add_time'] = date('Y-m-d H:i:s',time());
        if(false!==M('MerchantImage')->add($data)){
            return array('msg'=>'uploaded','errorCode'=>'0',);
        }else {
            return array('msg'=>'upload fails','errorCode'=>'1');
        }
    }

    /**
     * 添加/编辑菜品
     * @param $foods_vote_id 菜品Id(编辑时必传)
     * @param $user_id 用户Id
     * @param $merchant_id 商家Id
     * @param $foods_name 菜品名称
     * @param $foods_price 菜品价格
     * @param $allergens_str 菜品原料标签
     * @param $diets_str 营养成分标签
     */
    public function edit_foods_votes($foods_vote_id,$user_id,$merchant_id,$foods_name,$foods_price,$allergens_str,$diets_str){
        if(empty($foods_vote_id)){//添加

        }else{//编辑

        }
    }

}