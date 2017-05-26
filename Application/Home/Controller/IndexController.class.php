<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeBaseController  {
    public function index(){
        //广告列表
        $this->banner = M('Banner')->order('order_n')->select();
        //用户登录状态
        $user = session('axd_user');
        $page = I('p',1);
        $Model = new \Think\Model();
        $user_id = $user['user_id'];
        $sql = "SELECT s.subject_id,s.image,s.`name`,s.text_content";
        if(!empty($user)){
            $sql .= ",sc.user_id";
        }
        $sql .= " FROM axd_subject s";
        if(!empty($user)){
            $sql .= " LEFT JOIN axd_subject_collect sc ON sc.subject_id = s.subject_id AND sc.user_id = '$user_id'";
        }
        $sql .= " GROUP BY s.subject_id ORDER BY s.add_time DESC LIMIT ".(($page-1)*24).",24";
        $subject_list = $Model->query($sql);
        $this->assign('subject_list',$subject_list);

        $count_sql = "SELECT COUNT(*) as count";
        $count_sql .= " FROM axd_subject s";
        if(!empty($user)){
            $count_sql .= " LEFT JOIN axd_subject_collect sc ON sc.subject_id = s.subject_id AND sc.user_id =  '$user_id'";
        }
        $count = $Model->query($count_sql);//按分类查询美文列表
        //数据分页
        $Page = new \Think\Page($count[0]['count'],24);
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);

        $this->display();
    }

    //关于我们
    public function aboutUs(){
        $this->event_list = M('Event')->order('time DESC')->select();
        $this->partner_list = M('Partner')->order('order_n')->select();
        $this->display();
    }

    //生成二维码 type 1:iOS 2:Android
    public function qr_code(){
        $type = I('type',1);
        if('1'==$type){
            qrcode('https://itunes.apple.com/us/app/id1150994778');
        }else{
            $url = M('Version')->where('type=2')->getField('url');
            qrcode(C('WEB_URL').$url);
        }
    }

    //商务合作
    public function business(){
        $this->display();
    }

    public function ApiTempIndex(){
        $this->display();
    }
}