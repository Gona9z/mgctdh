<?php
namespace Admin\Controller;
use Think\Controller;
class InteractController extends AdminBaseController  {

    //帖子分类列表
    public function interactCate(){
        $this->list = M('SchoolCate')->order('s_cate_id DESC')->select();
        $this->display();
    }

    //删除帖子分类
    public function delICate(){
        $id = I('id');
        if(false!==M('SchoolCate')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //帖子列表
    public function interactList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['title'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('Interact')
            ->field('i.*,sc.name AS cate_name')
            ->join('LEFT JOIN axd_school_cate sc ON i.s_cate_id = sc.s_cate_id')
            ->alias('i')->where($where)->order('i.time DESC')->page($page,20)->select();
        //数据分页
        $count = M('Interact')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //添加编辑帖子
    public function addEditInteract(){
        $id = I('id');
        $interact = M('Interact')->find($id);
        if(IS_GET){
            $interact['content'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $interact['content']);
            $this->cate_list = M('SchoolCate')->select();
            $this->school_list = M('School')->select();
            $this->assign('interact', $interact);
            $this->initEditor();
            $this->display();
        }else{
            $param_arr = array(
                $data['s_cate_id'] = I('s_cate_id'),
                $data['title'] = I('title'),
                $data['user_nickname'] = I('user_nickname'),
                $data['time'] = strtotime(I('time')),
                $data['content'] = I('content'),
                $data['content_s'] = substr(strip_tags(htmlspecialchars_decode(I('content'))), 0, 150).'......',
                $data['share_count'] = I('share_count'),
                $data['comment_count'] = I('comment_count'),
                $data['praise_count'] = I('praise_count'),
                $data['school_id'] = I('school_id'),
                $data['is_video'] = I('is_video'),
            );
            $msg_arr = array('校趣分类','标题','作者','时间','内容','内容','分享数','评论数','收藏数','学校Id','是否视频');
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            $data['content'] = str_replace(C('WEB_URL')."/Public/uploads/", '/Public/uploads/', $data['content']);
            //上传文章图片
            if($_FILES['form_image']!=''&&!empty($_FILES['form_image'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_image'],'interact');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($interact)){       //编辑---删除原图片
                        unlink('.'.$interact['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }

            if(empty($interact)){
                $this->empty_ajaxReturn(array($data['image']),array('图片'));
                $data['add_time'] = time();
                if(false!==M('Interact')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Interact')->where("interact_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除帖子
    public function delInteract(){
        $id = I('id');
        $interact = M('Interact')->find($id);
        if(false!==M('Interact')->delete($id)){
            unlink('.'.$interact['image']);
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //删除帖子评论
    public function delInteractComment(){
        $id = I('id');
        if(false!==M('InteractComment')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //添加编辑School分类
    public function addEditICate(){
        $id = I('id');
        $cate = M('SchoolCate')->find($id);
        if(IS_GET){
            $this->assign('cate',$cate);
            $this->display();
        }else{
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('分类名称'));
            if(empty($cate)){
                if(false!==M('SchoolCate')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('SchoolCate')->where("s_cate_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //帖子评论列表
    public function interactComment(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['ic.content'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('InteractComment')
            ->field('ic.*,u.nickname,u.image AS u_image,i.title')
            ->join('axd_user u ON u.user_id = ic.user_id')
            ->join('axd_interact i ON i.interact_id = ic.interact_id')
            ->where($where)->order('ic.time DESC')->alias('ic')->page($page,20)->select();
        //数据分页
        $count = M('InteractComment')
            ->join('axd_user u ON u.user_id = ic.user_id')
            ->join('axd_interact i ON i.interact_id = ic.interact_id')
            ->where($where)->order('ic.time DESC')->alias('ic')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //导出帖子表Excel
    public function exportExcelInteract(){
        $keyword = I('get.keyword','');
        $where_str = ' WHERE u.nickname LIKE "%'.$keyword.'%" OR i.content LIKE "%'.$keyword.'%"';
        $order_str = ' ORDER BY i.time DESC';
        $sql = 'SELECT i.interact_id,u.nickname,sc.name,i.content,i.share_count,i.praise_count,(';
        $sql .= ' SELECT GROUP_CONCAT(ii.image SEPARATOR ",")';
        $sql .= ' FROM __PREFIX__interact_image ii WHERE ii.interact_id = i.interact_id';
        $sql .= ' ) AS image FROM axd_interact i';
        $sql .= ' JOIN __PREFIX__user u ON u.user_id = i.user_id ';
        $sql .= ' JOIN __PREFIX__school_cate sc ON sc.s_cate_id = i.s_cate_id';
        $sql .= $where_str;
        $sql .= $order_str;
        $Model = new \Think\Model();
        $data = $Model->query($sql);
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
        }
        $title_arr = array('ID','发帖人','分类','发帖内容','分享数','点赞数','图片');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,15,15,40,10,10,200),'帖子列表'.date("Ymd", time()));
    }

    //导出帖子评论表Excel
    public function exportExcelIComment(){
        $keyword = I('keyword','');
        $where['ic.content'] = array('like','%'.$keyword.'%');
        $data = M('InteractComment')
                ->field('ic.i_comment_id,u.image,u.nickname,i.content AS i_content,ic.content,ic.time')
                ->join('axd_user u ON u.user_id = ic.user_id')
                ->join('axd_interact i ON i.interact_id = ic.interact_id')
                ->where($where)->order('ic.time DESC')->alias('ic')->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['time'] = date("Y-m-d H:i:s", $val['time']);
        }
        $title_arr = array('ID','用户头像','用户昵称','评论帖子','评论内容','评论时间');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,10,15,20,25,15),'帖子评论列表'.date("Ymd", time()));
    }
}