<?php
namespace Api\Controller;
use Think\Controller;
class SchoolController extends ApiBaseController  {

    /**
     * School-获取互动分类
     */
    public function getSchoolCate(){
        $list = M('SchoolCate')->select();
        request_result('', 0, $list);
    }

    /**
     * 获取帖子列表
     * @param $page 页码
     * @param $type 类型 0:视频 1:最热 2:学校 3:其他分类
     * @param $type_id 分类id/学校id
     */
    public function getInteractList(){
        $at = I('post.accesstoken');
        $page = I('post.page',1);
        $type = I('post.type',0);
        $type_id = I('post.type_id');
        if('3'==$type){
//            dump(3);
            $where['i.s_cate_id'] = $type_id;
            $order_str = 'time DESC';
        }elseif('2'==$type){
            $user = getUserInfoByAT($at);
            $where['i.school_id'] = $user['school_id'];
            $order_str = 'time DESC';
        }elseif('1'==$type){
            $order_str = 'praise_count DESC';
        }else{
            $where['is_video'] = 1;
            $order_str = 'time DESC';
        }
        $list = M('Interact')
            ->field('i.interact_id,i.content_s,i.time,i.user_nickname,i.image,sc.name AS cate_name,i.comment_count,i.praise_count')
            ->join('LEFT JOIN axd_school_cate sc ON sc.s_cate_id = i.s_cate_id')
            ->where($where)->order($order_str)->alias('i')->page($page,10)->select();
//        dump($list);
        foreach($list as $key=>$val){
            $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            if(!empty($at)){
                $user = getUserInfoByAT($at);
                //查询是否点赞
                $where_p['interact_id'] = $val['interact_id'];
                $where_p['user_id'] = $user['user_id'];
                $is_col = M('InteractPraise')->where($where_p)->find();
                $list[$key]['is_praise'] = empty($is_col)?0:1;
            }else{
                $list[$key]['is_praise'] = 0;
            }
        }
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }
        request_result('', 0, $list);
    }

    //获取帖子详情
    public function interactDetail(){
        $at = I('post.accesstoken');
        $interact = M('Interact')
            ->field('interact_id,title,content,user_nickname,
                share_count,comment_count,praise_count,time')
            ->find(I('interact_id'));
        if(!empty($at)){
            $user_id = getUserIdByAT($at);
            $where['user_id'] = $user_id;
        }
        if(empty($interact)){
            request_result('没有该条信息', 1);
        }else{
            $interact['is_praise'] = 0;
            $interact['content'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $interact['content']);
            $interact['content'] = htmlspecialchars_decode($interact['content']);
            if(!empty($at)){
                $where['interact_id'] = $interact['interact_id'];
                $record = M('InteractPraise')->where($where)->find();
                if(!empty($record)){
                    $interact['is_praise'] = 1;
                }
            }
            request_result('', 0, $interact);
        }
    }

    //帖子点赞/取消点赞
    public function praiseInteract(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $interact_id = I('post.interact_id');
        $type = I('post.type',0);

        $param[] = array('key'=>'interact_id','msg'=>'帖子id','is_str'=>1);
        param_validate($param);//非空判断

        $query = D('Interact')->interact_praise($interact_id,$user_id,$type);
        request_result($query['msg'],$query['errorCode']);
    }

    //获取帖子评论列表
    public function getInteractComment(){
        $page = I('post.page',1);
        $interact_id = I('post.interact_id');
        $list = M('InteractComment')
            ->field('ic.content,ic.time,u.nickname,u.image')
            ->join('axd_user u ON u.user_id = ic.user_id')
            ->where("ic.interact_id='$interact_id'")
            ->page($page,10)->order('time DESC')->alias('ic')->select();
        if(empty($list)){
            request_result('已加载完所有数据', 1);
        }else{
            foreach($list as $key=>$val){
                $list[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            }
        }
        request_result('', 0, $list);
    }

    //评论帖子
    public function interactComment(){
        $at = I('post.accesstoken');
        $user_id = getUserIdByAT($at);
        $interact_id = I('post.interact_id');
        $content = I('post.content');

        $param[] = array('key'=>'interact_id','msg'=>'帖子id','is_str'=>1);
        $param[] = array('key'=>'content','msg'=>'评论内容','is_str'=>1);
        param_validate($param);//非空判断

        $query = D('Interact')->comment_interact($user_id,$content,$interact_id);
        request_result($query['msg'],$query['errorCode']);
    }

    //校趣分享页面
    public function shareInteract(){
        $id = I('id');
        $interact = M('Interact')->where("interact_id='$id'")->find();
        $this->interact = $interact;
        $content = $interact['content'];
        $content = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $content);
        $this->content = htmlspecialchars_decode($content);
        $this->tc_yyb = C('TC_YYB');
        $this->display();
    }

}