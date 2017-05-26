<?php
function getGoodsAjaxPageShow($totalRows, $listRows=20, $nowPage=1,$javaScripMethodName='',$cate_id){
    $rollPage   = 11;// 分页栏每页显示的页数
    $firstRow   = $listRows * ($nowPage - 1);
    $lastSuffix = true; // 最后一页是否显示总页数
    C('VAR_PAGE') && $p = C('VAR_PAGE'); //设置分页参数名称
    /* 基础设置 */
    $nowPage = empty($nowPage) ? 1 : intval($nowPage);
    $nowPage = $nowPage>0 ? $nowPage : 1;
    $firstRow = $listRows * ($nowPage - 1);
    // 分页显示定制
    $config  = array(
        'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
        'prev'   => '<<',
        'next'   => '>>',
        'first'  => '1...',
        'last'   => '...%TOTAL_PAGE%',
        'theme'  => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    );
    if(0 == $totalRows) return '';
    /* 计算分页信息 */
    $totalPages = ceil($totalRows / $listRows); //总页数
    if(!empty($totalPages) && $nowPage > $totalPages) {
        $nowPage = $totalPages;
    }
    /* 计算分页临时变量 */
    $now_cool_page      = $rollPage/2;
    $now_cool_page_ceil = ceil($now_cool_page);
    $lastSuffix && $config['last'] = $totalPages;
    //上一页
    $up_row  = $nowPage - 1;
    $up_page = $up_row > 0 ? '<a class="prev" href="javaScript:void(0);" onclick="javascript:'.$javaScripMethodName.'('.$cate_id.','.$up_row.');">'.$config['prev'].'</a>':'';
    //下一页
    $down_row  = $nowPage + 1;
    $down_page = ($down_row <= $totalPages) ? '<a class="next" href="javaScript:void(0)" onclick="javascript:'.$javaScripMethodName.'('.$cate_id.','.$down_row.');">'.$config['next'].'</a>':'';
    //第一页
    $the_first = '';
    if($totalPages > $rollPage && ($nowPage - $now_cool_page) >= 1){
        $the_first = '<a class="first" href="javaScript:void(0);" onclick="javascript:'.$javaScripMethodName.'('.$cate_id.',1);">'.$config['first'].'</a>';
    }
    //最后一页
    $the_end = '';
    if($totalPages > $rollPage && ($nowPage + $now_cool_page) < $totalPages){
        $the_end = '<a class="end" href="javaScript:void(0);" onclick="javascript:'.$javaScripMethodName.'('.$cate_id.','.$totalPages.');">'.$config['last'].'</a>';
    }
    //数字连接
    $link_page = "";
    for($i = 1; $i <= $rollPage; $i++) {
        if (($nowPage - $now_cool_page) <= 0) {
            $page = $i;
        } elseif (($nowPage + $now_cool_page - 1) >= $totalPages) {
            $page = $totalPages - $rollPage + $i;
        } else {
            $page = $nowPage - $now_cool_page_ceil + $i;
        }
        if ($page > 0 && $page != $nowPage) {
            if ($page <= $totalPages) {
                $link_page .= '<a class="num" href="javaScript:void(0);" onclick="javascript:'.$javaScripMethodName.'('.$cate_id.','.$page.');">' . $page . '</a>';
            } else {
                break;
            }
        } else {
            if ($page > 0 && $totalPages != 1) {
                $link_page .= '<span class="current">' . $page . '</span>';
            }
        }
    }
    //替换分页内容
    $page_str = str_replace(
        array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
        array($config['header'], $nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $totalRows, $totalPages),
        $config['theme']);
    return "<div>{$page_str}</div>";
}

/*
 * 返回接口json
 */
function request_result( $msg , $erro_code , $data = array()){
    header("Content-type: text/html; charset=utf-8");
    $result  = array();
    $result['message']  = $msg;
    $result['errorCode']  =  $erro_code;
    $result['data']  =  $data;
    // print_r($result);
    $tmp = str_replace("\\/", "/", json_encode($result,true));
    $tmp = str_replace("null", '""', $tmp );
    $tmp =  preg_replace_callback(
        "#\\\u([0-9a-f]{4})#i",
        function( $matchs)
        {
            return  iconv('UCS-2BE', 'UTF-8',  pack('H4',  $matchs[1]));
        },
        $tmp
    );
    echo $tmp;
    exit();
}
/*
 * 简单的结果返回
 * $is_add int 是否添加
 * $msg String 操作
 * $res bool 结果
 */
function simple_result( $msg , $res ,$is_add = 1 ,$data = array()){
    $msg  = trim($msg);
    if($res !== FALSE)
    {
        request_result(TRUE, $msg .'成功' , 0, $data);
    }
    else
    {
        request_result(FALSE, $msg .'失败', 10000 );
    }
}

/*
 * 参数为空提示
 */
