<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($interact["title"]); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/axd/Public/css/public.css">
    <style>
        .box_title{
            padding:0.4rem;
        }
        .box_title > h2{
            color: #2f2f2f;
            font-size:14px;
            font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;
        }
        .box_title > span{
            color: #8f8f8f;
            font-size:12px;
        }
        .box{
            padding: 10px;
        }
        video{width: 100%;}
        img{width: 100%;}
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
    <div class="box_title">
        <h2>标题标题</h2>
        <span><?php echo (date('Y-m-d',$interact["time"])); ?></span>
        <span>作者:<?php echo ($interact["user_nickname"]); ?></span>
    </div>
    <?php echo ($content); ?>
</div>







<!--<div class="app">
    <img src="/axd/Public/img/logo_s.png" alt="">
    <p><strong>A梦校园</strong> <span>A梦校园</span></p>
    <a href="<?php echo ($tc_yyb); ?>">
        下载A梦校园 客户端查看更多
    </a>
</div>-->


<div class="footer">
    <div class="footer_box">
        <a href="<?php echo ($tc_yyb); ?>">下载A梦校园</a>
    </div>
</div>


</body>
</html>