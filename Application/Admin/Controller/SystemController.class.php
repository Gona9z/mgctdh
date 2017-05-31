<?php
namespace Admin\Controller;
use Think\Controller;
use Common\JPush;
class SystemController extends AdminBaseController  {
    public function index(){
    }

    //推送记录列表
    public function pushList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['content'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('PushRecord')->where($where)->page($page,20)->order('time DESC')->select();
        //数据分页
        $count = M('PushRecord')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //删除推送记录
    public function delPushRecord(){
        $id = I('id');
        if(false!==M('PushRecord')->where("push_id='$id'")->delete()){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    //意见反馈列表
    public function opinionList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['u.nickname'] = array('like','%'.$keyword.'%');
        $where['fb.content'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $page = I('p',1);
        $this->list = M('Opinion')
            ->field('fb.*,u.nickname')
            ->join('ar_user u ON u.user_id = fb.user_id')
            ->alias('fb')
            ->where($where)->page($page,20)->select();
        //数据分页
        $count = M('Opinion')->join('ar_user u ON u.user_id = fb.user_id')
            ->alias('fb')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //推送消息
    public function addPush(){
        if(IS_GET){
            $this->school_list = M('School')->select();
            $this->display();
        }else{
            try{
                $push_type = I('push_type',0);
                $content = I('content');
                $this->empty_ajaxReturn(array($data['content']=$content),array('推送内容'));

                $app_key = C('JG_APP_KEY');
                $master_secret = C('JG_MASTER_SECRET');
                $client = new \Common\JPush\Client($app_key, $master_secret);
                $ios_notification = array(
                    'alert' => C('PRO_NAME').'-系统推送',
                    'sound' => 'default'
                );
                $android_notification = array(
                    'title' => C('PRO_NAME').'系统推送',
                );

                if('0'==$push_type){
                    $result = $client->push()
                        ->setPlatform('all')
                        ->addAllAudience('all')
                        ->androidNotification($content,$android_notification)
                        ->iosNotification($content,$ios_notification)
//                    ->setSmsMessage()
//                    ->setOptions(null,null,null,false,null)
                        ->send();
                }elseif ('1'==$push_type){
                    $phone = I('phone');
                    $this->empty_ajaxReturn(array($data['type_id']=$phone),array('推送号码'));
                    $user = M('User')->where("phone='$phone'")->find();
                    if(empty($user)){
                        $this->request_ajaxReturn('没用该用户信息',1);
                    }
                    $result = $client->push()
                        ->setPlatform('all')
                        ->addAlias($phone)
                        ->androidNotification($content,$android_notification)
                        ->iosNotification($content,$ios_notification)
//                    ->setOptions(null,null,null,false,null)
                        ->send();
                }else{
                    $tag = I('school_id');
                    $this->empty_ajaxReturn(array($data['type_id']=$tag),array('推送学校'));
                    $count = M('User')->where("school_id='$tag'")->count();
                    if($count<=0){
                        $this->request_ajaxReturn('该学校没有用户数据', 1);
                    }
                    $result = $client->push()
                        ->setPlatform('all')
                        ->addTag($tag)
                        ->androidNotification($content,$android_notification)
                        ->iosNotification($content,$ios_notification)
//                    ->setOptions(null,null,null,false,null)
                        ->send();
                }
                if('200'==$result['http_code']){
                    $data['push_type'] = $push_type;
                    $data['time'] = time();
                    M('PushRecord')->add($data);
                    $this->request_ajaxReturn('推送成功', 0);
                }else{
                    $this->request_ajaxReturn('推送失败,请刷新后重试', 1);
                }
            }catch (\Exception $e){
                $this->request_ajaxReturn('用户暂未登录过,无法推送',1);
            }
        }
    }

    //服务协议
    public function serviceAgreement(){
        if(IS_GET){
            $this->service = M('Service')->find();
            $this->display();
        }else{
            $service = I('service');
            if(false!==M('Service')->where('id=1')->setField('service',$service)){
                $this->request_ajaxReturn('修改成功', 0);
            }else{
                $this->request_ajaxReturn('修改失败', 1);
            }
        }
    }

    //操作记录
    public function adminRecord(){
        $this->display();
    }

    //删除意见反馈
    public function delFeed(){
        $id = I('id');
        if(false!==M('Feedback')->where("feed_id='$id'")->delete()){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    public function alibaichuan(){
        $c = new TopClient;
        $c->appkey = '23464475';
        $c->secretKey = '6d5a9dfdcdbc3e03af319839fedd3888';
        $req = new TaeItemDetailGetRequest;
        $req->setId("AAEkwBGKAAXszj-DOJ-KKVll");
        $req->setFields("itemInfo,priceInfo,skuInfo,stockInfo,rateInfo,descInfo,sellerInfo,mobileDescInfo,deliveryInfo,storeInfo");
        $resp = $c->execute($req);
    }

    //客服热线
    public function customerPhone(){
        if(IS_GET){
            $this->phone = M('Customer')->where("phone_id=1")->getField('phone');
            $this->display();
        }else{
            $phone = I('phone');
            if(false!==M('Customer')->where('phone_id=1')->setField('phone',$phone)){
                $this->request_ajaxReturn('修改成功', 0);
            }else{
                $this->request_ajaxReturn('修改失败', 1);
            }
        }
    }

    //版本更新
    public function versionManage(){
        $this->list = M('Version')->order('type')->select();
        $this->display();
    }

    //更新安装包版本
    public function updateVersion(){
        $type = I('type');//1iOS 2Android
        $param_arr = array(
            $data['version'] = I('version'),
            $data['note'] = I('note')
        );
        $this->empty_ajaxReturn($param_arr,array('版本号','更新内容'));

        if('2'==$type){
            $ov = M('Version')->where("type='$type'")->find();
            if($_FILES['android_apk']!=''&&!empty($_FILES['android_apk'])&&'2'==$type){
                $res = upload_file($_FILES['android_apk'],'install_package');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->ajaxReturn(array('msg'=>'编辑失败,'.$res['msg'],'errorCode'=>1));
                }else{          //文件上传成功
                    unlink('.'.$ov['url']);
                    $file_url = $res['file_name'];
                    $data['url'] = $file_url;
                }
            }
        }
        if(false!==M('Version')->where("type='$type'")->save($data)){
            $this->ajaxReturn(array('msg'=>'更新成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'更新失败,请刷新后重试','errorCode'=>1));
        }
    }
}