function parmvalidate($parm)
{
    foreach ( $parm as $val)
    {
        if($val['is_str'])
        {
            $parmval =  I("post.{$val['key']}",'','strip_tags');
        }
        else
        {
            $parmval =  I("post.{$val['key']}",'','intval');
        }
        if(empty($parmval))
        {
            request_result($val['msg'].'不能为空' , 1);
        }
    }
    return;
}

/*
 * 根据日期生成目录
 */
function create_up_path($rtpath)
{
    if(empty($rtpath))
        return FALSE;
    $ymstr = date("Ym",time());
    $path = rtrim($rtpath,'/'). "/" . $ymstr . rand(1, 8) . "/";
    if(!file_exists($path))
        mkdir ($path, 0777, true);
    return   $path ;
}
/*
 * 生成图片文件名称
 */
function create_uq_imgpath($rtpath,$postfix)
{
    if(empty($rtpath))
        return FALSE;
    $imgname = time() . rand(1000, 9999). "." .trim($postfix,'.');
    $path = $rtpath . $imgname;
    if(!file_exists($path))
        return $path;
    else
        create_uq_imgpath($rtpath,$postfix);
}
/*
 * 生成随机数
 * @parm int $leng 长度
 * return string
 */
 function noRand($leng=6,$is_str = 0){
     $rand_array=range(0,9);
     if($is_str){
         $rand_array = array_merge(range('a', 'z'),$rand_array);
     }
     shuffle($rand_array);
     $reset = array_slice($rand_array,0,$leng);
     return implode( $reset);
 }

/*
 * 二维数组排序
 * $array 要排序的数组; $logic 排序顺序，SORT_DESC 降序；SORT_ASC 升序; $condition 排序字段
 */
function arraySort($array,$logic,$condition){
    $arrSort=array();
    foreach($array AS $uniqid => $row){
        foreach($row AS $key=>$value){
            $arrSort[$key][$uniqid] = $value;
        }
    }
    $sort = array(
        'direction' => $logic, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        'field'     => $condition,       //排序字段
    );
    if($sort['direction']){
        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $array);
    }
    return $array;
}

/**
 * 字符串截取，支持中文和其他编码
 *
 * @static
 *
 * @access public
 * @param string $str
 *        	需要转换的字符串
 * @param string $start
 *        	开始位置
 * @param string $length
 *        	截取长度
 * @param string $charset
 *        	编码格式
 * @param string $suffix
 *        	截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists ( "mb_substr" ))
        $slice = mb_substr ( $str, $start, $length, $charset );
    elseif (function_exists ( 'iconv_substr' )) {
        $slice = iconv_substr ( $str, $start, $length, $charset );
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all ( $re [$charset], $str, $match );
        $slice = join ( "", array_slice ( $match [0], $start, $length ) );
    }
    return $suffix ? $slice . '...' : $slice;
}

/**
 * 图片异步上传
 * $suff : 文件格式
 */
function file_upload($urlcode,$suff,$folder){

    S("up",$urlcode);

    $name="/Public/uploads/".$folder."/".rand(1000, 9999).date('His',time()).".".$suff;

    $imgStr=str_replace(" ","+",$urlcode);

    $tmp = base64_decode($imgStr);

    $result= file_put_contents( ".".$name, $tmp);

    $pic_url=$name;
    if($result<0||$urlcode==null){
        return "";
    }else{
        return $pic_url;
    }
}

/**
 * 图片异步上传
 */
function pic_upload($urlcode,$suff){

    S("up",$urlcode);

    $chars="abcdefghijklmnopqrstuvwxyz";
    $string="";
    for($i=0;$i<3;$i++){
        $num = rand(0,25);
        $string.=$chars[$num];
    }

    $name="/Public/avatar/".date('ymd',time()).$string.rand(1000, 9999).date('His',time()).".".$suff;

    // $imgStr=str_replace(" ","+",$urlcode);

    $tmp = base64_decode($urlcode);

    $result= file_put_contents( ".".$name, $tmp);

    $pic_url= $name;//"http://".$_SERVER['SERVER_NAME']."/lldoctor".$name;
    if($result<0||$urlcode==null){
        return "";
    }else{
        return $pic_url;
    }
}

/**
 * 图片异步上传,相对于上两个方法，多了一个参数file
 * $urlcode  图片的base64码;$file 项目下存放图片的文件夹 例如:/Public/article_activity_images/    ;$suff 图片格式
 */
function pic_upload_infile($urlcode,$file,$suff){

    S("up",$urlcode);

    $chars="abcdefghijklmnopqrstuvwxyz";
    $string="";
    for($i=0;$i<3;$i++){
        $num = rand(0,25);
        $string.=$chars[$num];
    }
    /*$name="/Public/article_activity_images/".date('ymd',time()).$string.date('His',time()).".".$suff;*/
    $name=$file.date('ymd',time()).$string.rand(1000, 9999).date('His',time()).".".$suff;

    $imgStr=str_replace(" ","+",$urlcode);

    $tmp = base64_decode($imgStr);

    $result= file_put_contents( ".".$name, $tmp);

    $pic_url=$name;
    if($result<0||$urlcode==null){
        return "";
    }else{
        return $pic_url;
    }
}


