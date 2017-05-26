<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends AdminBaseController  {
    public function index(){
    }

    //app用户列表
    public function userList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $keyword = str_replace("%","\\%",$keyword);
        $where['phone'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['nickname'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        //app用户列表
        $this->list = M('User')
            ->field('u.*,s.name AS school_name')
            ->join('LEFT JOIN axd_school s ON s.school_id = u.school_id')
            ->where($where)
            ->alias('u')->order('reg_time DESC')->page($page,20)->select();
        //数据分页
        $count = M('User')->join('LEFT JOIN axd_school s ON s.school_id = u.school_id')
            ->alias('u')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //编辑用户
    public function editUser(){
        $id = I('id');
        $user = M('User')->field('password,accesstoken,open_id',ture)->find($id);
        if(IS_GET){
            $this->school_list = M('School')->select();
            $this->assign('user',$user);
            $this->display();
        }else{
            $password = I('password');
            if('' != $password && !empty($password)){
                $data['password'] = I('password','','md5');
            }
            $param_arr = array(
                $data['nickname'] = I('nickname'),
                $data['sex'] = I('sex'),
                $data['birthday'] = strtotime(I('birthday')),
                $data['single'] = I('single'),
                $data['school_id'] = I('school_id'),
            );
            $msg_arr = array('用户昵称','性别','出生日期','是否单身','所属学校');
            $this->empty_ajaxReturn($param_arr,$msg_arr);

            $data['integral'] = I('integral',0);
            $data['disable'] = I('disable',0);
            if($_FILES['form_file']!=''&&!empty($_FILES['form_file'])){   //判断图片是否有上传
                $res = upload_file($_FILES['form_file'],'user');
                if($res['errorCode']!=0){   //文件上传失败
                    $this->request_ajaxReturn('编辑失败,'.$res['msg'],1);
                }else{          //文件上传成功
                    if(!empty($user)){       //编辑---删除原图片
                        unlink('.'.$user['image']);
                    }
                    $data['image'] = $res['file_name'];
                }
            }
            if(false!==M('User')->where("user_id='$id'")->save($data)){
                $this->request_ajaxReturn('编辑成功', 0);
            }else{
                $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
            }
        }
    }

    //删除会员
    public function delUser(){
        $id = I('id');
        $user = M('User')->find($id);
        if(false!==M('User')->delete($id)){
            unlink('.'.$user['image']);
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //修改用户状态
    public function cUserStatus(){
        $user_id = I('uid');
        $data['disable'] = I('disable');
        $res = M('User')->where("user_id = '$user_id'")->save($data);
        if($res){
            $this->ajaxReturn(array('msg'=>'修改成功','errorCode'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'修改失败','errorCode'=>1));
        }
    }

    //学校列表
    public function schoolList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $keyword = str_replace("%","\\%",$keyword);
        $where['name'] = array('like','%'.$keyword.'%');
        $page = I('p',1);
        $this->list = M('School')->where($where)->page($page,20)->order('school_id DESC')->select();
        //数据分页
        $count = M('School')->where($where)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page',$show);
        $this->display();
    }

    //删除学校选项
    public function delSchool(){
        $id = I('id');
        if(false!==M('School')->delete($id)){
            $this->request_ajaxReturn('删除成功',0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试',1);
        }
    }

    //添加学校
    public function addSchool(){
        if(IS_GET){
            $this->display();
        }else{
            $name = I('name');
            $this->empty_ajaxReturn(array($data['name']=I('name')),array('学校名称'));
            if(false!==M('School')->add($data)){
                $this->request_ajaxReturn('添加成功',0);
            }else{
                $this->request_ajaxReturn('添加失败,请刷新后重试',1);
            }
        }
    }

    //导出用户表Excel
    public function exportExcelUser(){
        $keyword = I('get.keyword','');
        $where['phone'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
        $where['nickname'] = array('like','%'.$keyword.'%');
        $data = M('User')
            ->field('u.user_id,u.phone,u.nickname,u.image,u.sex,u.birthday,u.single,s.name AS school_name,u.integral,u.disable')
            ->join('LEFT JOIN axd_school s ON s.school_id = u.school_id')
            ->alias('u')->where($where)->select();
        foreach($data AS $key=>$val){
            $data[$key]['image'] = str_replace('/Public/uploads/', C('WEB_URL')."/Public/uploads/", $val['image']);
            $data[$key]['sex'] = $val['sex']==1?'男':'女';
            $data[$key]['birthday'] = date("Y-m-d", $val['birthday']);
            $data[$key]['single'] = $val['single']==0?'否':'是';
            $data[$key]['disable'] = $val['disable']==0?'正常':'禁用';
        }
        $title_arr = array('ID','账号','昵称','头像','性别','出生日期','是否单身','学校','积分','状态');
        array_unshift($data,$title_arr);
        create_xls($data,$title_arr,array(10,20,20,20,10,15,10,15,10,10),'用户列表'.date("Ymd", time()));
    }
}