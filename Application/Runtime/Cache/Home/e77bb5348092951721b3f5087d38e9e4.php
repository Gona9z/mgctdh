<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($pro_name); ?></title>
    <meta name="keywords" content="<?php echo ($pro_name); ?>,学校,青春,购物,APP,安卓android,苹果iphone">
    <link rel="stylesheet" href="/axd/Public/css/unified.css">
    <link rel="stylesheet" href="/axd/Public/css/notes_details.css">
    <script src="/axd/Public/js/jquery-1.12.4.js"></script>
    <script src="/axd/Public/js/unified.js"></script>
    <script src="/axd/Public/js/notes_details.js"></script>
</head>
<html xmlns:wb="http://open.weibo.com/wb">
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
<body>
<script>
    $(function(){
        $('wb_s').click(function(){
            alert(2);
        });
    });
</script>
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
            <?php if(empty($URL)): ?><form action="<?php echo U('Goods/searchGoods');?>" method="post" id="form_g">
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
                <a href="<?php echo U('Goods/gCatePage',array('f_cate_id'=>1));?>"><li id="jump_god_male">男神</li></a>
                <a href="<?php echo U('Goods/gCatePage',array('f_cate_id'=>2));?>"><li id="jump_god_female">女神</li></a>
                <a href="<?php echo U('Goods/gCatePageSysV',array('cate_id'=>1));?>"><li id="jump_couples">情侣专区</li></a>
                <a href="<?php echo U('Goods/gCatePageSysV',array('cate_id'=>2));?>"><li id="jump_dormitory">宿舍专区</li></a>
                <a href="<?php echo U('Goods/gCatePageSysV',array('cate_id'=>3));?>"><li id="jump_version">吃货世界</li></a>
                <a href="<?php echo U('Subject/subjectList');?>"><li id="jump_notes">美文美搭</li></a>
                <a href="<?php echo U('Goods/integralGoods');?>"><li id="jump_integral">积分兑换</li></a>
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

<div id="details_content" class="clear">
    <input type="hidden" value="<?php echo ($sid); ?>" id="sid">
    <div class="details_box">
        <div class="title">
            <div class="title_img">
                <div class="mask"></div>
                <img src="/axd<?php echo ($subject["image_content"]); ?>" alt="">
                <p><?php echo ($subject["name"]); ?></p>
                <!--<div class="take_big">
                    <img src="/axd<?php echo ($subject["logo_image"]); ?>" alt="">
                </div>-->
            </div>

        <div class="s_c_c">
                <div class="title_left">
                    <ul>
                        <li>
                            <div class="share_big"></div>
                            <span id="share_co"><?php echo ($subject["share_count"]); ?></span>
                        </li>
                        <li class="collection">
                            <?php if($is_coll == 1): ?><div class="collection_heart_big"></div>
                                <?php else: ?>
                              <div class="collection_big"></div><?php endif; ?>
                            <span id="coll_co"><?php echo ($subject["collect_count"]); ?></span>
                        </li>
                        <li>
                            <div class="comment_big"></div>
                            <span id="cm1"><?php echo ($subject["comment_count"]); ?></span>
                        </li>
                    </ul>
                </div>
                <div class="title_right">
                    <ul>
                        <li>分享到</li>
                        <a class="jiathis_button_weixin" class="share_add_click">
                        <li><img src="/axd/Public/img/wx_big.png" alt=""></li>
                        </a>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
                        <a class="share_add_click" href="http://service.weibo.com/share/share.php?url=<?php echo ($url); ?>/Subject/subjectDetail/sid/<?php echo ($subject['subject_id']); ?>&type=icon&language=zh_cn&appkey=1494721552&title=<?php echo ($subject['text_content']); ?>&searchPic=true&style=simple" target="_blank">
                        <li><img src="/axd/Public/img/wb_big.png" alt=""></li>
                        </a>
                        <!--<wb:share-button appkey="1494721552" addition="simple" searchPic="true"
                             type="icon" default_text="<?php echo ($subject["text_content"]); ?>">
                        </wb:share-button>-->
                        <a class="share_add_click" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo ($url); ?>/Subject/subjectDetail/sid/<?php echo ($subject['subject_id']); ?>&pics=&title=分享到QQ空间&summary=<?php echo ($subject['text_content']); ?>" target="_blank">
                        <li><img src="/axd/Public/img/qqkj_big.png" alt=""></li>
                        </a>
                        <a class="share_add_click"
                           href="http://connect.qq.com/widget/shareqq/index.html?url=<?php echo ($url); ?>/Subject/subjectDetail/sid/<?php echo ($subject['subject_id']); ?>&desc=&title=<?php echo ($subject['text_content']); ?>&pics=&flash=&site=" target="_blank">
                            <li><img src="/axd/Public/img/qq_big.png" alt=""></li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="notes_info"><?php echo ($subject["text_content"]); ?></div>
        <?php if(is_array($goods_list)): foreach($goods_list as $key=>$g): ?><div class="content_box">
            <div class="content">
                <p><?php echo ($g["text_content"]); ?></p>
            </div>
            <div class="content_details">
                <div class="content_img">
                    <img src="/axd<?php echo ($g["image"]); ?>" alt="">
                    <div class="content_bottom">
                        <div class="content_price">
                            <span>￥<?php echo ($g["price"]); ?></span>
                        </div>
                        <!--<div class="content_praise">
                            <div class="praise_ico"></div>
                            <span><?php echo ($g["collect_count"]); ?></span>
                        </div>-->
                        <div class="content_btn">
                            <a href="<?php echo ($g["tb_link"]); ?>" target="_blank"><p>查看详情</p></a>
                        </div>
                    </div>

                </div>
            </div>
        </div><?php endforeach; endif; ?>

        <div class="comments_box">
            <div class="comments_title">
                <div class="comments_ico"></div>
                <p>评论（<span id="cm2"><?php echo ($subject["comment_count"]); ?></span>）</p>
            </div>
            <ul id="comment_ul">
            </ul>
        </div>

        <div class="choose_page" id="page_info">
        </div>


    </div>
    <div class="textarea">
        <textarea placeholder="请输入您的评论" id="content"></textarea>
        <input class="text_btn" type="button" value="提交评论" onclick="submitComment();">
    </div>

