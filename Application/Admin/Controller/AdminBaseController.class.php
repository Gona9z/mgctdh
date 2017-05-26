<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
use Org\Util\Rbac;
use Think\Controller;
/**
 * admin 基类控制器
 */
class AdminBaseController extends BaseController {
    //初始化方法
    function _initialize(){
        $this->pro_name = C('PRO_NAME');
        $this->assign('action',ACTION_NAME);

//        dump($_SESSION);
        //过滤不需要登陆的行为
        if(!in_array(ACTION_NAME,array('login','logout','adminLogin','verify','welp'))){
            $admin_user = session('axd_admin');
            $admin_id = $admin_user['admin_id'];
            if($admin_id > 0 ){
                $admin = session('axd_admin');
                $admin_id = $admin['admin_id'];
                $admin_role_id = M('RoleAdmin')->where("admin_id='$admin_id'")->getField('role_id');
                if('1'!=$admin_role_id){
                    $all_role_pri = M('Node')->where("level=2")->getField('method',true);
                    $now_method_str = CONTROLLER_NAME.'/'.ACTION_NAME;
                    if(in_array($now_method_str,$all_role_pri)){
                        $role_pri_method = session('role_pri_method');
                        if(!in_array($now_method_str,$role_pri_method)){
                            $this->error('没有权限',U('Admin/Index/login'),1);
                        }
                    }
                }
            }else{
                $this->error('请先登陆',U('Admin/Index/login'),1);
            }
        }
    }


    /**
     * 初始化编辑器链接
     * 本编辑器参考 地址 http://fex.baidu.com/ueditor/
     */
    function initEditor(){
        $this->server_url = __APP__."/Admin/Ueditor/index";
    }
}

