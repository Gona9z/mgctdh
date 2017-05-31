<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($pro_name); ?></title>
    <meta name="keywords" content="<?php echo ($pro_name); ?>,学校,青春,购物,APP,安卓android,苹果iphone">
    <link rel="stylesheet" href="/axd/Public/css/unified.css">
    <link rel="stylesheet" href="/axd/Public/css/about.css">
    <script src="/axd/Public/js/jquery-1.12.4.js"></script>
    <script src="/axd/Public/js/unified.js"></script>
    <script src="/axd/Public/js/about.js"></script>


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
                <a href="<?php echo U('Index/index');?>"><li id="jump_home">首页</li></a>
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

<div id="about" class="clear">
    <div class="about_box">
        <div class="left">
            <h3>关于我们</h3>
            <ul>
                <li>
                    <span class="color">校疯购简介</span>
                    <div class="about_left_ico"></div>
                </li>
                <li>
                    <span>创始人简介</span>
                    <div></div>
                </li>
                <li>
                    <span>企业文化</span>
                    <div></div>
                </li>
                <li>
                    <span>大事记</span>
                    <div></div>
                </li>
                <li>
                    <span>合作伙伴</span>
                    <div></div>
                </li>
                <li>
                    <span>法律声明</span>
                    <div></div>
                </li>
            </ul>
        </div>
        <div class="right">
            <ul>
                <li>
                    <div class="right_box">
                        <div class="banner">
                            <img src="/axd/Public/img/banner1.png" alt="">
                        </div>
                        <div class="introduce">
                            <div class="in_title">
                                <span>校疯购简介</span>
                            </div>
                            <div class="in_content">
                                <p>你的青春，有我就“购”了！校疯购是中国校园最受欢迎的服装搭配的电商平台，礼物说致力于为用户提供最全的礼物品类以及最多的送礼场景参考，打造最时尚的全新礼物购买体验。</p>
                                <p>我们有着 100 多位礼物达人精心挑选的 10000 多份完美礼物选择，每天有 1000 多万人在上面为朋友、自己、家人挑选着合适的礼物。</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="hide">
                    <div class="b_left">
                        <img src="/axd/Public/img/about_csr.png" alt="">
                    </div>
                    <div class="b_right">
                        <div class="in_title">
                            <span>创始人简介</span>
                        </div>
                        <div class="in_content">
                            <p>你的青春，有我就“购”了！校疯购是中国校园最受欢迎的服装搭配的电商平台，礼物说致力于为用户提供最全的礼物品类以及最多的送礼场景参考，打造最时尚的全新礼物购买体验。</p>
                            <p>我们有着 100 多位礼物达人精心挑选的 10000 多份完美礼物选择，每天有 1000 多万人在上面为朋友、自己、家人挑选着合适的礼物。</p>
                        </div>
                    </div>
                </li>
                <li class="hide">
                    <div class="c_left">
                        <img src="/axd/Public/img/about_qywh.png" alt="">
                    </div>
                    <div class="c_right">
                        <div class="in_title">
                            <span>企业文化</span>
                        </div>
                        <ul>
                            <li>
                                <h3> 使命 Mission</h3>
                                <p> 让送礼物变得更愉快</p>
                            </li>
                            <li>
                                <h3>愿景 Vision</h3>
                                <p> 成为最懂你的宝贝平台</p>
                            </li>
                            <li>
                                <h3>价值观 Value</h3>
                                <p> 诚信 . 年轻 . 创新 . 客户至上</p>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="hide">
                    <div class="d_content">
                        <div class="in_title">
                            <span>大事件</span>
                        </div>
                        <div class="in_content">
                            <ul>
                                <?php if(is_array($event_list)): foreach($event_list as $key=>$e): ?><li>
                                    <p><strong><?php echo (date('Y-m-d',$e["time"])); ?></strong></p>
                                    <p><?php echo ($e["content"]); ?></p>
                                </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="hide">
                    <div class="e_content">
                        <div class="in_title">
                            <span>合作伙伴</span>
                        </div>
                        <div class="in_content">
                            <ul>
                                <?php if(is_array($partner_list)): foreach($partner_list as $key=>$p): ?><a href="<?php echo ($p["link"]); ?>" target="_blank">
                                    <li>
                                        <img src="/axd<?php echo ($p["image"]); ?>" alt="<?php echo ($p["name"]); ?>">
                                    </li>
                                </a><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="hide">
                    <div class="f_content">
                        <div class="in_title">
                            <span>法律声明</span>
                        </div>
                        <div class="in_content">
                            <p>你的青春，有我就“购”了！校疯购是中国校园最受欢迎的服装搭配的电商平台，礼物说致力于为用户提供最全的礼物品类以及最多的送礼场景参考，打造最时尚的全新礼物购买体验。</p>
                            <p>我们有着 100 多位礼物达人精心挑选的 10000 多份完美礼物选择，每天有 1000 多万人在上面为朋友、自己、家人挑选着合适的礼物。</p>
                            <p>你的青春，有我就“购”了！校疯购是中国校园最受欢迎的服装搭配的电商平台，礼物说致力于为用户提供最全的礼物品类以及最多的送礼场景参考，打造最时尚的全新礼物购买体验。</p>
                            <p>我们有着 100 多位礼物达人精心挑选的 10000 多份完美礼物选择，每天有 1000 多万人在上面为朋友、自己、家人挑选着合适的礼物。</p>
                        </div>
                    </div>

                </li>
            </ul>

        </div>
    </div>
</div>

<div style="margin-bottom: 500px;clear: both;"></div>

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