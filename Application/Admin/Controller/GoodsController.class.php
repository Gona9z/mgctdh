<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends AdminBaseController  {

    //商品列表
    public function goodsList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $keyword = str_replace("%","\\%",$keyword);
        $where['g.name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        //商品列表
        $this->list = M('Goods')
            ->field('g.*,gc.name AS cate_name')
            ->join('axd_goods_cate gc ON g.g_cate_id = gc.g_cate_id')
            ->alias('g')->order('add_time DESC')
            ->where($where)->page($page,20)->select();
        //数据分页
        $count = M('Goods')
            ->join('axd_goods_cate gc ON g.g_cate_id = gc.g_cate_id')
            ->alias('g')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //添加编辑商品
    public function addEditGoods(){
        $id = I('id');
        $goods = M('Goods')->find($id);
        $gc = M('GoodsCate');
        if(IS_GET){
            if(empty($goods)){
                $second_list = $gc->where("parent_id='1'")->select();
                $this->assign('second_list',$second_list);
                $second_fid = $second_list[0]['g_cate_id'];
                $this->third_list = $gc->where("parent_id='$second_fid'")->select();
            }else{
                $sex_id = $goods['sex'];//所属分类 -- 男神/女神
                $this->second_list = $gc->where("parent_id='$sex_id'")->select();   //获取男神/女神下的二级分类列表
                $third_cate = $gc->where("g_cate_id='$goods[g_cate_id]'")->find();//获取三级分类对象
                $this->assign('third_cate',$third_cate);
                $second_cate = $gc->where("g_cate_id='$third_cate[parent_id]'")->find();
                $this->assign('second_cate',$second_cate);
                $iid = $second_cate['g_cate_id'];
                $this->third_list = $gc->where("parent_id='$iid'")->select();
            }
            $this->assign('goods',$goods);
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
            );
            $data['comment_count'] = I('comment_count',0);
            $data['collect_count'] = I('collect_count',0);
            $msg_arr = array('商品名称','商品类别','所属分类','价格','淘宝链接','结束时间','文本介绍',);
            $this->empty_ajaxReturn($param_arr,$msg_arr);
            if(empty($goods)){
                $this->empty_ajaxReturn(array($data['image']),array('商品图片'));
                $data['add_time'] = time();
                if(false!==M('Goods')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('Goods')->where("goods_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //商品分类列表
    public function goodsCate(){
//        $keyword = I('keyword','');
//        $this->assign('keyword',$keyword);
//        $where['name'] = array('like','%'.$keyword.'%');
        $sex = I('sex');
        $this->assign('sex',$sex);
        global $goods_category, $goods_category2;
        $goods_category = M('GoodsCate')->where()->order('parent_id ASC')->select();
        $goods_category = convert_arr_key($goods_category, 'g_cate_id');
        foreach ($goods_category AS $key => $value){
            if($value['level'] == 1){
                $this->get_cat_tree($value['g_cate_id']);
            }
        }
        $this->assign("list",$goods_category2);
        $this->display();
    }

    /**
     * 获取指定id下的 所有分类
     * @global type $goods_category 所有商品分类
     * @param type $id 当前显示的 菜单id
     * @return 返回数组 Description
     */
    public function get_cat_tree($id){
        global $goods_category, $goods_category2;
        $goods_category2[$id] = $goods_category[$id];
        foreach ($goods_category AS $key => $value){
            if($value['parent_id'] == $id){
                $this->get_cat_tree($value['g_cate_id']);
                $goods_category2[$id]['have_son'] = 1; // 还有下级
            }
        }
    }

    //添加编辑商品分类
    public function addEditGCate(){
        $id = I('id');
        $cate = M('GoodsCate')->find($id);
        if(IS_GET){
            $this->assign('cate',$cate);
            if($cate['level']==3){
                //获取编辑分类的二级分类组
                $p_cate = M('GoodsCate')->find($cate['parent_id']);
                $p_cate_id = $p_cate['parent_id'];
                $this->assign('pc_id',$p_cate_id);
                $this->second_cate = M('GoodsCate')->where("parent_id='$p_cate_id'")->select();
            }else{
                //新增分类数据，默认进入男神二级分类
                $this->second_cate = M('GoodsCate')->where("parent_id=1")->select();
            }
            $this->display();
        }else{
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'goods_cate');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败,'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($cate)){       //编辑---删除原图片
                        unlink('.'.$cate['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            if(I('level')=='2'){
                $data['level'] = I('level');
                $data['parent_id'] = I('first_cate_id');
            }else{
                $data['level'] = I('level');
                $data['parent_id'] = I('second_cate_id');
            }
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('分类名称'));
            if(empty($cate)){
                if(I('level')=='3'){
                    $this->empty_ajaxReturn(array($data['image']),array('商品图片'));
                }
                $data['sys_value'] = 0;
                if(false!==M('GoodsCate')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败,请刷新后重试', 1);
                }
            }else{
                if(false!==M('GoodsCate')->where("g_cate_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //删除商品
    public function delGoods(){
        $id = I('id');
        if(M('Goods')->delete($id)){
            $this->ajaxReturn(array('msg'=>'删除成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败,请刷新后重试','errorCode'=>1));
        }
    }

    //获取商品分类
    public function getGoodsCate(){
        $cate_id = I('cid',1);
        $cate_list = M('GoodsCate')->where("parent_id='$cate_id'")->select();
        $this->ajaxReturn(array('cate_list'=>$cate_list));
    }

    //删除商品分类
    public function delGCate(){
        $g_cate_id = I('id');
        if(false!==M('GoodsCate')->delete($g_cate_id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //根据分类获取商品
    public function getGoodsByCate(){
        $where['g_cate_id'] = I('gc_id');
        $list = M('Goods')
            ->field('comment_count,praise_count,collect_count,end_time,add_time',true)
            ->where($where)->select();
        $this->ajaxReturn(array('g_list'=>$list));
    }

    //商品评论列表
    public function goodsComment(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['gc.content'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('GoodsComment')
            ->field('gc.*,u.nickname,u.image AS u_image,g.name AS goods_name')
            ->join('axd_user u ON u.user_id = gc.user_id')
            ->join('axd_goods g ON g.goods_id = gc.good_id')
            ->where($where)->order('gc.time DESC')->alias('gc')->page($page,20)->select();
        //数据分页
        $count = M('GoodsComment')
            ->join('axd_user u ON u.user_id = gc.user_id')
            ->join('axd_goods g ON g.goods_id = gc.good_id')
            ->where($where)->order('gc.time DESC')->alias('gc')->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //导出商品表Excel
    public function exportExcelGoods(){
        $keyword = I('get.keyword','');
        $where['g.name'] = array('like','%'.$keyword.'%');
        $data = M('Goods')
            ->field('g.goods_id,g.name,g.image,gc.name AS cate_name,g.goods_no,g.price,g.collect_count,g.share_count,g.end_time')
            ->join('axd_goods_cate gc ON g.g_cate_id = gc.g_cate_id')
            ->alias('g')->where($where)->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['end_time'] = date("Y-m-d", $val['end_time']);
        }
        $title_arr = array('ID','商品名称','商品图片','类别','商品编号','淘宝价格','收藏数','分享数','到有效期','状态');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,60,50,10,15,10,10,10,15,10),'商品列表'.date("Ymd", time()));
    }

    //导出商品评论表Excel
    public function exportGoodsComment(){
        $keyword = I('keyword','');
        $where['gc.content'] = array('like','%'.$keyword.'%');
        $data = M('GoodsComment')
            ->field('gc.g_comment_id,u.image,u.nickname,g.name,gc.content,gc.time')
            ->join('axd_user u ON u.user_id = gc.user_id')
            ->join('axd_goods g ON g.goods_id = gc.good_id')
            ->where($where)->order('gc.time DESC')->alias('gc')->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['time'] = date("Y-m-d H:i:s", $val['time']);
        }
        $title_arr = array('ID','用户头像','用户昵称','评论商品','评论内容','评论时间');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,10,15,20,25,15),'商品评论列表'.date("Ymd", time()));
    }

    //删除商品评论
    public function delGoodsComment(){
        $id = I('id');
        if(false!==M('GoodsComment')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //获取商品信息
    public function getGoods(){
        $id = I('id');
        $goods = M('Goods')->Field('goods_id,name')->find($id);
        $this->request_ajaxReturn('', 0, $goods);
    }

    //淘宝订单列表
    public function tbOrder(){
        $this->school_id = I('school_id');
        $keyword = I('get.keyword','');
        $mg_keyword = '%'.$keyword.'%';
//        $where['u.nickname'] = array('like','%'.$keyword.'%');
//        $where['_logic'] = 'OR';
//        $where['tor.order'] = array('like','%'.$keyword.'%');
//        $where['u.school_id'] = I('school_id');
        $school_id = I('school_id',0);
        if('0'==$school_id){
            $where['_string'] = 'u.nickname LIKE "'.$mg_keyword.'" OR tor.order LIKE "'.$mg_keyword.'"';
        }else{
            $where['_string'] = '(u.nickname LIKE "'.$mg_keyword.'" OR tor.order LIKE "'.$mg_keyword.'") AND u.school_id='.$school_id;
        }
        $this->assign('keyword',$keyword);

        $page = I('p',1);
        $this->school_list = M('School')->select();
        $this->list = M('TbOrder')
            ->field('tor.nickname,u.image,g.name,g.image,g.price,g.tb_link,tor.add_time,tor.order,tor.is_deal')
            ->join('LEFT JOIN axd_user u ON u.user_id = tor.user_id')
            ->join('axd_goods g ON g.goods_id = tor.goods_id')
            ->alias('tor')->order('add_time DESC')->where($where)->page($page,20)->select();;
        //数据分页
        $count = M('TbOrder')
            ->join('axd_user u ON u.user_id = tor.user_id')
            ->join('axd_goods g ON g.goods_id = tor.goods_id')
            ->alias('tor')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //导出淘宝订单Excel
    public function exportTbOrder(){
        $this->school_id = I('school_id');
        $keyword = I('get.keyword','');
        $mg_keyword = '%'.$keyword.'%';
        $school_id = I('school_id',0);
        if('0'==$school_id){
            $where['_string'] = 'u.nickname LIKE "'.$mg_keyword.'" OR tor.order LIKE "'.$mg_keyword.'"';
        }else{
            $where['_string'] = '(u.nickname LIKE "'.$mg_keyword.'" OR tor.order LIKE "'.$mg_keyword.'") AND u.school_id='.$school_id;
        }
        $data = M('TbOrder')
            ->field('tor.id,tor.nickname,g.name,g.image,g.price,tor.order,tor.add_time,tor.is_deal')
            ->join('axd_goods g ON g.goods_id = tor.goods_id')
            ->alias('tor')->where($where)->select();;

        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['add_time'] = date("Y-m-d H:i:s", $val['add_time']);
            $data[$key]['is_deal'] = $val['is_deal']==0?'订单已提交':'已提交拿快递';
        }
        $title_arr = array('ID','用户昵称','商品名称','商品图片','价格','订单号','支付时间','状态');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,10,15,20,10,20,15,15),'淘宝订单列表'.date("Ymd", time()));
    }
}