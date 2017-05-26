<?php
/**
 * ajax单文件上传
 * @param $upfile 文件
 * @param $folder 文件夹名
 *
 */
function upload_file($upfile,$folder){
    if(is_uploaded_file($upfile['tmp_name'])) {
        $photo_folder = "./Public/uploads/$folder/".date('Y',time())."/".date('m',time())."/".date('d',time())."/"; //上传照片路径
        ///////////////////////////////////////////////////开始处理上传
        $photo_name = $upfile["tmp_name"];
        $photo_size = getimagesize($photo_name);
//        $file_name = $upfile['name'];
        $file_name = rand(1000, 9999).date('His',time());

        if (!file_exists($photo_folder))//照片目录
            mkdir($photo_folder, 0777, true);
        $pinfo = pathinfo($upfile["name"]);
        $photo_type = $pinfo['extension'];//上传文件扩展名
        $photo_server_folder = $photo_folder.$file_name.'.'.$photo_type;//时间+6位随机数为文件名
        if (!move_uploaded_file($photo_name, $photo_server_folder)) {
            return array('errorCode'=>-3,'msg'=>'移动文件出错');
        }
        $pinfo = pathinfo($photo_server_folder);
        $fname = $pinfo['basename'];
        return array('errorCode'=>0,'file_name'=>substr($photo_server_folder,1));
    }
    return array('errorCode'=>1,'msg'=>'上传文件不存在');
}
function html2text($str){
    $str = preg_replace("/<style .*?<\/style>/is", "", $str);
    $str = preg_replace("/<script .*?<\/script>/is", "", $str);
    $str = preg_replace("/<br \s*\/?\/>/i", "", $str);
    $str = preg_replace("/<\/?p>/i", "", $str);
    $str = preg_replace("/<\/?td>/i", "", $str);
    $str = preg_replace("/<\/?div>/i", "", $str);
    $str = preg_replace("/<\/?blockquote>/i", "", $str);
    $str = preg_replace("/<\/?li>/i", "", $str);
    $str = preg_replace("/\&nbsp\;/i", " ", $str);
    $str = preg_replace("/\&nbsp/i", " ", $str);
    $str = preg_replace("/\&amp\;/i", "", $str);
    $str = preg_replace("/\&amp/i", "", $str);
    $str = preg_replace("/\&lt\;/i", "", $str);
    $str = preg_replace("/\&lt/i", "", $str);
    $str = preg_replace("/\&ldquo\;/i", '', $str);
    $str = preg_replace("/\&ldquo/i", '', $str);
    $str = preg_replace("/\&lsquo\;/i", "", $str);
    $str = preg_replace("/\&lsquo/i", "", $str);
    $str = preg_replace("/\&rsquo\;/i", "", $str);
    $str = preg_replace("/\&rsquo/i", "", $str);
    $str = preg_replace("/\&gt\;/i", "", $str);
    $str = preg_replace("/\&gt/i", "", $str);
    $str = preg_replace("/\&rdquo\;/i", '', $str);
    $str = preg_replace("/\&rdquo/i", '', $str);
    $str = strip_tags($str);
    $str = html_entity_decode($str, ENT_QUOTES);
    $str = preg_replace("/\&\#.*?\;/i", "", $str);

    return $str;
}

//将数据库中查出的列表以指定的 id 作为数组的键名
function convert_arr_key($arr, $key_name)
{
    $arr2 = array();
    foreach($arr as $key => $val){
        $arr2[$val[$key_name]] = $val;
    }
    return $arr2;
}
/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
 */
function create_xls($data,$title_arr,$width_num_arr='',$filename='simple.xls'){
    $e_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    $filename=str_replace('.xls', '', $filename).'.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');//设置独表名
    $phpexcel->setActiveSheetIndex(0);

    //设置列宽
    foreach($width_num_arr AS $key=>$val){
        $phpexcel->getActiveSheet()->getColumnDimension($e_arr[$key])->setWidth($val);
    }
    //设置表头
    foreach($title_arr AS $key=>$val){
        $phpexcel->setActiveSheetIndex(0)->setCellValue($e_arr[$key].'1', $val);
    }
    ob_end_clean();// 清空（擦除）缓冲区并关闭输出缓冲
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}
/**
 * 基础分页的相同代码封装，使前台的代码更少
 * @param $count 要分页的总记录数
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage($count, $pagesize = 10) {
    $p = new Think\Page($count, $pagesize);
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $p->lastSuffix = false;//最后一页不显示为总页数
    return $p;
}
