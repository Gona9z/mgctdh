<?php
namespace Api\Model;
use Think\Model;
class UserModel extends Model{
	/*
	 * @description : 用户注册
	 * @paramer
	 * $mobile_phone 手机号码
	 * $password 密码
	 */
	public function user_register($phone, $password, $open_id,$image_url,$nickname){
		$where['phone'] = $phone;
		$query = M('User')->where($where)->find();
		if($query){
			return array('msg'=>'手机号已被注册','errorCode'=>1);
		}else{
		    if(''!=$open_id && !empty($open_id)){
                $data['open_id'] = $open_id;
                //抓取图片地址并保存
//                $image = 'Public/uploads/merchant/'.time().'.jpg';
//                file_put_contents($image,file_get_contents($image_url));
//                $data['image'] = '/'.$image;
                $data['image'] = $image_url;
                $data['nickname'] = $nickname;
            }else{
                $data['nickname'] = 'am_'.noRand(6).substr($phone,7);
            }
            $data['phone'] = $phone;
            $data['password'] = md5($password);
            $data['integral'] = 0;
            $data['sign_day'] = 0;
            $data['finish_info'] = 0;
            $data['reg_time'] = time();
            $data['disable'] = 0;

			if(false!==M('User')->add($data)) {
				return array('msg'=>'注册成功','errorCode'=>'0');
			}else {
				return array('msg'=>'注册失败','errorCode'=>'1');
			}
		}
	}
	
