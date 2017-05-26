<?php
/**
 * 生成二维码<br>
 * @param  string  $url  url连接<br>
 * @param  integer $size 尺寸 纯数字<br>
 */
function qrcode($url,$size=4){
    Vendor('Phpqrcode.phpqrcode');
    // 如果没有http 则添加
    if (strpos($url, 'http')===false) {
        $url='http://'.$url;
    }
    ob_clean();
    QRcode::png($url,false,QR_ECLEVEL_L,$size,2,false,0xFFFFFF,0x000000);
}