<?php
namespace Home\Controller;
use Think\Controller;
class SubjectController extends HomeBaseController  {
    public function index(){
        $g_cate_id = 1;
        $cate_list = M('GoodsCate')->field('g_cate_id,name')
            ->where("parent_id='$g_cate_id'")->select();
        $this->display();
    }

    //美文列表
    public function subjectList(){
        $sex_id = I('sex_id',2);
        $sex_object['s_cate_id'] = 0;
        $user = session('axd_user');
        $user_id = $user['user_id'];
        if('1'==$sex_id){
            $sex_object['name'] = '男神';
        }else{
            $sex_object['name'] = '女神';
        }
        $this->assign('sex_object',$sex_object);//添加默认性别选中

        $s_cate_id = I('s_cate_id');
        $this->assign('sex_id',$sex_id);//男神女神id
        $this->assign('s_cate_id',$s_cate_id);//分类id
        if('0'!=$s_cate_id && ''!=$s_cate_id){
            $where['s.s_cate_id'] = $s_cate_id;
        }
        $cate_list = M('SubjectCate')->select();
        $this->assign('cate_list',$cate_list);//美文分类列表
        $page = I('p',1);

        $where['sex'] = $sex_id;
        $this->subject_list = M('Subject')
            ->field('s.subject_id,s.image,s.`name`,s.text_content,scl.user_id')
            ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
            ->join("LEFT JOIN axd_subject_collect scl ON scl.subject_id = s.subject_id AND scl.user_id = '$user_id'")
            ->where($where)->order('s.add_time DESC')->page($page,18)
            ->alias('s')->select();

        $count = M('Subject')
            ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
            ->join("LEFT JOIN axd_subject_collect scl ON scl.subject_id = s.subject_id AND scl.user_id = '$user_id'")
            ->where($where)->alias('s')->count();
        //数据分页
        $Page = new \Think\Page($count,24);
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);
        $this->display();
    }

    //搜索美文
    public function searchSubject(){
        $user = session('axd_user');
        $page = I('p',1);
        $keyword = I('keyword');
        $this->assign('keyword',$keyword);
        $where['s.name']=array('like','%'.$keyword.'%');
        $sex_id = I('sex_id',2);
        $sex_object['s_cate_id'] = 0;
        if('1'==$sex_id){
            $sex_object['name'] = '男神';
        }else{
            $sex_object['name'] = '女神';
        }
        $this->assign('sex_object',$sex_object);//添加默认性别选中
        $s_cate_id = I('s_cate_id');
        $this->assign('sex_id',$sex_id);//男神女神id
        $this->assign('s_cate_id',$s_cate_id);//分类id
        if('0'!=$s_cate_id && ''!=$s_cate_id){
            $where['s.s_cate_id'] = $s_cate_id;
        }
        $where['s.sex'] = $sex_id;
        $cate_list = M('SubjectCate')->select();
        $this->assign('cate_list',$cate_list);//美文分类列表
        $page = I('p',1);
        if(empty($user)){
            $subject_list = M('Subject')
                ->field('s.subject_id,s.image,s.`name`,s.text_content')
                ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
                ->where($where)->alias('s')->order('s.add_time DESC')->page($page,18)->select();
        }else{
            $user = session('axd_user');
            $user_id = $user['user_id'];
            $subject_list = M('Subject')
                ->field('s.subject_id,s.image,s.`name`,s.text_content,scl.user_id')
                ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
                ->join("LEFT JOIN axd_subject_collect scl ON scl.subject_id = s.subject_id AND scl.user_id = '$user_id'")
                ->where($where)->alias('s')->order('s.add_time DESC')->page($page,18)->select();
        }
        $this->assign('subject_list',$subject_list);//美文列表

        $count = M('Subject')
            ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
            ->where($where)->alias('s')->count();
        //数据分页
        $Page = new \Think\Page($count,18);
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);
        $this->assign('URL',__ACTION__);

        $this->display();
    }

    //收藏美文
    public function collectSubject(){
        $user = session('axd_user');
        if(empty($user)){
            $this->error('不在登录状态','Index/index');
        }
        $subject_id = I('sid');
        $subject = M('Subject')->find($subject_id);
        if(empty($subject)){
            request_result('没有该美文信息', 1);
        }
        $type = I('post.type');
        $query = D('Subject')->subject_collect($subject_id, $user['user_id'], $type);
        $data = array(
            'msg'   =>  $query['msg'],
            'errorCode' =>  $query['errorCode'],
        );
        $this->ajaxReturn($data);
    }

    //美文详情
    public function subjectDetail(){
        $this->url = C('WEB_URL');
//        $this->url = 'http://192.168.0.187:8088/axd/';
        $subject_id = I('sid');
        $this->sid = $subject_id;
        $this->subject = M('Subject')->find($subject_id);
        $this->goods_list = M('Goods')
            ->field('g.*')
            ->join('axd_subject_goods sg ON sg.goods_id = g.goods_id')
            ->alias('g')
            ->where("subject_id='$subject_id'")->select();
        $user = session('axd_user');
        $where['user_id'] = $user['user_id'];
        $where['subject_id'] = $subject_id;
        $this->is_coll = M('SubjectCollect')->where($where)->count();
        $this->display();
    }

    //获取美文评论
    public function subjectComment(){
        $page = I('page',1);
        $pageSize = 10;
        $methodName = I('methodName');
        $subject_id = I('sid');
        $where['subject_id'] = I('sid');
        $comment_list = M('SubjectComment')
            ->field('u.*,sc.content,sc.time')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->alias('sc')->order('time DESC')->where($where)->page($page,$pageSize)->select();
        foreach($comment_list as $key=>$val){
            $comment_list[$key]['time'] = DateFormat::diff($val['time']);
        }

        $count = M('SubjectComment')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->alias('sc')->where($where)->count();
        $show = getGoodsAjaxPageShow($count, $pageSize, $page,$methodName, $subject_id);
        $data = array(
            'comment_list'    =>  $comment_list,
            'page_info' =>  $show,
        );
        $this->ajaxReturn($data);
    }

    //评论美文
    public function commentSubject(){
        $user = session('axd_user');
        if(empty($user)){
            $this->error('不在登录状态','Index/index');
        }
        $content = I('content');
        if(empty($content)){
            $this->ajaxReturn(array('msg'=>'评论内容不能为空','errorCode'=>1));
        }
        $subject_id = I('sid');
        if(empty($subject_id)){
            $this->ajaxReturn(array('msg'=>'数据错误,请刷新重试','errorCode'=>1));
        }
        $data['user_id'] = $user['user_id'];
        $data['content'] = $content;
        $where['subject_id'] = $data['subject_id'] = $subject_id;
        $data['time'] = time();
        $res = M('SubjectComment')->add($data);
        $res = M('Subject')->where($where)->setInc('comment_count',1);
        if($res){
            $this->ajaxReturn(array('msg'=>'评论成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'评论失败','errorCode'=>1));
        }
    }

    public function addSubjectShare(){
        $subject_id = I('sid');
        $user = session('axd_user');
        $user_id = $user['user_id'];
        $data['user_id'] = $user_id;
        $data['type'] = 2;
        $data['type_id'] = $subject_id;
        $is_col = M('ShareRecord')->where($data)->find();
        if(empty($is_col)){
            $data['time'] = time();
            if (false!==M('ShareRecord')->add($data)) {
                M('Subject')->where("subject_id='$subject_id'")->setInc('share_count');
                $this->ajaxReturn(array('msg'=>'添加成功','errorCode'=>0));
            }else {
                $this->ajaxReturn(array('msg'=>'添加失败','errorCode'=>1));
            }
        }else{
            $this->ajaxReturn(array('msg'=>'添加成功','errorCode'=>1));
        }
    }
}