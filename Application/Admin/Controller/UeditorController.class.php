<?php
namespace Admin\Controller;

use Think\Upload;

class UeditorController extends AdminBaseController {
    private $CONFIG = '';

    public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Beijing");
        error_reporting(E_ERROR | E_WARNING);
        header("Content-Type: text/html; charset=utf-8");
    }

    public function index(){
        $file_url = C('WEB_URL')."/Public/ueditor/php/config.json";
        $this->CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($file_url)), true);
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result =  json_encode($this->CONFIG);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $this->upload_file();
                break;
            /* 列出图片 */
            case 'listimage':
//                $result = include("action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
//                $result = include("action_list.php");
                break;
            /* 抓取远程文件 */
            case 'catchimage':
//                $result = include("action_crawler.php");
                break;
            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }

    //文件上传
    public function upload_file(){
        //实例化上传类
        $upload = new Upload();
        //配置
        $upload->subName = array('date', 'Y/m/d');//子目录创建方式
        $upload->rootPath = './Public/uploads/';//保存根路径
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $upload->rootPath = './Public/uploads/uploadimage/';
                $upload->maxSize = $this->CONFIG['imageMaxSize'];
                break;
            case 'uploadscrawl':
                $upload->rootPath = './Public/uploads/uploadscrawl/';
                $upload->maxSize = $this->CONFIG['scrawlMaxSize'];
                break;
            case 'uploadvideo':
                $upload->rootPath = './Public/uploads/uploadvideo/';
                $upload->maxSize = $this->CONFIG['videoMaxSize'];
                break;
            case 'uploadfile':
            default:
                $upload->rootPath = './Public/uploads/upload_default/';
                $upload->maxSize = $this->CONFIG['fileMaxSize'];
                break;
        }
        if (!file_exists($upload->rootPath))//照片目录
            mkdir($upload->rootPath, 0777, true);
        //上传
        $info = $upload->upload();
        if($info) {
            $arr = array(
                'state'=>'SUCCESS',
                'url'=>C('WEB_URL').'/Public/uploads/'.$_GET['action'].'/'.$info['upfile']['savepath'].$info['upfile']['savename'],
                'title'=>$info['upfile']['savename'],
                'original'=>$info['upfile']['name'],
                'type'=>$info['upfile']['ext'],
                'size'=>$info['upfile']['size']
            );
        } else {
            $arr = array('state'=>$upload->getError().json_encode($_FILES));
        }
        echo json_encode($arr);
    }

}