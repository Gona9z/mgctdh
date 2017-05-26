<?php
namespace Api\Controller;
use Think\Controller;
class SubjectController extends ApiBaseController {

    //获取专题分类
    public function getSubjectCate(){
        $list = M('SubjectCate')->select();
        request_result('', 0, $list);
    }

    //根据分类获取专题列表
    public function getSubjectList(){
        $s_cate_id = I('post.s_cate_id');
        $page = I('post.page',1);
        $sql = "SELECT s.subject_id,s.image,s.`name`,s.user_nickname,s.user_nickname,s.user_image,s.text_content,s.collect_count";
        $sql .= " FROM axd_subject s";
        $sql .= " INNER JOIN __PREFIX__subject_cate sc ON sc.s_cate_id = s.s_cate_id";
        if(empty($s_cate_id)||''==$s_cate_id){
            $sql .= " ORDER BY s.collect_count DESC";
        }else{
            $sql .= " WHERE sc.s_cate_id ='$s_cate_id' ORDER BY s.collect_count,s.add_time DESC";
        }
        $sql .= " LIMIT ".(($page-1)*10).",10";

        $Model = new \Think\Model();
        $list = $Model->query($sql);
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['user_image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['user_image']);
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //获取美文详情
    public function getSubjectDetail(){
        $at = I('post.accesstoken');
        $subject_id = I('post.subject_id');
        if(!empty($at)){
            $user_id = getUserIdByAT($at);
            $is_col = M('SubjectCollect')->where("user_id='$user_id' AND subject_id='$subject_id'")->count();
        }
        $subject = M('Subject')
            ->field('subject_id,`name`,image_content,text_content,comment_count,collect_count,share_count')
            ->find($subject_id);
        if(empty($subject)){
            request_result('没有该美文信息',1);
        }else{
            $subject['goods_list'] = M('SubjectGoods')
                ->field('g.goods_id,g.name,g.image,g.tb_link,g.collect_count,g.price,sg.text_content')
                ->join('axd_goods g ON g.goods_id = sg.goods_id')
                ->alias('sg')
                ->where("subject_id='$subject_id'")-> select();
            $subject['image_content'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $subject['image_content']);
            foreach($subject['goods_list'] as $key=>$val){
                $subject['goods_list'][$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $subject['goods_list'][$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
            }
        }
        $is_col>0?$subject['is_col']=1:$subject['is_col']=0;
        request_result('', 0, $subject);
    }

    //美文评论
    public function subjectComment(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $subject_id = I('post.subject_id');
        $content = I('post.content');

        if(''==$subject_id||empty($subject_id)){
            request_result('美文id不能为空', 1);
        }
        if(''==$content||empty($content)){
            request_result('评论内容不能为空', 1);
        }
        $query = D('Subject')->comment_subject($user_id,$content,$subject_id);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取美文评论列表
    public function getSubjectComment(){
        $page = I('post.page',1);
        $subject_id = I('post.subject_id');
        $list = M('SubjectComment')
            ->field('sc.content,sc.time,u.nickname,u.image')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->where("sc.subject_id='$subject_id'")
            ->order('sc.time DESC')->page($page,10)->alias('sc')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
            request_result('', 0, $list);
        }
    }

    //收藏/取消收藏美文
    public function collectSubject(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);

        $subject_id = I('post.subject_id');
        $subject = M('Subject')->find($subject_id);
        if(empty($subject)){
            request_result('没有该美文信息', 1);
        }
        $type = I('post.type');
        $query = D('Subject')->subject_collect($subject_id,$user_id,$type);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取我的收藏-美文
    public function getSubjectCollect(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $page = I('post.page',1);

        $list = M('Subject')
            ->field('s.subject_id,s.image,s.`name`,s.user_nickname,s.user_nickname,s.user_image,s.text_content,s.collect_count')
            ->join('axd_subject_collect sc ON sc.subject_id = s.subject_id')
            ->where("user_id='$user_id'")->page($page,8)->order("time DESC")->alias('s')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
                $list[$key]['user_image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['user_image']);
            }
        }
        request_result('', 0, $list);
    }

    //分享美文
    public function shareSubject(){
        $id = I('id');
        $subject = M('Subject')
            ->field('subject_id,`name`,image_content,text_content,comment_count,collect_count,share_count')
            ->find($id);
        $subject['goods_list'] = M('SubjectGoods')
            ->field('g.goods_id,g.name,g.image,g.tb_link,g.comment_count,g.price')
            ->join('axd_goods g ON g.goods_id = sg.goods_id')
            ->alias('sg')->where("subject_id='$id'")-> select();
//        foreach($subject['goods_list'] as $key=>$val){
//            $subject['goods_list'][$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
//            $subject['goods_list'][$key]['tb_link'] = htmlspecialchars_decode($val['tb_link']);
//        }
        $this->assign('subject',$subject);
        $this->tc_yyb = C('TC_YYB');
        $this->display();
    }
}