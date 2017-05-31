<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($pro_name); ?></title>
    <meta name="keywords" content="<?php echo ($pro_name); ?>,学校,青春,购物,APP,安卓android,苹果iphone">
    <link rel="stylesheet" href="/axd/Public/css/unified.css">
    <link rel="stylesheet" href="/axd/Public/css/my_integral.css">
    <script src="/axd/Public/js/jquery-1.12.4.js"></script>
    <script src="/axd/Public/js/unified.js"></script>
    <script src="/axd/Public/js/my_integral.js"></script>

</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<script>
    $(function(){
        $('.login_btn').click(function(){
            $.ajax({
                url: "/axd/Home/User/userLogin?"+Math.random(),
                data: $('#login_form').serialize(),
                dataType: "json",
                success: function(data){
                    console.log(data);
                    var result = eval(data);
                    if(result.errorCode==0){
                        location.href = '/axd';
                    }else{
                        alert(result.msg);
                    }
                }
            });
//            $(document).ajaxError(function(){
//                alert(1);
//            })

        });
    });
</script>
<style>
    #wb_share{display: none;}
</style>
<html xmlns:wb="http://open.weibo.com/wb">
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
<body>
<div id="maskLayer"></div>
<div id="login">
    <div class="login_box">
        <div class="login_title">
            <div class="login_name">
                登录校疯购帐号
            </div>
            <div class="fork">
                <img src="/axd/Public/img/fork.png" alt="">
            </div>
        </div>
        <div class="login_input">
            <form action="<?php echo U('User/userLogin');?>" method="post" id="login_form">
                <ul>
                    <li>
                        <label>帐号：</label>
                        <input type="text" placeholder="请输入手机号码" name="phone">
                    </li>
                    <li>
                        <label>密码：</label>
                        <input type="password" placeholder="请输入您的密码" name="password">
                    </li>
                    <li>
                        <input class="choose" type="checkbox">
                        <label>自动登录</label>
                    </li>
                    <li>
                        <input class="login_btn" type="button" value="登录">
                    </li>
                </ul>
            </form>
        </div>
        <div class="other_login">
            <p>其他登录方式</p>
            <p class="cross"></p>
            <div class="other_login_box">
                <ul>
                    <li>
                        <div class="login_wx_ico"></div>
                        <span>微信</span>
                    </li>
                    <li>
                        <div class="login_wb_ico"></div>
                        <span>微博</span>
                    </li>
                    <li>
                        <div class="login_qq_ico"></div>
                        <span>QQ</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>


<div id="share">
    <div class="share_box">
        <div class="share_title">
            <p>分享到</p>
            <div class="fork"></div>
        </div>
        <ul>
            <li id="wx_s"><img src="/axd/Public/img/wx_big.png" alt=""></li>
            <!--<wb:share-button appkey="1494721552" id="ds2" addition="simple"
                     default_text="1212" type="button" pic="http%3A%2F%2Fwx2.sinaimg.cn%2Fsquare%2F006nFLd1gy1fd20fi6vtej3028028mx3.jpg">
            </wb:share-button>-->
            <li id="wb_s"><img src="/axd/Public/img/wb_big.png" alt=""></li>
            <li id="qq_s"><img src="/axd/Public/img/qq_big.png" alt=""></li>
            <li id="kj_s"><img src="/axd/Public/img/qqkj_big.png" alt=""></li>
        </ul>
    </div>

</div>


