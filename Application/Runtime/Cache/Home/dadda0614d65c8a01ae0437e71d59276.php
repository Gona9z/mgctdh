<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>接口测试页面</title>
</head>
<style>
    form input{
        width: 80px;
    }
</style>
<body>
    <h1>接口测试</h1>
    <strong style="color: green;"> 1.发送短信验证码/axd/Api/User/sendVCode</strong><br/>
    <form action="/axd/Api/User/sendVCode" method="post">
        phone：<input type="text" name="phone" value=""/>
        type:
        <select name="type">
            <option value="0">0:注册</option>
            <option value="1">1:找回密码</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 2.检查短信验证码/axd/Api/User/checkVCode</strong><br/>
    <form action="/axd/Api/User/checkVCode" method="post">
        phone：<input type="text" name="phone" value=""/>
        v_code:<input type="text" name="v_code" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 3.注册/axd/Api/User/registUser</strong><br/>
    <form action="/axd/Api/User/registUser" method="post">
        phone：<input type="text" name="phone" value=""/>
        password:<input type="text" name="password" value=""/>
        openid:<input type="text" name="openid" value=""/>
        image_url:<input type="text" name="image_url" value=""/>
        nickname:<input type="text" name="nickname" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 4.登录/axd/Api/User/loginUser</strong><br/>
    <form action="/axd/Api/User/loginUser" method="post">
        phone：<input type="text" name="phone" value=""/>
        password:<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 5.获取启动页/axd/Api/Index/getStartPage</strong><br/>
    <form action="/axd/Api/Index/getStartPage" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 6.编辑用户资料/axd/Api/User/editUserInfo</strong><br/>
    <form action="/axd/Api/User/editUserInfo" method="post">
        phone：<input type="text" name="phone" value=""/>
        nickname:<input type="text" name="nickname" value=""/>
        sex:<input type="text" name="sex" value=""/>
        birthday:<input type="text" name="birthday" value=""/>
        single:<input type="text" name="single" value=""/>
        school_id:<input type="text" name="school_id" value=""/>
        image:<input type="text" name="image" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 7.获取学校列表/axd/Api/User/getSchoolList</strong><br/>
    <form action="/axd/Api/User/getSchoolList" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 8.签到/axd/Api/User/userSign</strong><br/>
    <form action="/axd/Api/User/userSign" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 9.获取积分商品列表/axd/Api/Goods/getIntegralGoods</strong><br/>
    <form action="/axd/Api/Goods/getIntegralGoods" method="post">
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 10.兑换积分商品/axd/Api/User/exchangeGoods</strong><br/>
    <form action="/axd/Api/User/exchangeGoods" method="post">
        i_goods_id：<input type="text" name="i_goods_id" value=""/>
        accesstoken：<input type="text" name="accesstoken" value=""/>
        name：<input type="text" name="name" value=""/>
        link_phone：<input type="text" name="link_phone" value=""/>
        address：<input type="text" name="address" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 11.首页-banner/axd/Api/Index/homeBanner</strong><br/>
    <form action="/axd/Api/Index/homeBanner" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 12.获取专题分类/axd/Api/Subject/getSubjectCate</strong><br/>
    <form action="/axd/Api/Subject/getSubjectCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 13.根据专题根类获取美文/axd/Api/Subject/getSubjectList</strong><br/>
    <form action="/axd/Api/Subject/getSubjectList" method="post">
        s_cate_id：<input type="text" name="s_cate_id" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 14.获取美文详情/axd/Api/Subject/getSubjectDetail</strong><br/>
    <form action="/axd/Api/Subject/getSubjectDetail" method="post">
        subject_id：<input type="text" name="subject_id" value=""/>
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 15.美文收藏/取消收藏/axd/Api/Subject/collectSubject</strong><br/>
    <form action="/axd/Api/Subject/collectSubject" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        subject_id：<input type="text" name="subject_id" value=""/>
        type：
        <select name="type">
            <option value="0">收藏</option>
            <option value="1">取消收藏</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 17.美文评论/axd/Api/Subject/subjectComment</strong><br/>
    <form action="/axd/Api/Subject/subjectComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        subject_id：<input type="text" name="subject_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 18.获取美文评论列表/axd/Api/Subject/getSubjectComment</strong><br/>
    <form action="/axd/Api/Subject/getSubjectComment" method="post">
        page：<input type="text" name="page" value="1"/>
        subject_id：<input type="text" name="subject_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 19.首页搜素/axd/Api/Index/searchGoodsSubject</strong><br/>
    <form action="/axd/Api/Index/searchGoodsSubject" method="post">
        page：<input type="text" name="page" value="1"/>
        keyword：<input type="text" name="keyword" value=""/>
        type:
        <select name="type">
            <option value="1">美文</option>
            <option value="2">商品</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 20.获取商品分类/axd/Api/Goods/getGoodsCate</strong><br/>
    <form action="/axd/Api/Goods/getGoodsCate" method="post">
        g_cate_id：<input type="text" name="g_cate_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 21.获取商品列表/axd/Api/Goods/getGoodsList</strong><br/>
    <form action="/axd/Api/Goods/getGoodsList" method="post">
        sex：<input type="text" name="sex" value=""/>
        g_cate_id：<input type="text" name="g_cate_id" value=""/>
        page：<input type="text" name="page" value="1"/>
        keyword：<input type="text" name="keyword" value=""/>
        order_type：
        <select name="order_type">
            <option value="1">默认</option>
            <option value="2">热度</option>
            <option value="3">价格:升序</option>
            <option value="4">价格:降序</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 23.获取校趣分类/axd/Api/School/getSchoolCate</strong><br/>
    <form action="/axd/Api/School/getSchoolCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 24.School-获取校趣帖子/axd/Api/School/getInteractList</strong><br/>
    <form action="/axd/Api/School/getInteractList" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        type：<input type="text" name="type" value=""/>
        type_id：<input type="text" name="type_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 25.School-帖子点赞/取消点赞/axd/Api/School/praiseInteract</strong><br/>
    <form action="/axd/Api/School/praiseInteract" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        interact_id：<input type="text" name="interact_id" value=""/>
        type：
        <select name="type">
            <option value="0">点赞</option>
            <option value="1">取消点赞</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 26.School-帖子评论/axd/Api/School/interactComment</strong><br/>
    <form action="/axd/Api/School/interactComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        interact_id：<input type="text" name="interact_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 28.School-帖子评论列表/axd/Api/School/getInteractComment</strong><br/>
    <form action="/axd/Api/School/getInteractComment" method="post">
        page：<input type="text" name="page" value="1"/>
        interact_id：<input type="text" name="interact_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 31.我的-获取个人信息/axd/Api/User/getUserInfo</strong><br/>
    <form action="/axd/Api/User/getUserInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 32.修改密码/axd/Api/User/editPassword</strong><br/>
    <form action="/axd/Api/User/editPassword" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        o_password：<input type="text" name="o_password" value=""/>
        n_password：<input type="text" name="n_password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 33.获取积分订单/axd/Api/User/getInteractOrder</strong><br/>
    <form action="/axd/Api/User/getInteractOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 34.获取积分记录列表/axd/Api/User/getIntegralList</strong><br/>
    <form action="/axd/Api/User/getIntegralList" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 35.获取我的收藏-美文/axd/Api/Subject/getSubjectCollect</strong><br/>
    <form action="/axd/Api/Subject/getSubjectCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 36.获取我的收藏-宝贝/axd/Api/Goods/getGoodsCollect</strong><br/>
    <form action="/axd/Api/Goods/getGoodsCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 40.意见反馈/axd/Api/User/feedback</strong><br/>
    <form action="/axd/Api/User/feedback" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong> 42.检查更新/axd/Api/User/userSign</strong><br/>
    <form action="/axd/Api/User/userSign" method="post">
        uid：<input type="text" name="uid" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 44.获取本月签到历史/axd/Api/User/getMonthSign</strong><br/>
    <form action="/axd/Api/User/getMonthSign" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 45.忘记密码/axd/Api/User/forgetPassword</strong><br/>
    <form action="/axd/Api/User/forgetPassword" method="post">
        phone：<input type="text" name="phone" value=""/>
        password：<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 46.商品评论/axd/Api/Goods/goodsComment</strong><br/>
    <form action="/axd/Api/Goods/goodsComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        good_id：<input type="text" name="good_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 47.获取商品评论列表/axd/Api/Goods/getGoodsComment</strong><br/>
    <form action="/axd/Api/Goods/getGoodsComment" method="post">
        page：<input type="text" name="page" value="1"/>
        good_id：<input type="text" name="good_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 48.商品收藏/取消收藏/axd/Api/Goods/collectGoods</strong><br/>
    <form action="/axd/Api/Goods/collectGoods" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        good_id：<input type="text" name="good_id" value=""/>
        type：
        <select name="type">
            <option value="0">收藏</option>
            <option value="1">取消收藏</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 49.第三方登录/axd/Api/User/openLogin</strong><br/>
    <form action="/axd/Api/User/openLogin" method="post">
        openid：<input type="text" name="openid" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 52.添加分享记录/axd/Api/User/addShare</strong><br/>
    <form action="/axd/Api/User/addShare" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        type：
        <select name="type">
            <option value="1">1：商品</option>
            <option value="2">2：美文</option>
            <option value="3">3：搭配</option>
        </select>
        id：<input type="text" name="id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong> 53.获取分享记录/axd/Api/User/getShareRecord</strong><br/>
    <form action="/axd/Api/User/getShareRecord" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        type：<input type="text" name="type" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 54.删除分享记录/axd/Api/User/delShareRecord</strong><br/>
    <form action="/axd/Api/User/delShareRecord" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        record_id：<input type="text" name="record_id" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 56.获取基本信息/axd/Api/User/getInfo</strong><br/>
    <form action="/axd/Api/User/getInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 58.热门关键字/axd/Api/Index/hotKeyword</strong><br/>
    <form action="/axd/Api/Index/hotKeyword" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 59.获取快递列表/axd/Api/Index/expressList</strong><br/>
    <form action="/axd/Api/Index/expressList" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 60.获取服务协议/axd/Api/Index/getService</strong><br/>
    <form action="/axd/Api/Index/getService" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 61.添加淘宝订单/axd/Api/User/addTBOrder</strong><br/>
    <form action="/axd/Api/User/addTBOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        tb_order：<input type="text" name="tb_order" value=""/>
        goods_id：<input type="text" name="goods_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 62.检查订单是否存在/axd/Api/User/checkOrderExist</strong><br/>
    <form action="/axd/Api/User/checkOrderExist" method="post">
        order：<input type="text" name="order" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 63.添加代拿快递记录/axd/Api/User/addOrderDaina</strong><br/>
    <form action="/axd/Api/User/addOrderDaina" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        username：<input type="text" name="username" value=""/>
        phone：<input type="text" name="phone" value=""/>
        s_phone：<input type="text" name="s_phone" value=""/>
        school_id：<input type="text" name="school_id" value=""/>
        room_num：<input type="text" name="room_num" value=""/>
        express_address：<input type="text" name="express_address" value=""/>
        send_time：
        <select name="send_time">
            <option value="0">0:  18:00-22:00</option>
            <option value="1">1:  12:00-13:30</option>
        </select>
        note：<input type="text" name="note" value=""/>
        order：<input type="text" name="order" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 64.获取帖子详情/axd/Api/School/interactDetail</strong><br/>
    <form action="/axd/Api/School/interactDetail" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        interact_id：<input type="text" name="interact_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 65.获取搭配分类/axd/Api/Collocation/collocationCate</strong><br/>
    <form action="/axd/Api/Collocation/collocationCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 66.获取搭配列表/axd/Api/Collocation/collocationList</strong><br/>
    <form action="/axd/Api/Collocation/collocationList" method="post">
        page：<input type="text" name="page" value="1"/>
        c_cate_id：<input type="text" name="c_cate_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 67.搭配收藏/取消收藏/axd/Api/Collocation/collectCollocation</strong><br/>
    <form action="/axd/Api/Collocation/collectCollocation" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        collocation_id：<input type="text" name="collocation_id" value=""/>
        type：
        <select name="type">
            <option value="0">收藏</option>
            <option value="1">取消收藏</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 68.搭配详情/axd/Api/Collocation/collocationDetail</strong><br/>
    <form action="/axd/Api/Collocation/collocationDetail" method="post">
        collocation_id：<input type="text" name="collocation_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 69.获取我的收藏-搭配/axd/Api/Collocation/getCollocationCollect</strong><br/>
    <form action="/axd/Api/Collocation/getCollocationCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 70.提交淘口令/axd/Api/Index/submitTaoCommand</strong><br/>
    <form action="/axd/Api/Index/submitTaoCommand" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        tao_command：<input type="text" name="tao_command" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 71.商品详情/axd/Api/Goods/goodsDetail</strong><br/>
    <form action="/axd/Api/Goods/goodsDetail" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        goods_id：<input type="text" name="goods_id" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 72.评论搭配/axd/Api/Collocation/collocationComment</strong><br/>
    <form action="/axd/Api/Collocation/collocationComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        collocation_id：<input type="text" name="collocation_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 73.搭配评论列表/axd/Api/Collocation/getCollocationComment</strong><br/>
    <form action="/axd/Api/Collocation/getCollocationComment" method="post">
        page：<input type="text" name="page" value="1"/>
        collocation_id：<input type="text" name="collocation_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 74.代理登录/axd/Api/Agent/loginAgent</strong><br/>
    <form action="/axd/Api/Agent/loginAgent" method="post">
        account：<input type="text" name="account" value=""/>
        password:<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 75.代理-获取订单/axd/Api/Agent/agentOrder</strong><br/>
    <form action="/axd/Api/Agent/agentOrder" method="post">
        agent_accesstoken：<input type="text" name="agent_accesstoken" value=""/>
        page:<input type="text" name="page" value="1"/>
        type:
        <select name="type">
            <option value="0">0:待处理</option>
            <option value="1">1:配送中</option>
            <option value="2">2:已完成</option>
            <option value="3">3:全部</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 76.获取客服热线/axd/Api/Index/customerPhone</strong><br/>
    <form action="/axd/Api/Index/customerPhone" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 77.获取版本号/axd/Api/Index/checkVersion</strong><br/>
    <form action="/axd/Api/Index/checkVersion" method="post">
        type(类型)：
        <select name="type">
            <option value="1">1:iOS</option>
            <option value="2">2:Android</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 78.获取快递员信息/axd/Api/Agent/getAgentInfo</strong><br/>
    <form action="/axd/Api/Agent/getAgentInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 79.确认收货/axd/Api/User/confirmAgentOrder</strong><br/>
    <form action="/axd/Api/User/confirmAgentOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        a_order_id：<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 80.获取我的订单/axd/Api/User/myAgentOrder</strong><br/>
    <form action="/axd/Api/User/myAgentOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page:<input type="text" name="page" value="1"/>
        type:
        <select name="type">
            <option value="0">0:待处理</option>
            <option value="1">1:配送中</option>
            <option value="2">2:已完成</option>
            <option value="3">3:全部</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 81.确认发货/axd/Api/Agent/sendGoods</strong><br/>
    <form action="/axd/Api/Agent/sendGoods" method="post">
        agent_accesstoken：<input type="text" name="agent_accesstoken" value=""/>
        a_order_id:<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 82.自己拿快递/axd/Api/User/aOrderByMyself</strong><br/>
    <form action="/axd/Api/User/aOrderByMyself" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        a_order_id:<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 83.代理信息/axd/Api/Agent/agentInfo</strong><br/>
    <form action="/axd/Api/Agent/agentInfo" method="post">
        agent_accesstoken：<input type="text" name="agent_accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
</body>
</html>