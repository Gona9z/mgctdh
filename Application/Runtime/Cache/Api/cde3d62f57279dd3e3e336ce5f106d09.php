<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($subject["name"]); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/axd/Public/css/public.css">
    <link rel="stylesheet" href="/axd/Public/css/subject_m.css">
</head>
<style>
    .banner p {
        position: relative;
        /*top: 270px;*/
        left: 20px;
        font-size: 20px;
        color: #fff;
        z-index: 2;
        margin-top: -18%;
    }
</style>
<body>
<div class="header">
    <div class="logo">
        <img src="/axd/Public/img/logo_s.png" alt="">
        <div class="content">
            <h2>A梦校园</h2>
            <p>A梦校园</p>
        </div>
    </div>
    <div class="download">
        <a href="<?php echo ($tc_yyb); ?>">点击下载</a>
    </div>
</div>
<div class="box">
    <div class="banner">
        <img src="/axd<?php echo ($subject["image_content"]); ?>" alt="">
        <p><?php echo ($subject["name"]); ?></p>
    </div>
    <div class="theme">
        <div class="text">
            <p><?php echo ($subject["text_content"]); ?></p>
        </div>
        <div class="list">
            <ul>
                <?php if(is_array($subject['goods_list'])): foreach($subject['goods_list'] as $k=>$g): ?><li>
                    <p><?php echo ($g["name"]); ?></p>
                    <img src="/axd<?php echo ($g["image"]); ?>" alt="">
                    <div class="details">
                        <div class="left">
                            <span class="price">￥<?php echo ($g["price"]); ?></span>
                            <span>
                                <i class="xin"></i>
                                <?php echo ($g["comment_count"]); ?>
                            </span>
                        </div>
                        <div class="right">
                            <a href="<?php echo U('Api/Goods/shareGoods',array('id'=>$g['goods_id']));?>">查看详情</a>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>


</div>


<div class="app">
    <img src="/axd/Public/img/logo_s.png" alt="">
    <p><strong>A梦校园</strong> <span>A梦校园</span></p>
    <a href="<?php echo ($tc_yyb); ?>">
        下载A梦校园 客户端查看更多
    </a>
</div>


<!--<div class="footer">
    <div class="footer_box">
        <a href="javascript:;">立即前往购买</a>
    </div>
</div>-->


</body>
</html>