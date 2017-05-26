<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($goods["name"]); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/axd/Public/css/public.css">
    <link rel="stylesheet" href="/axd/Public/css/clss.css">
    <style>
        .p_line{line-height: 30px;}
    </style>
</head>
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
    <div class="details">
        <img src="/axd<?php echo ($goods["image"]); ?>" alt="">
        <h2><?php echo ($goods["name"]); ?></h2>
        <p class="price">￥<?php echo ($goods["price"]); ?></p>
        <p class="p_line"><i class="xin"></i><?php echo ($goods["collect_count"]); ?></p>
        <p class="text"><?php echo ($goods["text_content"]); ?></p>
    </div>
    <div class="list">
        <h2>
            <span></span>
            <p>猜你喜欢</p>
            <span></span>
        </h2>
        <ul>
            <?php if(is_array($list)): foreach($list as $key=>$l): ?><li>
                <img src="/axd<?php echo ($l["image"]); ?>" alt="">
                <p><?php echo ($l["name"]); ?></p>
                <p class="price">￥89.00</p>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>

</div>


<div class="app">
    <img src="/axd/Public/img/logo_s.png" alt="">
    <p><strong>A梦校园</strong> <span>A梦校园</span></p>
    <a href="<?php echo ($tc_yyb); ?>">
        下载A梦校园 客户端查看更多
    </a>
</div>

<div class="footer">
    <div class="footer_box">
        <a href="<?php echo ($goods["tb_link"]); ?>">立即前往购买</a>
    </div>
</div>




</body>
</html>