<div id="top_nav">
    <div class="school">
        <a href="<?php echo U('Index/index');?>"><div class="logo"></div></a>
        <div class="search">
            <?php if(empty($URL)): ?><form action="<?php echo U('Merchant/searchGoods');?>" method="post" id="form_g">
                    <input class="search_box" type="text" placeholder="搜索美文、宝贝" name="keyword" value="<?php echo ($keyword); ?>" id="search_go">
                    <input type="button" class="search_btn" value="搜索" id="click_search_box_g">
                </form>
                <?php else: ?>
                <form action="<?php echo ($URL); ?>" method="post" id="form_s">
                    <input class="search_box" type="text" placeholder="搜索美文、宝贝" name="keyword" value="<?php echo ($keyword); ?>" id="search_su">
                    <input type="button" class="search_btn" value="搜索" id="click_search_box_s">
                </form><?php endif; ?>
        </div>
        <div class="login_reg">
            <?php if($_SESSION['axd_user']== ''): ?><div class="login_reg_box">
                    <span class="login"><a href="javascript:;">登录 | 注册</a></span>
                </div>
                <?php else: ?>
                <div class="login_box">
                    <div class="head_img">
                        <?php if(empty($_SESSION['axd_user']['image'])): ?><img src="/axd/Public/img/default_headicon.png" alt="">
                            <?php else: ?>
                            <img src="<?php echo str_replace('/Public/uploads/','/axd/Public/uploads/',$_SESSION['axd_user']['image']);?>" alt="">
                            <!--<img src="/axd<?php echo ($_SESSION['axd_user']['image']); ?>" alt="">--><?php endif; ?>
                        <span><?php echo ($_SESSION['axd_user']['nickname']); ?></span>
                    </div>
                    <div class="head_background">
                        <p class="my_integral"><a href="<?php echo U('User/myIntegral');?>">我的积分</a></p>
                        <p class="my_collection"><a href="<?php echo U('User/getMyCollect');?>">我的收藏</a></p>
                        <p class="cancellation"><a href="<?php echo U('User/logout');?>">注销登录</a></p>
                    </div>
                </div><?php endif; ?>
        </div>
        <div class="app_ewm">
            <div class="phone_ico"></div>
            <span style="display: block;width: 126px;">下载<?php echo ($pro_name); ?>APP</span>
            <div class="ewm">
                <div class="ios_ewm">
                    <img src="<?php echo U('Index/qr_code',array('type'=>1));?>" alt="">
                    <p>IOS</p>
                    <!--<p><a href="http://120.25.248.165/axd/Public/app_package/SchoolCrazyBuy.ipa"><input type="button" value="下载IOS"></a></p>-->
                </div>
                <div class="Android_ewm">
                    <img src="<?php echo U('Index/qr_code',array('type'=>2));?>" alt="">
                    <p>Android</p>
                    <!--<p><a href="http://120.25.248.165/axd/Public/app_package/am_0.8.2.24.2.apk"><input type="button" value="下载Android"></a></p>-->
                </div>
            </div>
        </div>
        <!--<div class="temp_ios">
            <img src="/axd/Public/img/1.jpg" alt="">
            &lt;!&ndash;<img src="<?php echo U('Index/qr_code/type/1');?>" alt="">&ndash;&gt;
            <p><a href="http://itunes.apple.com/cn"><input type="button" value="IOS下载"></a></p>
        </div>
        <div class="temp_android">
            &lt;!&ndash;<img src="/axd/Public/img/2.jpg" alt="">&ndash;&gt;
            <img src="<?php echo U('Index/qr_code/type/2');?>" alt="">
            <p><a href="/axd/Public/app_package/Android/axd_0.7.8.10.1.apk"><input type="button" value="Android下载"></a></p>
        </div>-->
    </div>
    <div class="nav">
        <div class="nav_box"> 
            <ul>
                <a href="/axd"><li id="jump_home">首页</li></a>
                <a href="<?php echo U('Merchant/gCatePage',array('f_cate_id'=>1));?>"><li id="jump_god_male">男神</li></a>
                <a href="<?php echo U('Merchant/gCatePage',array('f_cate_id'=>2));?>"><li id="jump_god_female">女神</li></a>
                <a href="<?php echo U('Merchant/gCatePageSysV',array('cate_id'=>1));?>"><li id="jump_couples">情侣专区</li></a>
                <a href="<?php echo U('Merchant/gCatePageSysV',array('cate_id'=>2));?>"><li id="jump_dormitory">宿舍专区</li></a>
                <a href="<?php echo U('Merchant/gCatePageSysV',array('cate_id'=>3));?>"><li id="jump_version">吃货世界</li></a>
                <a href="<?php echo U('Subject/subjectList');?>"><li id="jump_notes">美文美搭</li></a>
                <a href="<?php echo U('Merchant/integralGoods');?>"><li id="jump_integral">积分兑换</li></a>
            </ul>
        </div>
    </div>
