<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class SubjectController extends AdminBaseController  {

    //文章分类列表
    public function subjectCate(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['name'] = array('like','%'.$keyword.'%');
        $this->list = M('SubjectCate')->where($where)->order('s_cate_id DESC')->select();
        $this->display();
    }

    //添加编辑文章分类
    public function addEditSubjectCate(){
        $id = I('id');
        $cate = M('SubjectCate')->find($id);
        if(IS_GET){
            $this->assign('cate',$cate);
            $this->display();
        }else{
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('分类名称'));
            if(empty($cate)){
                if(false!==M('SubjectCate')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('SubjectCate')->where("s_cate_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除文章分类
    public function delSCate(){
        $id = I('id');
        if(false!==M('SubjectCate')->delete($id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //文章列表
    public function subjectList(){
        session("goods_temp",null);//添加修改完成清除session->goods_temp
        session("subject_temp",null);//添加修改完成清除session->subject_temp
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['s.name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('Subject')
            ->field('s.*,sc.name AS cate_name')
            ->join('LEFT JOIN axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
            ->where($where)->alias('s')->order('subject_id DESC')->page($page,20)->select();
        //数据分页
        $count = M('Subject')
            ->join('axd_subject_cate sc ON sc.s_cate_id = s.s_cate_id')
            ->where($where)->alias('s')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //文章评论
    public function subjectComment(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['sc.content'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('SubjectComment')
            ->field('sc.*,u.nickname,u.image AS u_image,s.name AS subject_name')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->join('axd_subject s ON s.subject_id = sc.subject_id')
            ->where($where)->order('sc.time DESC')->alias('sc')->page($page,20)->select();
        //数据分页
        $count = M('SubjectComment')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->join('axd_subject s ON s.subject_id = sc.subject_id')
            ->alias('sc')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //导出文章评论表Excel
    public function exportSubjectComment(){
        $keyword = I('keyword','');
        $where['sc.content'] = array('like','%'.$keyword.'%');
        $data = M('SubjectComment')
            ->field('sc.s_comment_id,u.image,u.nickname,s.name,sc.content,sc.time')
            ->join('axd_user u ON u.user_id = sc.user_id')
            ->join('axd_subject s ON s.subject_id = sc.subject_id')
            ->where($where)->order('sc.time DESC')->alias('sc')->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['time'] = date("Y-m-d H:i:s", $val['time']);
        }
        $title_arr = array('ID','用户头像','用户昵称','文章名称','评论内容','评论时间');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,10,15,20,25,15),'文章评论列表'.date("Ymd", time()));
    }

    //删除美文评论
    public function delSubjectComment(){
        $id = I('id');
        if(false!==M('SubjectComment')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //添加编辑美文专题
    public function addEditSubject(){
        $id = I('id');
        $subject = M('Subject')->find($id);
        if(IS_GET){
            $this->subject_cate = M('SubjectCate')->select();
            if(empty($subject)){
                $subject = session('subject_temp');
            }
            $this->assign('subject',$subject);
            $this->goods_list = M('SubjectGoods')
                ->field('sg.sg_id,sg.text_content,g.goods_id,g.name,g.image')
                ->join('axd_goods g ON sg.goods_id = g.goods_id')
                ->alias('sg')
                ->where("sg.subject_id='$id'")->select();
            $this->display();
        }else{
            $param_arr = array(
                $data['s_cate_id'] = I('s_cate_id'),
                $data['name'] = I('name'),
                $data['text_content'] = I('text_content2'),
                $data['sex'] = I('sex'),
                $data['user_nickname'] = I('user_nickname'),
                $data['user_introduce'] = I('user_introduce'),
            );
            $data['comment_count'] = I('comment_count');
            $data['collect_count'] = I('collect_count');
            $data['share_count'] = I('share_count');
            $msg_arr = array('文章分类','文章名称','文章介绍','性别','发布者昵称','发布者介绍',);
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            //上传文章图片
            if($_FILES['form_image']!=''&&!empty($_FILES['form_image'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_image'],'subject');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    $data['image'] = $res['file_name'];
                }
            }else{
                $data['image'] = str_replace('/axd/',"/", I('image_2'));
            }
            //上传文章详情图片
            if($_FILES['form_image_content']!=''&&!empty($_FILES['form_image_content'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_image_content'],'subject');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    $data['image_content'] = $res['file_name'];
                }
            }else{
                $data['image_content'] = str_replace('/axd/',"/", I('image_content_2'));
            }
            //上传文章发布者头像
            if($_FILES['form_user_image']!=''&&!empty($_FILES['form_user_image'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_user_image'],'subject');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    $data['user_image'] = $res['file_name'];
                }
            }else{
                $data['user_image'] = str_replace('/axd/',"/", I('user_image_2'));
            }
            $model = new Model();
            $model->startTrans();
            if(empty($subject)){
                $this->empty_ajaxReturn(
                    array($data['image'],$data['image_content'],$data['user_image']),
                    array('文章图片','文章详情图片','发布者用户')
                );
                $data['add_time'] = time();
                $res1 = $model->table(C('DB_PREFIX').'subject')->add($data);
                if(false===$res1){
                    $model->rollback();
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                $res1 = $model->table(C('DB_PREFIX').'subject')->where("subject_id='$id'")->save($data);
                if(false===$res1){
                    $model->rollback();
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
            //编辑商品列表
            $goods_list = I('goods_lis');
            $text_content_list = I('text_content');
            if(empty($subject)){
                $goods_list_data = array();
                foreach($goods_list AS $key=>$val){
                    $obj['subject_id'] = $res1;
                    $obj['goods_id'] = $val;
                    $obj['text_content'] = $text_content_list[$key];
                    array_push($goods_list_data,$obj);
                }
                if(!empty($goods_list_data)){
                    $res2 = $model->table(C('DB_PREFIX').'subject_goods')->addAll($goods_list_data);
                    if(false===$res2){
                        $model->rollback();
                        $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                    }
                }
            }else{
                $res3 = $model->table(C('DB_PREFIX').'subject_goods')->where("subject_id='$id'")->delete();
                if(false===$res3){
                    $model->rollback();
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
                $goods_list_data = array();
                foreach($goods_list AS $key=>$val){
                    $obj['subject_id'] = $id;
                    $obj['goods_id'] = $val;
                    $obj['text_content'] = $text_content_list[$key];
                    array_push($goods_list_data,$obj);
                }
                if(!empty($goods_list_data)){
                    $res4 = $model->table(C('DB_PREFIX').'subject_goods')->addAll($goods_list_data);
                    if(false===$res4){
                        $model->rollback();
                        $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                    }
                }
            }
            session("goods_temp",null);//添加修改完成清除session->goods_temp
            $model->commit();
            $this->request_ajaxReturn('编辑成功', 0);
        }
    }

    //临时储存美文数据进session
    public function saveSubject2Session(){
        //上传文章图片
        if($_FILES['form_image']!=''&&!empty($_FILES['form_image'])){   //判断图片是否有上传
            $res = upload_file($_FILES['form_image'],'subject');
            if($res['errorCode']!=0){   //文件上传失败
                $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
            }else{          //文件上传成功
                $subject_temp['image'] = $res['file_name'];
            }
        }else{
            $subject_temp['image'] = str_replace('/axd/',"/", I('image_2'));
        }
        //上传文章详情图片
        if($_FILES['form_image_content']!=''&&!empty($_FILES['form_image_content'])){   //判断图片是否有上传
            $res = upload_file($_FILES['form_image_content'],'subject');
            if($res['errorCode']!=0){   //文件上传失败
                $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
            }else{          //文件上传成功
                $subject_temp['image_content'] = $res['file_name'];
            }
        }else{
            $subject_temp['image_content'] = str_replace('/axd/',"/", I('image_content_2'));
        }
        //上传文章发布者头像
        if($_FILES['form_user_image']!=''&&!empty($_FILES['form_user_image'])){   //判断图片是否有上传
            $res = upload_file($_FILES['form_user_image'],'subject');
            if($res['errorCode']!=0){   //文件上传失败
                $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
            }else{          //文件上传成功
                $subject_temp['user_image'] = $res['file_name'];
            }
        }else{
            $subject_temp['user_image'] = str_replace('/axd/',"/", I('user_image_2'));
        }
        $subject_temp['s_cate_id'] = I('s_cate_id');
        $subject_temp['name'] = I('name');
        $subject_temp['text_content'] = I('text_content');
        $subject_temp['sex'] = I('sex');
        $subject_temp['user_nickname'] = I('user_nickname');
        $subject_temp['user_introduce'] = I('user_introduce');
        $subject_temp['comment_count'] = I('comment_count');
        $subject_temp['collect_count'] = I('collect_count');
        $subject_temp['share_count'] = I('share_count');
        session('subject_temp',$subject_temp);
        $this->request_ajaxReturn('SUCCESS', 0);
    }

    //编辑文章商品列表
    public function editSubjectGoods(){
        if(IS_GET){
            $subject_id = I('id');
            $this->assign('sid',$subject_id);
            $this->subject = M('Subject')->find($subject_id);
            $this->goods_list = M('SubjectGoods')
                ->field('sg.sg_id,g.goods_id,g.name,g.image')
                ->join('axd_goods g ON sg.goods_id = g.goods_id')
                ->alias('sg')
                ->where("sg.subject_id='$subject_id'")->select();
            $this->display();
        }else{
            $goods_id = I('gid');
            $subject_id = I('sid');
            $data['goods_id'] = $goods_id;
            $data['subject_id'] = $subject_id;
            $goods = M('Goods')->field('goods_id,image,name')->find($goods_id);
            if(empty($goods)){
                $this->request_ajaxReturn('必须选择商品才能添加' , 1);
            }else{
                $is_exist = M('SubjectGoods')->where($data)->find();
                if($is_exist){
                    $this->request_ajaxReturn('商品已存在于文章中,不能重复添加' , 1);
                }
                $res = M('SubjectGoods')->add($data);
                if(false!==$res){
                    $goods['sg_id'] = $res;
                    $this->request_ajaxReturn('添加成功' , 0, $goods);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试' , 1);
                }
            }

        }
    }

    //删除专题商品
    public function delSubjectGoods(){
        $sg_id = I('sg_id');
        if(false!==M('SubjectGoods')->delete($sg_id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //删除文章
    public function delSubject(){
        $id = I('id');
        $subject = M('Subject')->find($id);
        if(false!==M('Subject')->delete($id)){
            unlink('.'.$subject['image']);
            unlink('.'.$subject['user_image']);
            unlink('.'.$subject['image_content']);
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //添加美文商品页面
    public function addSubjectGoodsPage(){
        $gc = M('GoodsCate');
        if(IS_GET){
            $second_list = $gc->where("parent_id='1'")->select();
            $this->assign('second_list',$second_list);
            $second_fid = $second_list[0]['g_cate_id'];
            $this->third_list = $gc->where("parent_id='$second_fid'")->select();
            $this->display();
        }else{
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'goods');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败,'.$res['msg'],1);
                }else{          //文件上传成功
                    $data['image'] = $res['file_name'];
                }
            }
            $param_arr = array(
                $data['name'] = I('name'),
                $data['g_cate_id'] = I('g_cate_id'),
                $data['sex'] = I('sex'),
                $data['price'] = I('price'),
                $data['tb_link'] = I('tb_link'),
                $data['end_time'] = strtotime(I('end_time')),
                $data['text_content'] = I('text_content'),
                $data['image'],
            );
            $data['comment_count'] = I('comment_count',0);
            $data['collect_count'] = I('collect_count',0);
            $msg_arr = array('商品名称','商品类别','所属分类','价格','淘宝链接','结束时间','文本介绍','商品图片');
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            $data['add_time'] = time();
            $res = M('Goods')->add($data);
            if(false!==$res){
                //添加美文商品到session中
                $data['goods_id'] = $res;
                $goods_temp = session('goods_temp');
                if(empty($goods_temp)){
                    $goods_temp = array();
                }
                array_push($goods_temp,$data);
                session('goods_temp', $goods_temp);
                $this->request_ajaxReturn('添加成功', 0);
            }else{
                $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
            }
        }
    }
}