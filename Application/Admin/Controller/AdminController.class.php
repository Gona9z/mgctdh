<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class AdminController extends AdminBaseController {

    //管理员登录
    public function adminLogin(){
        if(!IS_POST){
            $this->error('错误请求', U('Admin/Index/login'), 1);
        }else{
            $account = I('post.account');
            $password = I('post.password', '', 'md5');
            $admin = M('Admin')->field('admin_id,account,password')->where("account='$account'")->find();
            if(empty($admin)){
                $this->request_ajaxReturn('该账号不存在', 1);
            }else{
                if($password!=$admin['password']){
                    $this->request_ajaxReturn('密码错误', 1);
                }
                unset($admin['password']);
                session('axd_admin', $admin);
                $admin_id = $admin['admin_id'];
                $admin_role_id = M('RoleAdmin')->where("admin_id='$admin_id'")->getField('role_id');
                if('1'!=$admin_role_id){
                    $role_id = M('RoleAdmin')->where("admin_id='$admin_id'")->getField('role_id');
                    session('role_id',$role_id);
                    //获取角色拥有权限
                    $where['role_id'] = $role_id;
                    $role_pri = M('Access')->where($where)->getField('node_id',true);
                    session('role_pri', $role_pri);
                    //获取角色权限列表
                    $role_pri_method = M('Access')
                        ->join('axd_node n ON n.id = a.node_id')
                        ->alias('a')->where($where)->getField('method',true);
                    session('role_pri_method',$role_pri_method);
                }else{
                    $role_pri = M('Node')->where("level=2")->getField('id',true);
                    session('role_pri', $role_pri);
                }
                $data['last_login'] = time();
                M('Admin')->where("admin_id='$admin_id'")->save($data);
                $this->request_ajaxReturn('登录成功', 0);
            }
        }
    }

    //退出登录
    public function logout(){
        session_unset();
        session_destroy();
        $this->success("退出成功",U('Admin/Index/login'));
    }

    //角色列表
    public function adminRoleList(){
        $this->list = M('Role')->select();
        $this->display();
    }

    //删除管理员角色
    public function delAdminRole(){
        $id = I('id');
        $this->empty_ajaxReturn(array($id),array('管理员角色Id'));
        if(false!==M('Role')->delete($id)){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    //添加编辑管理员角色
    public function addEditAdminRole(){
        $id = I('id');
        $admin_role = M('Role')->find($id);
        if(IS_GET){
            $this->assign('admin_role',$admin_role);
            $this->display();
        }else{
            $data['name'] = I('name');
            $data['status'] = I('status');

            if(empty($admin_role)){
                if(false!==M('Role')->add($data)){
                    $this->request_ajaxReturn('添加成功', 0);
                }else{
                    $this->request_ajaxReturn('添加失败', 1);
                }
            }else{
                if(false!==M('Role')->where("role_id='$id'")->save($data)){
                    $this->request_ajaxReturn('编辑成功', 0);
                }else{
                    $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
                }
            }
        }
    }

    //管理员列表
    public function adminUserList(){
        $keyword = I('keyword','');
        $this->assign('keyword',$keyword);
        $where['au.account'] = array('like','%'.$keyword.'%');
        $this->list = M('Admin')
            ->field('au.*,r.name AS role_name,r.role_id')
            ->join('LEFT JOIN axd_role_admin ra ON ra.admin_id = au.admin_id')
            ->join('LEFT JOIN axd_role r ON r.role_id = ra.role_id')
            ->where($where)->alias('au')->select();
        $this->display();
    }

    //删除管理员
    public function delAdmin(){
        $id = I('id');
        $this->empty_ajaxReturn(array($id),array('管理员Id'));
        if(false!==M('Admin')->delete($id)){
            $this->request_ajaxReturn('删除成功', 0);
        }else{
            $this->request_ajaxReturn('删除失败,请刷新后重试', 1);
        }
    }

    //配置管理员角色权限
    public function setAccess(){
        $id = I('id');
        if(IS_GET){
            $this->role = M('Role')->find($id);
            //获取所有权限列表
            $all_pri = M('Node')->where('level=1')->order('id')->select();
            foreach($all_pri AS $key=>$val){
                $pid = $val['id'];
                $secnd_pri = M('Node')->where("pid='$pid'")->select();
                $all_pri[$key]['secnd_pri'] = $secnd_pri;
            }
            $this->assign('all_pri',$all_pri);
            //获取角色拥有权限
            $where['role_id'] = $id;
            $this->role_pri = M('Access')->where($where)->getField('node_id',true);
            $this->display();
        }else{
            $model = new Model();
            $model->startTrans();
            $role_pri = I('role_pri');
            foreach($role_pri AS $key=>$val){
                $data[$key]['role_id'] = $id;
                $data[$key]['node_id'] = $val;
                $data[$key]['level'] = 2;
            }

            $res = $model->table(C('DB_PREFIX')."access")->where("role_id = '$id'")->delete();
            $res2 = $model->table(C('DB_PREFIX')."access")->addAll($data);
            if (false!==$res && false!==$res2) {
                $model->commit();
                $this->request_ajaxReturn('修改成功', 0);
            }else {
                $model->rollback();
                $this->request_ajaxReturn('修改失败', 1);
            }

        }
    }

    //添加编辑管理员
    public function addEditAdmin(){
        $id = I('id');
        $admin_where['a.admin_id'] = $id;
        $admin = M('Admin')
            ->field('a.admin_id,a.account,ra.role_id')
            ->join('LEFT JOIN axd_role_admin ra ON ra.admin_id = a.admin_id')
            ->alias('a')->where($admin_where)->find();
        if(IS_GET){
            $this->assign('admin',$admin);
            $this->role_list = M('Role')->select();
            $this->display();
        }else{
            $model = new Model();
            $model->startTrans();

            $param_arr = array(
                $data['account'] = I('post.account'),
                $role_id = I('role_id'),
            );
            $this->empty_ajaxReturn($param_arr,array('账号','角色Id'));
            if(empty($admin)){
                $this->empty_ajaxReturn(array($password=I('post.password')),array('密码'));
                $data['password'] = md5($password);
                $data['add_time'] = time();
                $res1 = $model->table(C('DB_PREFIX').'admin')->add($data);
                $role_data['role_id'] = $role_id;
                $where['admin_id'] = $role_data['admin_id'] = $res1;
                $res2 = $model->table(C('DB_PREFIX').'role_admin')->add($role_data);
            }else{
                $password = I('post.password');
                if(!empty($password))
                    $data['password'] = md5($password);
                $res1 = $model->table(C('DB_PREFIX').'admin')->where("admin_id='$id'")->save($data);
                $where['admin_id'] = $id;
                $res2 = $model->table(C('DB_PREFIX').'role_admin')->where($where)->setField('role_id',$role_id);
            }
            if(false!==$res1 && false!==$res2){
                $model->commit();
                $this->request_ajaxReturn('编辑成功', 0);
            }else{
                $model->rollback();
                $this->request_ajaxReturn('编辑失败,请刷新后重试', 1);
            }

        }
    }

}