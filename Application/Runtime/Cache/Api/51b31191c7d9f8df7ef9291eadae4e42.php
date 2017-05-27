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
    <strong style="color: green;"> 1.发送短信验证码/mgctdh/Api/User/sendVCode</strong><br/>
    <form action="/mgctdh/Api/User/sendVCode" method="post">
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
    <strong style="color:green;"> 2.检查短信验证码/mgctdh/Api/User/checkVCode</strong><br/>
    <form action="/mgctdh/Api/User/checkVCode" method="post">
        phone：<input type="text" name="phone" value=""/>
        v_code:<input type="text" name="v_code" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 3.注册/mgctdh/Api/User/registUser</strong><br/>
    <form action="/mgctdh/Api/User/registUser" method="post">
        phone：<input type="text" name="phone" value=""/>
        password:<input type="text" name="password" value=""/>
        openid:<input type="text" name="openid" value=""/>
        image_url:<input type="text" name="image_url" value=""/>
        nickname:<input type="text" name="nickname" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 4.登录/mgctdh/Api/User/loginUser</strong><br/>
    <form action="/mgctdh/Api/User/loginUser" method="post">
        phone：<input type="text" name="phone" value=""/>
        password:<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 5.获取启动页/mgctdh/Api/Index/getStartPage</strong><br/>
    <form action="/mgctdh/Api/Index/getStartPage" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 6.编辑用户资料/mgctdh/Api/User/editUserInfo</strong><br/>
    <form action="/mgctdh/Api/User/editUserInfo" method="post">
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
    <strong style="color:green;"> 7.获取学校列表/mgctdh/Api/User/getSchoolList</strong><br/>
    <form action="/mgctdh/Api/User/getSchoolList" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 8.签到/mgctdh/Api/User/userSign</strong><br/>
    <form action="/mgctdh/Api/User/userSign" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 9.获取积分商品列表/mgctdh/Api/Goods/getIntegralGoods</strong><br/>
    <form action="/mgctdh/Api/Goods/getIntegralGoods" method="post">
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 10.兑换积分商品/mgctdh/Api/User/exchangeGoods</strong><br/>
    <form action="/mgctdh/Api/User/exchangeGoods" method="post">
        i_goods_id：<input type="text" name="i_goods_id" value=""/>
        accesstoken：<input type="text" name="accesstoken" value=""/>
        name：<input type="text" name="name" value=""/>
        link_phone：<input type="text" name="link_phone" value=""/>
        address：<input type="text" name="address" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 11.首页-banner/mgctdh/Api/Index/homeBanner</strong><br/>
    <form action="/mgctdh/Api/Index/homeBanner" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 12.获取专题分类/mgctdh/Api/Subject/getSubjectCate</strong><br/>
    <form action="/mgctdh/Api/Subject/getSubjectCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 13.根据专题根类获取美文/mgctdh/Api/Subject/getSubjectList</strong><br/>
    <form action="/mgctdh/Api/Subject/getSubjectList" method="post">
        s_cate_id：<input type="text" name="s_cate_id" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 14.获取美文详情/mgctdh/Api/Subject/getSubjectDetail</strong><br/>
    <form action="/mgctdh/Api/Subject/getSubjectDetail" method="post">
        subject_id：<input type="text" name="subject_id" value=""/>
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 15.美文收藏/取消收藏/mgctdh/Api/Subject/collectSubject</strong><br/>
    <form action="/mgctdh/Api/Subject/collectSubject" method="post">
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
    <strong style="color: green;"> 17.美文评论/mgctdh/Api/Subject/subjectComment</strong><br/>
    <form action="/mgctdh/Api/Subject/subjectComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        subject_id：<input type="text" name="subject_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 18.获取美文评论列表/mgctdh/Api/Subject/getSubjectComment</strong><br/>
    <form action="/mgctdh/Api/Subject/getSubjectComment" method="post">
        page：<input type="text" name="page" value="1"/>
        subject_id：<input type="text" name="subject_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 19.首页搜素/mgctdh/Api/Index/searchGoodsSubject</strong><br/>
    <form action="/mgctdh/Api/Index/searchGoodsSubject" method="post">
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
    <strong style="color:green;"> 20.获取商品分类/mgctdh/Api/Goods/getGoodsCate</strong><br/>
    <form action="/mgctdh/Api/Goods/getGoodsCate" method="post">
        g_cate_id：<input type="text" name="g_cate_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 21.获取商品列表/mgctdh/Api/Goods/getGoodsList</strong><br/>
    <form action="/mgctdh/Api/Goods/getGoodsList" method="post">
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
    <strong style="color: green"> 23.获取校趣分类/mgctdh/Api/School/getSchoolCate</strong><br/>
    <form action="/mgctdh/Api/School/getSchoolCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 24.School-获取校趣帖子/mgctdh/Api/School/getInteractList</strong><br/>
    <form action="/mgctdh/Api/School/getInteractList" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        type：<input type="text" name="type" value=""/>
        type_id：<input type="text" name="type_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 25.School-帖子点赞/取消点赞/mgctdh/Api/School/praiseInteract</strong><br/>
    <form action="/mgctdh/Api/School/praiseInteract" method="post">
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
    <strong style="color: green"> 26.School-帖子评论/mgctdh/Api/School/interactComment</strong><br/>
    <form action="/mgctdh/Api/School/interactComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        interact_id：<input type="text" name="interact_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 28.School-帖子评论列表/mgctdh/Api/School/getInteractComment</strong><br/>
    <form action="/mgctdh/Api/School/getInteractComment" method="post">
        page：<input type="text" name="page" value="1"/>
        interact_id：<input type="text" name="interact_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 31.我的-获取个人信息/mgctdh/Api/User/getUserInfo</strong><br/>
    <form action="/mgctdh/Api/User/getUserInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 32.修改密码/mgctdh/Api/User/editPassword</strong><br/>
    <form action="/mgctdh/Api/User/editPassword" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        o_password：<input type="text" name="o_password" value=""/>
        n_password：<input type="text" name="n_password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 33.获取积分订单/mgctdh/Api/User/getInteractOrder</strong><br/>
    <form action="/mgctdh/Api/User/getInteractOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 34.获取积分记录列表/mgctdh/Api/User/getIntegralList</strong><br/>
    <form action="/mgctdh/Api/User/getIntegralList" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 35.获取我的收藏-美文/mgctdh/Api/Subject/getSubjectCollect</strong><br/>
    <form action="/mgctdh/Api/Subject/getSubjectCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 36.获取我的收藏-宝贝/mgctdh/Api/Goods/getGoodsCollect</strong><br/>
    <form action="/mgctdh/Api/Goods/getGoodsCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 40.意见反馈/mgctdh/Api/User/feedback</strong><br/>
    <form action="/mgctdh/Api/User/feedback" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong> 42.检查更新/mgctdh/Api/User/userSign</strong><br/>
    <form action="/mgctdh/Api/User/userSign" method="post">
        uid：<input type="text" name="uid" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 44.获取本月签到历史/mgctdh/Api/User/getMonthSign</strong><br/>
    <form action="/mgctdh/Api/User/getMonthSign" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 45.忘记密码/mgctdh/Api/User/forgetPassword</strong><br/>
    <form action="/mgctdh/Api/User/forgetPassword" method="post">
        phone：<input type="text" name="phone" value=""/>
        password：<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 46.商品评论/mgctdh/Api/Goods/goodsComment</strong><br/>
    <form action="/mgctdh/Api/Goods/goodsComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        good_id：<input type="text" name="good_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 47.获取商品评论列表/mgctdh/Api/Goods/getGoodsComment</strong><br/>
    <form action="/mgctdh/Api/Goods/getGoodsComment" method="post">
        page：<input type="text" name="page" value="1"/>
        good_id：<input type="text" name="good_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 48.商品收藏/取消收藏/mgctdh/Api/Goods/collectGoods</strong><br/>
    <form action="/mgctdh/Api/Goods/collectGoods" method="post">
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
    <strong style="color: green;"> 49.第三方登录/mgctdh/Api/User/openLogin</strong><br/>
    <form action="/mgctdh/Api/User/openLogin" method="post">
        openid：<input type="text" name="openid" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 52.添加分享记录/mgctdh/Api/User/addShare</strong><br/>
    <form action="/mgctdh/Api/User/addShare" method="post">
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
    <strong> 53.获取分享记录/mgctdh/Api/User/getShareRecord</strong><br/>
    <form action="/mgctdh/Api/User/getShareRecord" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        type：<input type="text" name="type" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 54.删除分享记录/mgctdh/Api/User/delShareRecord</strong><br/>
    <form action="/mgctdh/Api/User/delShareRecord" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        record_id：<input type="text" name="record_id" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 56.获取基本信息/mgctdh/Api/User/getInfo</strong><br/>
    <form action="/mgctdh/Api/User/getInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 58.热门关键字/mgctdh/Api/Index/hotKeyword</strong><br/>
    <form action="/mgctdh/Api/Index/hotKeyword" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 59.获取快递列表/mgctdh/Api/Index/expressList</strong><br/>
    <form action="/mgctdh/Api/Index/expressList" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 60.获取服务协议/mgctdh/Api/Index/getService</strong><br/>
    <form action="/mgctdh/Api/Index/getService" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 61.添加淘宝订单/mgctdh/Api/User/addTBOrder</strong><br/>
    <form action="/mgctdh/Api/User/addTBOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        tb_order：<input type="text" name="tb_order" value=""/>
        goods_id：<input type="text" name="goods_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 62.检查订单是否存在/mgctdh/Api/User/checkOrderExist</strong><br/>
    <form action="/mgctdh/Api/User/checkOrderExist" method="post">
        order：<input type="text" name="order" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 63.添加代拿快递记录/mgctdh/Api/User/addOrderDaina</strong><br/>
    <form action="/mgctdh/Api/User/addOrderDaina" method="post">
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
    <strong style="color: green;"> 64.获取帖子详情/mgctdh/Api/School/interactDetail</strong><br/>
    <form action="/mgctdh/Api/School/interactDetail" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        interact_id：<input type="text" name="interact_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 65.获取搭配分类/mgctdh/Api/Collocation/collocationCate</strong><br/>
    <form action="/mgctdh/Api/Collocation/collocationCate" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 66.获取搭配列表/mgctdh/Api/Collocation/collocationList</strong><br/>
    <form action="/mgctdh/Api/Collocation/collocationList" method="post">
        page：<input type="text" name="page" value="1"/>
        c_cate_id：<input type="text" name="c_cate_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 67.搭配收藏/取消收藏/mgctdh/Api/Collocation/collectCollocation</strong><br/>
    <form action="/mgctdh/Api/Collocation/collectCollocation" method="post">
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
    <strong style="color: green;"> 68.搭配详情/mgctdh/Api/Collocation/collocationDetail</strong><br/>
    <form action="/mgctdh/Api/Collocation/collocationDetail" method="post">
        collocation_id：<input type="text" name="collocation_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 69.获取我的收藏-搭配/mgctdh/Api/Collocation/getCollocationCollect</strong><br/>
    <form action="/mgctdh/Api/Collocation/getCollocationCollect" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        page：<input type="text" name="page" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 70.提交淘口令/mgctdh/Api/Index/submitTaoCommand</strong><br/>
    <form action="/mgctdh/Api/Index/submitTaoCommand" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        tao_command：<input type="text" name="tao_command" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 71.商品详情/mgctdh/Api/Goods/goodsDetail</strong><br/>
    <form action="/mgctdh/Api/Goods/goodsDetail" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        goods_id：<input type="text" name="goods_id" value="1"/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 72.评论搭配/mgctdh/Api/Collocation/collocationComment</strong><br/>
    <form action="/mgctdh/Api/Collocation/collocationComment" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        collocation_id：<input type="text" name="collocation_id" value=""/>
        content：<input type="text" name="content" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green"> 73.搭配评论列表/mgctdh/Api/Collocation/getCollocationComment</strong><br/>
    <form action="/mgctdh/Api/Collocation/getCollocationComment" method="post">
        page：<input type="text" name="page" value="1"/>
        collocation_id：<input type="text" name="collocation_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 74.代理登录/mgctdh/Api/Agent/loginAgent</strong><br/>
    <form action="/mgctdh/Api/Agent/loginAgent" method="post">
        account：<input type="text" name="account" value=""/>
        password:<input type="text" name="password" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 75.代理-获取订单/mgctdh/Api/Agent/agentOrder</strong><br/>
    <form action="/mgctdh/Api/Agent/agentOrder" method="post">
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
    <strong style="color:green;"> 76.获取客服热线/mgctdh/Api/Index/customerPhone</strong><br/>
    <form action="/mgctdh/Api/Index/customerPhone" method="post">
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color: green;"> 77.获取版本号/mgctdh/Api/Index/checkVersion</strong><br/>
    <form action="/mgctdh/Api/Index/checkVersion" method="post">
        type(类型)：
        <select name="type">
            <option value="1">1:iOS</option>
            <option value="2">2:Android</option>
        </select>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 78.获取快递员信息/mgctdh/Api/Agent/getAgentInfo</strong><br/>
    <form action="/mgctdh/Api/Agent/getAgentInfo" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 79.确认收货/mgctdh/Api/User/confirmAgentOrder</strong><br/>
    <form action="/mgctdh/Api/User/confirmAgentOrder" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        a_order_id：<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 80.获取我的订单/mgctdh/Api/User/myAgentOrder</strong><br/>
    <form action="/mgctdh/Api/User/myAgentOrder" method="post">
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
    <strong style="color:green;"> 81.确认发货/mgctdh/Api/Agent/sendGoods</strong><br/>
    <form action="/mgctdh/Api/Agent/sendGoods" method="post">
        agent_accesstoken：<input type="text" name="agent_accesstoken" value=""/>
        a_order_id:<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 82.自己拿快递/mgctdh/Api/User/aOrderByMyself</strong><br/>
    <form action="/mgctdh/Api/User/aOrderByMyself" method="post">
        accesstoken：<input type="text" name="accesstoken" value=""/>
        a_order_id:<input type="text" name="a_order_id" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
    <strong style="color:green;"> 83.代理信息/mgctdh/Api/Agent/agentInfo</strong><br/>
    <form action="/mgctdh/Api/Agent/agentInfo" method="post">
        agent_accesstoken：<input type="text" name="agent_accesstoken" value=""/>
        <input type="submit" value="提交">
    </form>
    <br/>
    <!-- ================================================================== -->
</body>
</html>