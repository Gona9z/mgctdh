<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class CollocationController extends AdminBaseController  {

    //搭配分类列表
    public function collocationCate(){
        $this->list = M('CollocationCate')->order('order_n')->select();
        $this->display();
    }

    //添加编辑搭配分类
    public function addEditCCate(){
        $id = I('id');
        $cate = M('CollocationCate')->find($id);
        if(IS_GET){
            $this->assign('cate',$cate);
            $this->display();
        }else{
                $this->empty_ajaxReturn(array($data['name']=I('name')),array('分类名称'));
//            if(empty($cate)){
//                if(false!==M('CollocationCate')->add($data)){
//                    $this->request_ajaxReturn('添加成功', 0);
//                }else{
//                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
//                }
//            }else{

                $param_arr = array(
                    $data['name'] = I('name'),
                    $data['order_n'] = I('order_n'),
                );
                $msg_arr = array('分类名称','排序',);
                $this->empty_ajaxReturn($param_arr,$msg_arr);

                //上传搭配分类图片
                if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                    $res = upload_file($_FILES['form_file'],'collocation_cate');
                    if($res['errorCode']!=0){   //文件上传失败
                        $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                    }else{          //文件上传成功
                        if(!empty($cate)){       //编辑---删除原图片
                            unlink('.'.$cate['image']);
                        }
                        $data['image'] = $res['file_name'];
                    }
                }

                if(empty($cate)){
                    $this->empty_ajaxReturn(array($data['image']),array('分类图片'));
                    if(false!==M('CollocationCate')->add($data)){
                        $this->request_ajaxReturn('添加成功', 0);
                    }else{
                        $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                    }
                }else{
                    if(false!==M('CollocationCate')->where("c_cate_id='$id'")->save($data)){
                        $this->request_ajaxReturn('编辑成功', 0);
                    }else{
                        $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                    }
                }
//            }
        }
    }

    //删除搭配分类
    public function delCCate(){
        $id = I('id');
        $cate = M('CollocationCate')->find($id);
        if(false!==M('CollocationCate')->delete($id)){
            unlink('.'.$cate['image']);
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //搭配列表
    public function collocationList(){
        session("goods_c_temp",null);
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['c.title'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('Collocation')
            ->field('c.*,cc.name AS cate_name')
            ->join('LEFT JOIN axd_collocation_cate cc ON cc.c_cate_id = c.c_cate_id')
            ->where($where)->alias('c')->page($page,20)->select();
        //数据分页
        $count = M('Collocation')
            ->join('LEFT JOIN axd_collocation_cate cc ON cc.c_cate_id = c.c_cate_id')
            ->where($where)->alias('c')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //添加编辑搭配
    public function addEditCollocation(){
        $id = I('id');
        $collocation = M('Collocation')->find($id);
        $label_text = M('CollocationLabel')->where("collocation_id='$id'")->getField('label_text',true);
        if(IS_GET){
            //搭配分类
            $this->collocation_cate = M('CollocationCate')->select();
            //搭配-标签
            $collocation['label_text'] = implode('&#13;&#10;', $label_text);
            //搭配-图片商品列表
//            $this->assign('node_list',$node_list);

            $this->assign('collocation',$collocation);
            $this->display();
        }else{
            $model = new Model();
            $model->startTrans();
            $flag=false;

            //上传图片
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'collocation');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($collocation)){       //编辑---删除原图片
                        unlink('.'.$collocation['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            $param_arr = array(
                $data['c_cate_id'] = I('c_cate_id'),
                $data['title'] = I('title'),
                $data['introduce'] = I('introduce'),
                $data['introduce_s'] = substr(I('introduce'), 0, 100).'......',
            );
            $data['last_edit_time'] = time();
            $msg_arr = array('搭配分类','搭配名称','搭配介绍','搭配介绍',);
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            //修改规格-项
            $label_list = preg_split('/\s+/', I('post.label_text_arr'));
            if(!empty(array_diff($label_list,$label_text))||empty($label_text)){
                $res1 = $model->table(C('DB_PREFIX').'collocation_label')->where("collocation_id='$id'")->delete();
                foreach($label_list as $key=>$val){
                    $data2[$key]['collocation_id'] = $id;
                    $data2[$key]['label_text'] = $val;
                }
                $res2 = $model->table(C('DB_PREFIX').'collocation_label')->addAll($data2);
            }


            if(empty($collocation)){
                $this->empty_ajaxReturn(array($data['image']),array('搭配图片'));
                $data['add_time'] = time();
                if(false!==M('Collocation')->add($data)){
                    $model->commit();
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $model->rollback();
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Collocation')->where("collocation_id='$id'")->save($data)){
                    $model->commit();
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $model->rollback();
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //编辑搭配商品
    public function addEditCGoods(){
        $id = I('id');
        if(IS_GET){
            $this->collocation = M('Collocation')->find($id);
            $where['collocation_id'] = $id;
            $node_list = M('CollocationNode')
                ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text,g.name')
                ->join('axd_goods g ON g.goods_id = cn.goods_id')
                ->where("collocation_id='$id'")->alias('cn')->select();
            foreach($node_list AS $key=>$val){
                $node_list[$key]['index_x'] = $val['index_x']*240;
                $node_list[$key]['index_y'] = $val['index_y']*288;
            }
            $this->assign('node_list', $node_list);
            $this->display();
        }else{
            M('CollocationNode')->where("collocation_id='$id'")->delete();
            //添加图片坐标
            $index_x = I('index_x');
            $index_y = I('index_y');
            $goods_text = I('goods_text');
            $goods_id = I('goods_id');
            for ($i=0; $i<count($index_x); $i++) {
                $node_data[$i]['collocation_id'] = $id;
                $node_data[$i]['goods_id'] = $goods_id[$i];
                $node_data[$i]['index_x'] = $index_x[$i]/240;
                $node_data[$i]['index_y'] = $index_y[$i]/288;
                $node_data[$i]['goods_text'] = $goods_text[$i];
            }
            if(false!==M('CollocationNode')->addAll($node_data)){
                $this->request_ajaxReturn('编辑成功', 0);
            }else{
                $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
            }
        }
    }

    //新-编辑搭配商品
    public function addEditCGoods2(){
        $id = I('id');
        if(IS_GET){
            $this->collocation = M('Collocation')->find($id);
            $where['collocation_id'] = $id;
            $node_list = M('CollocationNode')
                ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text,g.name')
                ->join('axd_goods g ON g.goods_id = cn.goods_id')
                ->where("collocation_id='$id'")->alias('cn')->select();
            foreach($node_list AS $key=>$val){
                $node_list[$key]['index_x'] = $val['index_x']*240;
                $node_list[$key]['index_y'] = $val['index_y']*288;
            }
            if(!empty(session('goods_c_temp'))){
                $node_list = array_merge($node_list,session('goods_c_temp'));
            }
            $this->assign('node_list', $node_list);
            $this->display();
        }else{
            M('CollocationNode')->where("collocation_id='$id'")->delete();
            //添加图片坐标
            $index_x = I('index_x');
            $index_y = I('index_y');
            $goods_text = I('goods_text');
            $goods_id = I('goods_id');
            for ($i=0; $i<count($index_x); $i++) {
                $node_data[$i]['collocation_id'] = $id;
                $node_data[$i]['goods_id'] = $goods_id[$i];
                $node_data[$i]['index_x'] = $index_x[$i]/240;
                $node_data[$i]['index_y'] = $index_y[$i]/288;
                $node_data[$i]['goods_text'] = $goods_text[$i];
                $this->empty_ajaxReturn(array($goods_text[$i]),array('文本内容'));
            }
            if(false!==M('CollocationNode')->addAll($node_data)){
                session("goods_c_temp",null);//添加修改完成清除session->goods_c_temp
                $this->request_ajaxReturn('编辑成功', 0);
            }else{
                $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
            }
        }
    }

    //获取临时商品数据
    public function sessionTempG(){
        $list = session('goods_c_temp');
        $this->request_ajaxReturn('', 0, $list);
    }

    //添加搭配商品
    public function addCollocationGoodsPage(){
        $gc = M('GoodsCate');
        if(IS_GET){
            $this->index_x = I('index_x');
            $this->index_y = I('index_y');
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
                $data['index_x'] = I('index_x');
                $data['index_y'] = I('index_y');
                $goods_c_temp = session('goods_c_temp');
                if(empty($goods_c_temp)){
                    $goods_c_temp = array();
                }
                array_push($goods_c_temp,$data);
                session('goods_c_temp', $goods_c_temp);
                $this->request_ajaxReturn('添加成功', 0);
            }else{
                $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
            }
        }
    }

    //删除搭配
    public function delCollocation(){
        $id = I('id');
        $collocation = M('Collocation')->find($id);
        if(false!==M('Collocation')->delete($id)){
            unlink('.'.$collocation['image']);
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //获取商品节点
    public function getCGoodsNode(){
        $id = I('id');
        $node_list = M('CollocationNode')
            ->field('cn.goods_id,cn.index_x,cn.index_y,cn.goods_text,g.name')
            ->join('axd_goods g ON g.goods_id = cn.goods_id')
            ->where("collocation_id='$id'")->alias('cn')->select();
        $this->request_ajaxReturn('', 0, $node_list);
    }

    //导出文章评论表Excel
    public function exportCollocationComment(){
        $keyword = I('keyword','');
        $where['cc.content'] = array('like','%'.$keyword.'%');
        $data = M('CollocationComment')
            ->field('cc.c_comment_id,u.image,u.nickname,c.title,cc.content,cc.time')
            ->join('axd_user u ON u.user_id = cc.user_id')
            ->join('axd_collocation c ON c.collocation_id = cc.collocation_id')
            ->where($where)->order('cc.time DESC')->alias('cc')->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['time'] = date("Y-m-d H:i:s", $val['time']);
        }
        $title_arr = array('ID','用户头像','用户昵称','搭配名称','评论内容','评论时间');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,10,15,20,25,15),'搭配评论列表'.date("Ymd", time()));
    }

    //搭配评论列表
    public function collocationComment(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['cc.content'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('CollocationComment')
            ->field('cc.*,u.nickname,u.image AS u_image,c.title')
            ->join('axd_user u ON u.user_id = cc.user_id')
            ->join('axd_collocation c ON c.collocation_id = cc.collocation_id')
            ->where($where)->order('cc.time DESC')->alias('cc')->page($page,20)->select();
        //数据分页
        $count = M('CollocationComment')
            ->join('axd_user u ON u.user_id = cc.user_id')
            ->join('axd_collocation c ON c.collocation_id = cc.collocation_id')
            ->where($where)->order('cc.time DESC')->alias('cc')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //删除搭配评论
    public function delCollocationComment(){
        $id = I('id');
        if(false!==M('CollocationComment')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }
}