	/*
	 * @description : 用户登录
	 * @paramer
	 * $phone 手机号码
	 * $password 密码
	 */
	public function user_login($phone, $password){
		$where['phone'] = $phone;
		$query = M('User')->where($where)->find();
		if(!$query) return array('msg'=>'该账号还没注册','errorCode'=>105);
		if($query['password']!=md5($password)) return array('msg'=>'密码错误','errorCode'=>1);
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
	/*
	 * @description : 修改用户信息
	 * @paramer
	 * $account 账号
	 * $vcode 验证码
	 * $password 密码
	 */
	public function editUserInfo($phone,$nickname,$sex,$birthday,$single,$school_id,$image){
		$user = M('User')->where("phone='$phone'")->find();
        if(empty($user)){
            return array('msg'=>'没有该用户信息','errorCode'=>'1');
        }
		if($image!=''){
			$imageList=explode(",",$image);
			//将base64解析为图片，存进相应的文件夹，并把路径保存在数据里
			foreach($imageList as $key=>$val){
				$pic_url=file_upload($val,"png","merchant");   //生成图片并保存在相应的文件夹，file_upload()返回图片保存过后的链接
			}
			$data['image'] = $pic_url;
			unlink('.'.$user['image']);
		}
		if(''!=$nickname)	$data['nickname'] = $nickname;
    	if(''!=$sex)	$data['sex'] = $sex;
    	if(''!=$birthday)	$data['birthday'] = $birthday;
    	if(''!=$single)	$data['single'] = $single;
    	if(''!=$school_id)	$data['school_id'] = $school_id;

        $res = M('User')->where("phone='$phone'")->save($data);
        if('0'==$user['finish_info']){
            $u2 = M('User')->where("phone='$phone'")->find();
            if(''!=$u2['sex']&&''!=$u2['birthday']&&''!=$u2['single']&&''!=$u2['school_id']){
                M('User')->where("phone='$phone'")->setField('finish_info','1');
            }
        }
        if(false!==$res) {
            return array('msg'=>'修改成功','errorCode'=>'0');
        }else {
            return array('msg'=>'修改失败','errorCode'=>'1');
        }
	}

    /**
     * @description : 用户签到
     * @param $user 用户信息
     * @return array
     * 1. 每天首页签到奖励 5 积分
     * 2. 第 7 天连续签到额外奖励 20 积分
     * 3. 第 15 天连续签到额外奖励 30 积分
     * 4. 第 30 天连续签到额外奖励 50 积分
     * 5. 连续签到天数超过 30 天后，每天签到奖励升级为 10 积分
     */
	public function user_sign($user){
        $model = new Model();
        $model->startTrans();

        $id = $user['user_id'];
        $sign_day = $user['sign_day'];
	    $sign_info = $model->table(C('DB_PREFIX').'sign')
            ->where("user_id='$id' AND integral>0 AND type=0")->order('time DESC')->select();

        if (date('Y-m-d') == date('Y-m-d',$sign_info[0]['time'])) {
            return array('msg'=>'您今天已经签到过了','errorCode'=>'1');
        }else{
            $yesterday = date("Y-m-d",strtotime("-1 day"));
            if($yesterday== date('Y-m-d',$sign_info[0]['time'])){
                $sign_day++;
            }else{
                $sign_day = 0;
            }

            $data[0]['user_id'] = $id;
            $data[0]['time'] = time();
            $data[0]['note'] = '每日签到';
            $data[0]['type'] = 0;
            $data[0]['integral'] = $inc_integral = 5;
            if($sign_day > 30){
                $data[0]['integral'] = $inc_integral = 10;
            }
            if('7'==$sign_day){
                $data[1]['user_id'] = $id;
                $data[1]['time'] = time();
                $data[1]['note'] = '连续签到额外奖励';
                $data[1]['type'] = 1;
                $data[1]['integral'] = 20;
                $inc_integral = $inc_integral + 20;
            }elseif('15'==$sign_day){
                $data[1]['user_id'] = $id;
                $data[1]['time'] = time();
                $data[1]['note'] = '连续签到额外奖励';
                $data[1]['type'] = 1;
                $data[1]['integral'] = 30;
                $inc_integral = $inc_integral + 30;
            }elseif('30'==$sign_day){
                $data[1]['user_id'] = $id;
                $data[1]['time'] = time();
                $data[1]['note'] = '连续签到额外奖励';
                $data[1]['type'] = 1;
                $data[1]['integral'] = 50;
                $inc_integral = $inc_integral + 50;
            }
            $res = $model->table(C('DB_PREFIX').'sign')->addAll($data);
            $sql = "UPDATE __PREFIX__user SET sign_day = '$sign_day',integral = integral + '$inc_integral' WHERE user_id = '$id'";
            $res2 = $model->execute($sql);

            if ($res!==false && $res2!==false) {
                $model->commit();
                return array('msg'=>'签到成功','errorCode'=>'0');
            }else {
                $model->rollback();
                return array('msg'=>'签到失败','errorCode'=>'1');
            }
        }
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
        //订单生成规则：934(3)+年的后2位(2)+月(2)+日(2)+用户id+随机数(4)
        $order_data['order_no'] = '934'.substr(date('Ymd'),2).$user['user_id'].noRand(4);
        $res = $model->table(C('DB_PREFIX').'integral_order')->add($order_data);
        $integral_data['user_id'] = $user_id;
        $integral_data['integral'] = -$integral;
        $integral_data['time'] = time();
        $integral_data['note'] = '积分商品兑换';
        $integral_data['type'] = 3;
        $res2 = $model->table(C('DB_PREFIX').'sign')->add($integral_data);
        $res3 = $model->table(C('DB_PREFIX').'merchant')->where("user_id='$user_id'")->setDec('integral',$integral);
        if ($res!==false && $res2!==false && $res3!==false) {
            $model->commit();
            return array('msg'=>'兑换成功','errorCode'=>'0',);
        }else {
            $model->rollback();
            return array('msg'=>'兑换失败','errorCode'=>'1');
        }
    }

	/*
	 * @description : 修改密码
	 * @paramer
	 * $uid 用户id
	 * $n_password 新密码
	 */
	public function modify_password($uid, $n_password){
		$res = M('User')->where("user_id='$uid'")->setField('password',md5($n_password));
		if (false!==$res) {
			return array('msg'=>'修改成功','errorCode'=>'0',);
		}else {
			return array('msg'=>'修改失败','errorCode'=>'1');
		}
	}

    /**@description ：提交意见反馈
     * @param $user_id 用户id
     * @param $content 反馈内容
     * @return array
     */
	public function submitFeed($user_id,$content){
        $data['user_id'] = $user_id;
        $data['content'] = $content;
        $data['time'] = time();
        if (false!==M('Feedback')->add($data)) {
            return array('msg'=>'反馈成功','errorCode'=>'0',);
        }else {
            return array('msg'=>'反馈失败','errorCode'=>'1');
        }
    }

    /**
     * @description ： 第三方登录
     * @param $open_id
     * @return array
     */
    public function open_login($open_id){
        $where['open_id'] = $open_id;
        $query = M('User')->where($where)->find();
        if(!$query) return array('msg'=>'该账号还没注册','errorCode'=>105);
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
     * 添加分享记录
     * @param $user_id 用户id
     * @param $type 分享类型（1美文2商品3帖子）
     * @param $id 美文id/商品id/帖子id
     */
    public function add_share($user_id, $type,$id){
        $data['user_id'] = $user_id;
        $data['type'] = $type;
        $data['type_id'] = $id;
        $is_col = M('ShareRecord')->where($data)->find();
        if(empty($is_col)){
            $data['time'] = time();
            if (false!==M('ShareRecord')->add($data)) {
                if('1'==$type){
                    M('Subject')->where("subject_id='$id'")->setInc('share_count');
                }elseif('2'==$type){
                    M('Merchant')->where("goods_id='$id'")->setInc('share_count');
                }else{
                    M('Interact')->where("interact_id='$id'")->setInc('share_count');
                }
                return array('msg'=>'添加成功','errorCode'=>'0',);
            }else {
                return array('msg'=>'添加失败','errorCode'=>'1');
            }
        }else{
            return array('msg'=>'添加成功','errorCode'=>'0',);
        }
    }
}