</div>
<div id="online_server">
    <a href="tencent://message/?uin=413322514&Site=&Menu=yes">
        <img src="/axd/Public/img/online_server.png" alt="">
    </a>
</div>


<div class="collection_success">
    <p>已成功收藏！</p>
</div>
<div class="collection_failure">
    <p>已取消收藏！</p>
</div>

<script>
    $(function(){
        if(''=='<?php echo ($URL); ?>'){
            $('#click_search_box_g').click(function(){
                if(''==$('#search_go').val()){
                    alert('搜索内容不能为空');
                }else{
                    $('#form_g').submit();
                }
            });
        }else{
            $('#click_search_box_s').click(function(){
                if(''==$('#search_su').val()){
                    alert('搜索内容不能为空');
                }else{
                    $('#form_s').submit();
                }
            });
        }
    });
</script>

</body>
</html>

<div id="my_integral" class="clear">
    <div class="integral_box">
        <div class="integral_content">
            <div class="integral_left">
                <div class="name_box">
                    <?php if(!empty($_SESSION['axd_user']['image'])): ?><img src="/axd<?php echo ($_SESSION['axd_user']['image']); ?>" alt="">
                        <?php else: ?>
                        <img src="/axd/Public/img/default_headicon.png" alt=""><?php endif; ?>
                    <?php if(!empty($_SESSION['axd_user'])): ?><p><?php echo ($_SESSION['axd_user']['nickname']); ?></p>
                        <?php else: ?>
                        <div class="login_i">
                            <p>未登录</p>
                        </div><?php endif; ?>
                </div>
                <div class="integral_num">
                    <p>可用积分</p>
                    <div class="integral_num">
                        <p><?php echo ($user["integral"]); ?> </p>
                    </div>

                </div>
            </div>
            <div class="integral_right">
                <div class="record_box">
                    <div class="record_title">
                        <div class="dui_ico"></div>
                        <p>兑换记录</p>
                    </div>
                    <ul>
                        <?php if(is_array($list)): foreach($list as $key=>$i): ?><li>
                            <div class="record_left">
                                <p class="record_name"><?php echo ($i["note"]); ?></p>
                                <p class="record_time"><?php echo (date('Y年m月d日 H:i:s',$i["time"])); ?></p>
                            </div>
                            <div class="record_right">
                                <?php echo ($i['integral']>0?'+':''); echo ($i["integral"]); ?>
                            </div>
                        </li><?php endforeach; endif; ?>
                    </ul>

                </div>
                <span style="display: block;margin-left: 150px;margin-bottom: 60px;"><?php echo ($page); ?></span>
            </div>
        </div>
    </div>

</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="footer" class="clear">
    <div class="footer_box">
        <p>&copy;2016aixiaoda.com  <?php echo ($pro_name); ?>信息有限公司  电信与信息服务业务经营许可证19023243  粤ICP备289013333</p>
        <p>
            <span><a href="/axd">首页</a></span>
            <span class="shu"></span>
            <span><a href="<?php echo U('Index/business');?>">商务合作</a></span>
            <span class="shu"></span>
            <span><a href="<?php echo U('Index/aboutUs');?>">关于我们</a></span>
            <span class="shu"></span>
            <span class="noshu">电话：010-12121212</span>
        </p>
    </div>
</div>
</body>
</html>

</body>
</html>