</div>
<div class="jump_top">
    <div class="jump_box">
        <img src="/axd/Public/img/jump_top.png" alt="">
    </div>
</div>
<script>
    $(function(){
        var sid = $('#sid').val();
        getSubjectComment(sid,1);

        $('.collection').click(function(){
            var pathName=window.document.location.pathname;
            var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
            $.ajax({
                type: "GET",
                url: projectName+"/User/checkIsLogin?"+Math.random(),
                success: function(data){
                    var result = eval(data);
                    var status = result.status;
                    console.log(status);
                    if(status){
                        if($('.collection').children('div').hasClass('collection_big')){
                            $.post("<?php echo U('Subject/collectSubject');?>",{'sid':sid,'type':0},function(data){
                                if(0==data.errorCode){
                                    $('.collection').children('div').attr('class','collection_heart_big');
                                    $('#coll_co').html(parseInt($('#coll_co').html())+1);
                                }
                            });
                        }else{
                            $.post("<?php echo U('Subject/collectSubject');?>",{'sid':sid,'type':1},function(data){
                                if(0==data.errorCode){
                                    $('.collection').children('div').attr('class','collection_big');
                                    $('#coll_co').html(parseInt($('#coll_co').html())-1);
                                }
                            });
                        }
                    }else{
                        $('#maskLayer').show();
                        $('#login').show();
                        $("#maskLayer").height(pageHeight());
                    }
                }
            });

        });

        $('.share_add_click').click(function(){
            $.post("<?php echo U('Subject/addSubjectShare');?>",{'sid':sid},function(data){
                if(0==data.errorCode){
                    $('#share_co').html(parseInt($('#share_co').html())+1);
                }
            });
        });

    });
    function getSubjectComment(sid,page){
        var str = '';
        $.post("<?php echo U('Subject/subjectComment');?>",{'sid':sid,'page':page,'methodName':'getSubjectComment'},function(data){
            $.each(data.comment_list,function(){
                str += '<li><div class="comments_content"><div class="comments_name">';
                if(this.image==null){
                    str += '<img src="/axd/Public/img/default_headicon.png" alt="">';
                }else{
//                    str += '<img src="/axd'+this.image+'" alt="">';
                    var img_url = this.image;
                    var img_url = img_url.replace("/Public/uploads/","/axd/Public/uploads/");
                    str += '<img src="'+img_url+'" >';

                }
                str += '<span>'+this.nickname+'</span><div class="comments_time"><p>'+this.time+'</p></div></div>';
                str += '<p>'+this.content+'</p></div></li>';
            });
            $('#comment_ul').html(str);
            $('#page_info').html(data.page_info);
        });
    }
    function submitComment(){
        var pathName=window.document.location.pathname;
        var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
        $.ajax({
            type: "GET",
            url: projectName+"/User/checkIsLogin?"+Math.random(),
            success: function(data){
                var result = eval(data);
                var status = result.status;
                console.log(status);
                if(status){
                    var sid = $('#sid').val();
                    var content = $('#content').val().trim();
                    $.post('/axd/Home/Subject/commentSubject',{'sid':sid,'content':content},function(data){
                        alert(data.msg);
                        if(0==data.errorCode){
                            str = '<li><div class="comments_content"><div class="comments_name">';
                            if('<?php echo ($_SESSION['axd_user']['image']); ?>'==''){
                                str += '<img src="/axd/Public/img/default_headicon.png">';
                            }else{
                                var img_url = '<?php echo ($_SESSION['axd_user']['image']); ?>';
                                var img_url = img_url.replace("/Public/uploads/","/axd/Public/uploads/");
                                str += '<img src="'+img_url+'">';
                            }
                            str += '<span><?php echo ($_SESSION['axd_user']['nickname']); ?></span><div class="comments_time"><p>刚刚</p></div></div>';
                            str += '<p>'+content+'</p></div></li>';
                            $('#comment_ul').prepend(str);
                            $('#cm1').html(parseInt($('#cm1').html())+1);
                            $('#cm2').html(parseInt($('#cm2').html())+1);
                        }
                    });
                }else{
                    $('#maskLayer').show();
                    $('#login').show();
                    $("#maskLayer").height(pageHeight());
                }
            }
        });
    }
</script>
<script>

    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */

</script>
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