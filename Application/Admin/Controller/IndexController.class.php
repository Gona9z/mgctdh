<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminBaseController  {
    public function index(){
        $this->redirect('Admin/Index/welp');
    }

    //登录页面
    public function login(){
        $this->display();
    }

    //欢迎页
    public function welp(){
        $this->display();
    }

    //启动页列表
    public function startPageList(){
        $page = I('p',1);
        $this->list = M('StartPage')->order('add_time DESC')->page($page,20)->select();
        $this->display();
    }

    //添加新启动页
    public function addEditStartPage(){
        $page_id = I('id');
        $page = M('StartPage')->find($page_id);
        if(IS_GET){
            $this->assign('page',$page);
            $this->display();
        }else{
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'start_page');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->ajaxReturn(array('msg'=>'编辑失败,'.$res['msg'],'errorCode'=>1));
                }else{          //文件上传成功
                    $data['image'] = $res['file_name'];
                    if(!empty($page)){
                        unlink('.'.$page['image']);
                    }
                }
            }
            $data['status'] = I('status',0);
            if('1'==$data['status']){
                M('StartPage')->where("status=1")->setField('status',0);
            }
            if(empty($page)){
                $this->empty_ajaxReturn(array($data['image']),array('搭配图片'));
                $data['add_time'] = date('Y-m-d H:i:s', time());
                if(false!==M('StartPage')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('StartPage')->where("page_id='$page_id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
            if('1'==$data['status']){
                M('StartPage')->where("status=1")->setField('status',0);
            }
    }

    //删除启动页
    public function delStartPage(){
        $page_id = I('id');
        if(false!==M('StartPage')->delete($page_id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

//    //启用启动页
//    public function enableStartPage(){
//        $page_id = I('sp_id');
//        M('StartPage')->where("status=1")->setField('status',0);
//        M('StartPage')->where("page_id='$page_id'")->setField('status',1);
//        $this->redirect('Index/startPageList');
//    }

    //PC大事件列表
    public function eventList(){
        $this->list = M('Event')->order('time')->select();
        //数据分页
        $count = M('Event')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //PC合作厂商列表
    public function partnerList(){
        $this->list = M('Partner')->order('order_n')->select();
        //数据分页
        $count = M('Partner')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //删除PC大事件
    public function delPartner(){
        $id = I('id');
        if(false!==M('Partner')->delete($id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //添加编辑PC大事件
    public function addEditEvent(){
        $id = I('id');
        if(IS_GET){
            $this->event = M('Event')->find($id);
            $this->display();
        }else{
            $data['time'] = strtotime(I('time'));
            $data['content'] = I('content','');
            if(empty($id)){
                if(false!==M('Event')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Event')->where("event_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //添加编辑合作厂商
    public function addEditPartner(){
        $partner_id = I('id');
        $partner = M('Partner')->find($partner_id);
        if(IS_GET){
            $this->assign('partner',$partner);
            $this->display();
        }else{
            $data['name'] = I('name');
            $data['link'] = I('link');
            $data['order_n'] = I('order');
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'partner');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($partner)){       //编辑---删除原图片
                        unlink('.'.$partner['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            if(empty($partner_id)){
                if(false!==M('Partner')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Partner')->where("partner_id='$partner_id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除PC大事件
    public function delEvent(){
        $event_id = I('id');
        if(false!==M('Event')->delete($event_id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //热门搜索列表
    public function hotKeyword(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['name'] = array('like','%'.$keyword.'%');
        $this->list = M('HotKeyword')->where($where)->order('id DESC')->select();
        $this->display();
    }

    //新增热门管理
    public function addHotKeyword(){
        if(IS_GET){
            $this->display();
        }else{
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('关键字'));
            if(false!==M('HotKeyword')->add($data)){
                $this->request_ajaxReturn('添加成功',0);
            }else{
                $this->request_ajaxReturn('添加失败,请刷新后重试',1);
            }
        }
    }

    //删除热门搜索
    public function delHotKeyword(){
        $id = I('id');
        if(false!==M('HotKeyword')->delete($id)){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    //快递列表
    public function expressList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['name'] = array('like','%'.$keyword.'%');
        $this->list = M('Express')->where($where)->order('id DESC')->select();
        $this->display();
    }

    //添加快递
    public function addExpress(){
        if(IS_GET){
            $this->display();
        }else{
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('快递名称'));
            if(false!==M('Express')->add($data)){
                $this->request_ajaxReturn('添加成功',0);
            }else{
                $this->request_ajaxReturn('添加失败,请刷新后重试',1);
            }
        }
    }

    //删除快递
    public function delExpress(){
        $id = I('id');
        if(false!==M('Express')->delete($id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //淘口令列表
    public function taoCommandList(){
        $page = I('p', 1);
        $keyword = I('keyword');
        if(!empty($keyword)){
            $keyword_mh = '%'.trim($keyword).'%';
            $where['u.nickname'] = array('like',$keyword_mh);
            $where['u.phone'] = array('like',$keyword_mh);
            $where['_logic'] = 'OR';
            $this->assign('keyword',$keyword);
        }
        $this->list = M('TaoCommand')
            ->join('axd_user u ON u.user_id = tc.user_id')
            ->alias('tc')->where($where)->order('time DESC')->page($page,20)->select();
        //数据分页
        $count = M('TaoCommand')
            ->join('axd_user u ON u.user_id = tc.user_id')
            ->alias('tc')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //处理淘口令
    public function dealTaoCommand(){
        $id = I('id');
        $phone = M('TaoCommand')
            ->join('axd_user u ON u.user_id = tc.user_id')
            ->where("tc.tao_id='$id'")->alias('tc')->getField('u.phone');
        $content = C('PRO_NAME').'用户您好,您提交的淘口令订单已经处理,赶紧搜索看看吧';
        $app_key = C('JG_APP_KEY');
        $master_secret = C('JG_MASTER_SECRET');
        $client = new \Common\JPush\Client($app_key, $master_secret);
        $ios_notification = array(
            'alert' => C('PRO_NAME').'-系统推送'
        );
        $android_notification = array(
            'title' => C('PRO_NAME').'系统推送',
        );
        $result = $client->push()
            ->setPlatform('all')
            ->addAlias($phone)
            ->androidNotification($content,$android_notification)
            ->iosNotification($content,$ios_notification)
//            ->setOptions(null,null,null,false,null)
            ->send();
        if('200'==$result['http_code']){
            $data['status'] = 1;
            M('TaoCommand')->where("tao_id='$id'")->save($data);
            $this->request_ajaxReturn('处理成功', 0);
        }else{
            $this->request_ajaxReturn('处理失败,请刷新后重试', 1);
        }
    }

    //处理淘口令页面
    public function dealTaoCommandPage(){
        $id = I('id');
        if(IS_GET){
            $this->tb_command = M('TaoCommand')
                ->join('axd_user u ON u.user_id = tc.user_id')
                ->where("tc.tao_id='$id'")->alias('tc')->find();
            $this->display();
        }else{
            try{
                $deal_content = I('deal_content');
                $this->empty_ajaxReturn(array($deal_content),array('处理说明'));
                $phone = M('TaoCommand')
                    ->join('axd_user u ON u.user_id = tc.user_id')
                    ->where("tc.tao_id='$id'")->alias('tc')->getField('u.phone');
                $content = $deal_content;
                $app_key = C('JG_APP_KEY');
                $master_secret = C('JG_MASTER_SECRET');
                $client = new \Common\JPush\Client($app_key, $master_secret);
                $ios_notification = array(
                    'alert' => C('PRO_NAME').'-系统推送'
                );
                $android_notification = array(
                    'title' => C('PRO_NAME').'系统推送',
                );
                $result = $client->push()
                    ->setPlatform('all')
                    ->addAlias($phone)
                    ->androidNotification($content,$android_notification)
                    ->iosNotification($content,$ios_notification)
//            ->setOptions(null,null,null,false,null)
                    ->send();
                if('200'==$result['http_code']){
                    $data['status'] = 1;
                    $data['deal_content'] = $deal_content;
                    M('TaoCommand')->where("tao_id='$id'")->save($data);
                    $this->request_ajaxReturn('处理成功', 0);
                }else{
                    $this->request_ajaxReturn('处理失败,请刷新后重试', 1);
                }
            }catch (\Exception $e){
                $this->request_ajaxReturn('用户暂未登录过,无法推送',1);
            }
        }
    }
}