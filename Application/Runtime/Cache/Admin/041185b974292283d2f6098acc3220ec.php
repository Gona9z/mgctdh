<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- HTML5 shim 0and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->


    <title><?php echo ($pro_name); ?>后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/axd/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/axd/Public/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->
    <!-- page specific plugin styles -->

    <link rel="stylesheet" href="/axd/Public/assets/css/jquery-ui-1.10.3.full.min.css" />
    <link rel="stylesheet" href="/axd/Public/assets/css/datepicker.css" />
    <link rel="stylesheet" href="/axd/Public/assets/css/ui.jqgrid.css" />

    <!-- ace styles -->

    <link rel="stylesheet" href="/axd/Public/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/axd/Public/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/axd/Public/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="/axd/Public/assets/js/jquery-2.0.3.min.js"></script>
    <script src="/axd/Public/assets/js/ace-extra.min.js"></script>
    <!-- <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/axd/Public/back_js/jquery-form.js"></script>
</head>

<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div>
                <div class="login-container">
                    <div class="center">
                        <h2>
                            <i><img alt="" src="/axd/Public/back_img/logo.png" style="height: 30px;"></i>
                            <span class="white"><?php echo ($pro_name); ?>后台管理系统</span>
                        </h2>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="icon-flag blue"></i>
                                        输入信息
                                    </h4>

                                    <div class="space-6"></div>

                                    <form method="post" action="###" id="login_form">
                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <input type="text" class="form-control" name="account" placeholder="用户名" />
                                                <i class="icon-user"></i>
                                            </span>
                                        </label>

                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <input type="password" class="form-control" name="password" placeholder="密码" />
                                                <i class="icon-lock"></i>
                                            </span>
                                        </label>

                                        <div class="space"></div>

                                        <div class="clearfix">
                                            <label class="inline">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl">记住密码</span>
                                            </label>
                                            <button type="button" class="width-35 pull-right btn btn-sm btn-primary" style="margin-top: 15px;" id="login_button">
                                                <i class="icon-key"></i>
                                                登陆
                                            </button>
                                        </div>
                                    </form>

                                </div><!-- /widget-main -->

                                <div class="toolbar clearfix">
                                    <div>
                                        <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                            <i class="icon-arrow-left"></i>
                                            忘记密码
                                        </a>
                                    </div>
                                </div>

                            </div><!-- /widget-body -->
                        </div><!-- /login-box -->

                        <div id="forgot-box" class="forgot-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="icon-key"></i>
                                        找回密码
                                    </h4>

                                    <div class="space-6"></div>
                                    <p>
                                        输入你注册的手机号码
                                    </p>

                                    <form>
                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <input type="email" class="form-control" placeholder="手机" id="find_phone"/>
                                                <i class="icon-envelope"></i>
                                            </span>
                                        </label>

                                        <div class="clearfix">
                                            <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                <i class="icon-lightbulb"></i>
                                                发送
                                            </button>
                                        </div>
                                    </form>
                                </div><!-- /widget-main -->

                                <div class="toolbar center">
                                    <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                        返回登陆
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /widget-body -->
                        </div><!-- /forgot-box -->

                    </div><!-- /position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<!-- <![endif]-->
<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#'+id).addClass('visible');
    }
</script>

<script type="text/javascript">
    $("#login_button").click(function(){
        $.ajax({
            type: 'POST',
            url: "<?php echo U('Admin/Admin/adminLogin');?>",
            data: $('#login_form').serialize(),
            dataType: "json",
            success: function(data) {
                var result = eval(data);
                alert(result.msg);
                if (result.errorCode == 0) {
                    location.href = "<?php echo U('Admin/Index/welp');?>";
                }
            }
        });
    });
</script>
</body>
</html>