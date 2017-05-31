<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	/*
	 * @description : 用户登录
	 * @paramer
	 * $phone 手机号码
	 * $password 密码
	 */
	public function user_login($phone, $password){
		$where['phone'] = $phone;
		$query = M('User')->where($where)->find();
		if(!$query) return array('msg'=>'该账号还没注册','errorCode'=>1);
		if($query['password']!=$password) return array('msg'=>'密码错误','errorCode'=>1);
		if($query['finish_info']==0) return array('msg'=>'资料未完善','errorCode'=>103);
		if($query['disable']==1) return array('msg'=>'该账号已被禁用,请联系管理员','errorCode'=>1);
		//更新登录信息
		$query['accesstoken']=noRand(30,1);
		$ip = $_SERVER["REMOTE_ADDR"];
		$query['last_login']=time();
		$query['last_ip']=$ip;
		M('User')->save($query);
		return array('msg'=>'登录成功','errorCode'=>0,'merchant'=>$query,);
	}

    /**
     * 兑换积分商品
     * @param $user 用户信息
     * @param $good 商品信息
     * @param $name 联系人
     * @param $link_phone 联系方式
     * @param $address 收获地址
     * @return array
     */
    public function exchange_goods($user,$good,$name,$link_phone,$address){
        $model = new Model();
        $model->startTrans();

        $user_id = $user['user_id'];
        $integral = $good['integral'];

        $order_data['i_goods_id'] = $good['i_goods_id'];
        $order_data['good_name'] = $good['name'];
        $order_data['image'] = $good['image'];
        $order_data['integral'] = $integral;
        $order_data['user_id'] = $user_id;
        $order_data['link_name'] = $name;
        $order_data['link_phone'] = $link_phone;
        $order_data['address'] = $address;
        $order_data['time'] = time();
        $order_data['type'] = 0;
        //订单生成规则：934(3)+年的后2位+月+日+用户id+随机数(4)
        $order_data['order_no'] = '934'.date('Ymd').$user['user_id'].noRand(4);
        $res = $model->table(C('DB_PREFIX').'integral_order')->add($order_data);
        $integral_data['user_id'] = $user_id;
        $integral_data['integral'] = -$integral;
        $integral_data['time'] = time();
        $integral_data['note'] = '积分商品兑换';
        $integral_data['type'] = 3;
        $res2 = $model->table(C('DB_PREFIX').'sign')->add($integral_data);
        $res3 = $model->table(C('DB_PREFIX').'merchant')->where("user_id='$user_id'")->setDec('integral',$integral);
        if ($res && $res2 && $res3) {
            $model->commit();
            return array('msg'=>'兑换成功','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>'兑换失败','errorCode'=>'1');
        }
    }
}