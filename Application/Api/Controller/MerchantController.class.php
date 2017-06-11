<?php
namespace Api\Controller;
use Api\Logic\MerchantLogic;

class MerchantController extends ApiBaseController {
    public $merchantLogic;
    public function _initialize(){
        $this->merchant = new MerchantLogic();
    }

    //获取商家列表
    public function merchantList(){
        $page = I('page',1);
        $sort_by = I('sort_by');//0:distance 1:popularity
        $lat = I('lat');
        $lng = I('lng');
        $list = M('Merchant')
            ->field('merchant_id,merchant_name,merchant_address,image,merchant_phone,cuisine,lat,lng')
            ->where()->page($page,10)->select();
        request_result('', 0, $list);
    }

    //商家详情
    public function merchantDetails(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        //获取商家基本信息
        $merchant = M('Merchant')
            ->field('wait_time_user_id,description_user_id,lat,lng,add_time',true)
            ->find($merchant_id);
        if(empty($merchant)){
            request_result('ERROR MERCHANT', 1);
        }else{
            $where['merchant_id'] = $merchant_id;
            //获取商品图册前三张
            $photo = M('MerchantImage')
                ->field('merchant_id,user_id,add_time',true)
                ->where($where)->limit(1,3)->order('add_time DESC')->select();
            $merchant['photo'] = $photo;
            //获取菜品投票前三条
            $food_vote = M('FoodsVote')
                ->field('merchant_id,user_id,add_time',true)
                ->where($where)->limit(3)->order('add_time DESC')->select();
            $merchant['food_vote'] = $food_vote;
            //获取问答
            $qa_where['qa.merchant_id'] = $merchant_id;
            $qa_where['qa.type'] = 0;
            //获取问答总数
            $merchant['qa_count'] =  M('QuestionAnswer')->alias('qa')->count();
            //获取问答前三条
            $qa_list = M('QuestionAnswer')
                ->field('qa.qa_id,qa.content,qa.praise_count,qa.step_count,qa.add_time,u.nickname,u.image')
                ->join('ar_user u ON u.user_id = qa.user_id')->alias('qa')
                ->where($qa_where)->limit(3)->order('add_time DESC')->select();
            $merchant['qa_list'] = $qa_list;
            //获取好友签到人数 TODO:缺少好友关系链表补充
            $where['user_id'] = $user_id;
            $where['add_time'] = array('LIKE',date('Y-m-d',time()).'%');
            $sign_count = M('SignRecord')
                ->where($where)->count();
            $merchant['sign_count'] = $sign_count;
            request_result('', 0, $merchant);
        }
    }

    //获取商家图册
    public function merchantImages(){
        $page = I('page', 1);
        $where['merchant_id'] = I('merchant_id');
        $list = M('MerchantImage')
            ->field('merchant_id,user_id,add_time',true)
            ->where($where)->order('add_time DESC')->page($page,12)->select();
        if(empty($list)){
            request_result('load complete', 1);
        }else{
            request_result('', 0, $list);
        }
    }

    //所有菜品列表
    public function foodsVoteList(){
        $page = I('page', 1);
        $where['merchant_id'] = I('merchant_id');
        $list = M('FoodsVote')
            ->field('merchant_id,user_id,add_time',true)
            ->where($where)->order('add_time DESC')->page($page,10)->select();
        if(empty($list)){
            request_result('load complete', 1);
        }else{
            request_result('', 0, $list);
        }
    }

    //所有问答列表
    public function qaList(){
        $page = I('page', 1);
        $where['qa.merchant_id'] = I('merchant_id');
        $list = M('QuestionAnswer')
            ->field('qa.qa_id,qa.content,qa.praise_count,qa.step_count,qa.add_time,u.nickname,u.image')
            ->join('ar_user u ON u.user_id = qa.user_id')->alias('qa')
            ->where($where)->page($page,10)->order('add_time DESC')->select();
        if(empty($list)){
            request_result('load complete', 1);
        }else{
            request_result('', 0, $list);
        }
    }

    //问答详情
    public function qaDetails(){
        $qa_id = I('qa_id');
        $page = I('page',1);
        $qa = M('QuestionAnswer')
            ->field('qa.qa_id,qa.content,qa.praise_count,qa.step_count,qa.add_time,u.nickname,u.image')
            ->join('ar_user u ON u.user_id = qa.user_id')->alias('qa')
            ->find($qa_id);
        $where['reply_qa_id'] = $qa_id;
        $where['type'] = 1;
        $reply_list = M('QuestionAnswer');
        $qa['reply_list'] = $reply_list
            ->field('qa.qa_id,qa.content,qa.praise_count,qa.step_count,qa.add_time,u.nickname,u.image')
            ->join('ar_user u ON u.user_id = qa.user_id')->alias('qa')
            ->where($where)->page($page,10)->select();
        request_result('', 0, $qa);
    }

    //更新餐厅等待时间
    public function updateWaitTime(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $wait_time = I('wait_time');
        //判断商家非空
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->merchantLogic->update_wait_time($user_id,$wait_time,$merchant_id);
            request_result($query['msg'],$query['errorCode']);
        }
    }

    //更新餐厅信息描述
    public function updateDescription(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $description = I('description');
        //判断商家非空
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->merchantLogic->update_description($user_id,$description,$merchant_id);
            request_result($query['msg'],$query['errorCode']);
        }
    }

    //举报餐厅信息描述
    public function reportDescription(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        //判断商家非空
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->merchantLogic->update_description($user_id,$merchant_id);
            request_result($query['msg'],$query['errorCode']);
        }
    }

    //上传餐厅图册
    public function uploadMerchantPhoto(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $image = I('image');
        $introduce = I('introduce');
        //非空判断
        $param[] = array('key'=>'image','msg'=>'photo','is_str'=>1);
        $param[] = array('key'=>'introduce','msg'=>"photo's optional",'is_str'=>1);
        param_validate($param);
        //判断商家非空
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->merchantLogic->upload_merchant_photo($user_id,$merchant_id,$image,$introduce);
            request_result($query['msg'],$query['errorCode']);
        }
    }

    //获取菜品原料
    public function getFoodsAllergens(){
        $list = M('FoodsAllergens')->select();
        request_result('', 0, $list);
    }

    //获取菜品营养标签
    public function getFoodsDiets(){
        $list = M('FoodsDiets')->select();
        request_result('', 0, $list);
    }

    //发布/编辑菜品
    public function addEditFoodsVote(){
        $at = I('accesstoken');
        $user_id = getUserIdByAT($at);
        $merchant_id = I('merchant_id');
        $foods_vote_id = I('foods_vote_id');
        $foods_name = I('foods_name');
        $foods_price = I('foods_price');
        $allergens_str = I('allergens_str');
        $diets_str = I('diets_str');
        //判断商家非空
        $merchant = M('Merchant')->find($merchant_id);
        if(empty($merchant)){
            request_result('empty merchant info', 1);
        }else{
            $query = $this->merchantLogic
                ->edit_foods_votes($foods_vote_id,$user_id,$merchant_id,$foods_name,$foods_price,$allergens_str,$diets_str);
            request_result($query['msg'],$query['errorCode']);
        }
    }
}