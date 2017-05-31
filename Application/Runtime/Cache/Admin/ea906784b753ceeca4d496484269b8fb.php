<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo ($pro_name); ?>台管理系统</title>
    <link rel="stylesheet" href="/axd/Public/assets/css/share.css" /><!--另添加样式文件-->
    <meta charset="utf-8" />
<meta name="description" content="overview &amp; stats" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- basic styles -->
<link href="/axd/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/axd/Public/assets/css/font-awesome.min.css" />
<!--[if IE 7]>
  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
<![endif]-->
<!-- page specific plugin styles -->
<!-- fonts -->
<!-- ace styles -->
<link rel="stylesheet" href="/axd/Public/assets/css/ace.min.css" />
<link rel="stylesheet" href="/axd/Public/assets/css/ace-rtl.min.css" />
<link rel="stylesheet" href="/axd/Public/assets/css/ace-skins.min.css" />
<!--[if lte IE 8]>
  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
<![endif]-->
<!-- inline styles related to this page -->
<!-- ace settings handler -->
<script src="/axd/Public/assets/js/ace-extra.min.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="assets/js/html5shiv.js"></script>
<script src="assets/js/respond.min.js"></script>
<![endif]-->
	<!--myStyle-->
<link rel="stylesheet" href="/axd/Public/assets/css/style.css" />
<!--[if !IE]> -->
<script src="/axd/Public/assets/js/jquery-2.0.3.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->
<!-- icon -->
<link rel="icon" href="/axd/Public/img/title_icon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/axd/Public/img/title_icon.ico">
<link rel="Bookmark" href="/axd/Public/img/title_icon.ico">
<!-- icon--end -->
<script src="/axd/Public/back_js/mode_show.js"></script>
<!--头部文件-->
    <link href="/axd/Public/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <!--讨论区滚动条begin-->
    <link rel="stylesheet" type="text/css" href="/axd/Public/assets/css/jscrollpane1.css" />
    <!--上传文件-->
    <link href="/axd/Public/assets/plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/axd/Public/back_css/edit_common.css">

    <script src="/axd/Public/back_js/thumb_img.js"></script>
    <script src="/axd/Public/back_js/jquery-form.js"></script>
    <script src="/axd/Public/jedate/jedate.js"></script>
    <script src="/axd/Public/back_js/goods_addEdit.js"></script>
    <style>
        #commodity_main input[type=file]{margin-bottom: 10px;}
        #commodity_main img{width: 150px;height: 150px;}
        #commodity_main textarea{width: 98%;height: 100px;}
    </style>
    <script>
        $(function(){
            jeDate({
                dateCell:"#dateinfo",
                format:"YYYY-MM-DD",
                isinitVal:true,
                isTime:true, //isClear:false,
                minDate:"1950-01-01 00:00:00",
            })
        })
        var MODULE = '/axd/Admin';
    </script>
</head>

<body>
<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-tags"></i>
							<?php echo ($pro_name); ?>后台管理系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/axd/Public/back_img/icon_logo.png" alt="Jason's Photo" style="height: 40px;width: 40px;"/>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo ($_SESSION['axd_admin']['account']); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<!-- <li>
									<a href="newly.php" rel="rs-dialog" data-target="myModal2">
										<i class="icon-cog"></i>
										帐号管理
									</a>
								</li> -->

								<!--<li>
									<a href="#" rel="rs-dialog" data-target="myModal1">
										<i class="icon-user"></i>
										修改密码
									</a>
								</li>

								<li class="divider"></li>-->

								<li>
									<a href="#" rel="rs-dialog" data-target="exitBlock">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
		
<!-- 修改密码对话框 -->
<div class="rs-dialog" id="myModal1">
	<div class="rs-dialog-box">
		<a class="close" href="#">&times;</a>
		<div class="rs-dialog-header">
			<h3>修改密码</h3>
		</div>
		<div class="rs-dialog-body">
			<form class="form-horizontal" role="form">
			  <div class="form-group">
			    <label for="oldpass" class="col-sm-4 control-label">旧密码</label>
			    <div class="col-sm-8">
			    	<input type="password" class="form-control" style="width:250px;" id="oldpass" placeholder="输入旧密码"><span id="oldpassTip" style="display:none;color:red;"></span>
			    </div>
			  </div>
			  
			  <div class="form-group">
			    <label for="newpass" class="col-sm-4 control-label">新密码</label>
			    <div class="col-sm-8">
			    	<input type="password" class="form-control" style="width:250px;" id="newpass" placeholder="输入新密码"><span id="newpassTip" style="display:none;color:red;"></span>
			    </div>
			  </div>
			  
			  <div class="form-group">
			    <label for="newpassAgain" class="col-sm-4 control-label">再次确认新密码</label>
			    <div class="col-sm-8">
			    	<input type="password" class="form-control" style="width:250px;" id="newpassAgain" placeholder="请再次确认密码"><span id="newpassAgainTip" style="display:none;color:red;"></span>
			    </div>
			  </div>
			  
			  <div class="form-group" style="text-align: center;">
			 		<button type="button" class="btn btn-primary" id="submit" style="text-align:center;" onclick="cli_chg_password();">确认修改</button>
			  </div>
			  
			</form>
		</div>
	</div>	
</div>
<!--退出弹框开始-->
<div class="rs-dialog" id="exitBlock">
	<div class="rs-dialog-box">
		<a class="close" href="#" data-dismiss="modal">&times;</a>
		<div class="rs-dialog-header">
			<h3>退出确认</h3>
		</div>
		<div class="rs-dialog-body">
			<form class="form-horizontal" role="form">						
			   <div class="form-group text-center">
			     <label for="Lxphone" class="col-sm-12 col-xs-12 text-center control-label" style="text-align: center;">确定退出当前账号 </label>					   
			  </div> 
			  <br />
			  <br /> 
			  <div class="form-group" style="text-align: center;">
			 		<button type="button" class="btn btn-primary text-center" data-dismiss="modal" id="submit" style="width: 15%; margin:0 20px 0 20px;" onclick="window.location.href='/axd/Admin/Admin/logout'">确定</button>
			 		<button type="button" class="btn btn-primary text-center" data-dismiss="modal" id="submit" style="width: 15%;">取消</button>
			  </div>
			</form>
		</div>
	</div>	
</div>	<!--退出弹框结束-->
<div class="main-container" id="main-container">
    	<div class="main-container-inner">
		<a class="menu-toggler" id="menu-toggler" href="#">
			<span class="menu-text"></span>
		</a>

		<div class="sidebar" id="sidebar">
			<script type="text/javascript">
				try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts">

				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success"></span>

					<span class="btn btn-info"></span>

					<span class="btn btn-warning"></span>

					<span class="btn btn-danger"></span>
				</div>
			</div><!-- #sidebar-shortcuts -->

			<ul class="nav nav-list">
				<li>
					<a href="/axd/Admin/Index/welp">
						<i class="icon-dashboard"></i>
						<span class="menu-text"> 欢迎页 </span>
					</a>
				</li>

				<li class="glygl">
					<a href="" class="dropdown-toggle">
						<i class="icon-group"></i>
						<span class="menu-text"> 管理员管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show wqbz">
						<?php if(in_array(14,session('role_pri'))) { ?>
						<li class="glyjslb">
						<a href="<?php echo U('Admin/Admin/adminRoleList');?>">
							<i class="menu-icon fa fa-caret-right"></i>
							管理员角色列表
						</a>
						<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(15,session('role_pri'))) { ?>
						<li class="glylb">
						<a href="<?php echo U('Admin/Admin/adminUserList');?>">
							<i class="menu-icon fa fa-caret-right"></i>
							管理员列表
						</a>
						<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="dlgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-github-alt"></i>
						<span class="menu-text"> 代理管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show pfdt">
						<?php if(in_array(16,session('role_pri'))) { ?>
						<li class="dllb">
							<a href="<?php echo U('Admin/Agent/agentList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								代理列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(17,session('role_pri'))) { ?>
						<li class="dldd">
							<a href="<?php echo U('Admin/Agent/agentOrderList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								代理订单
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="hygl">
					<a href="" class="dropdown-toggle">
						<i class="icon-user"></i>
						<span class="menu-text"> 会员管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show pfdt">
						<!--===========-->
						<?php if(in_array(18,session('role_pri'))) { ?>
						<li class="hylb">
							<a href="<?php echo U('Admin/User/userList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								会员列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(19,session('role_pri'))) { ?>
						<li class="xxlb">
							<a href="<?php echo U('Admin/User/schoolList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								学校列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="gggl">
					<a href="" class="dropdown-toggle">
						<i class="icon-inbox"></i>
						<span class="menu-text"> 公共管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show fzsb">
						<!--===========-->
						<?php if(in_array(20,session('role_pri'))) { ?>
						<li class="rmsslb">
							<a href="<?php echo U('Admin/Index/hotKeyword');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								热门搜索列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(21,session('role_pri'))) { ?>
						<li class="kdlb">
							<a href="<?php echo U('Admin/Index/expressList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								快递列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(22,session('role_pri'))) { ?>
						<li class="qdylb">
							<a href="<?php echo U('Admin/Index/startPageList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								启动页列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="spgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-truck"></i>
						<span class="menu-text"> 商品管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show flyz">
						<!--===========-->
						<?php if(in_array(23,session('role_pri'))) { ?>
						<li class="spfllb">
							<a href="<?php echo U('Admin/Merchant/goodsCate',array('sex'=>1));?>">
								<i class="menu-icon fa fa-caret-right"></i>
								商品分类列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(24,session('role_pri'))) { ?>
						<li class="splb">
							<a href="<?php echo U('Admin/Merchant/goodsList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								商品列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(25,session('role_pri'))) { ?>
						<li class="tkllb">
							<a href="<?php echo U('Admin/Index/taoCommandList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								淘口令列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="wzgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-copy"></i>
						<span class="menu-text"> 文章管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(26,session('role_pri'))) { ?>
						<li class="wzfllb">
							<a href="<?php echo U('Admin/Subject/subjectCate');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								文章分类列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(27,session('role_pri'))) { ?>
						<li class="wzlb">
							<a href="<?php echo U('Admin/Subject/subjectList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								文章列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="adgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-exclamation-sign"></i>
						<span class="menu-text"> 广告管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(28,session('role_pri'))) { ?>
						<li class="gglb">
							<a href="<?php echo U('Admin/Ad/adList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								广告列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="dpgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-random"></i>
						<span class="menu-text"> 搭配管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(29,session('role_pri'))) { ?>
						<li class="dpfllb">
							<a href="<?php echo U('Admin/Collocation/collocationCate');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								搭配分类列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(30,session('role_pri'))) { ?>
						<li class="dplb">
							<a href="<?php echo U('Admin/Collocation/collocationList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								搭配列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="xqgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-home"></i>
						<span class="menu-text"> 校趣管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(31,session('role_pri'))) { ?>
						<li class="xqfllb">
							<a href="<?php echo U('Admin/Interact/interactCate');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								校趣分类列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(32,session('role_pri'))) { ?>
						<li class="xqtzlb">
							<a href="<?php echo U('Admin/Interact/interactList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								校趣帖子列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="plgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-file-alt"></i>
						<span class="menu-text"> 评论管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(33,session('role_pri'))) { ?>
						<li class="wzpl">
							<a href="<?php echo U('Admin/Subject/subjectComment');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								文章评论
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(34,session('role_pri'))) { ?>
						<li class="sppl">
							<a href="<?php echo U('Admin/Merchant/goodsComment');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								商品评论
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(35,session('role_pri'))) { ?>
						<li class="xqpl">
							<a href="<?php echo U('Admin/Interact/interactComment');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								校趣评论
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(36,session('role_pri'))) { ?>
						<li class="dppl">
							<a href="<?php echo U('Admin/Collocation/collocationComment');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								搭配评论
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="jfgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-shopping-cart"></i>
						<span class="menu-text"> 积分管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(37,session('role_pri'))) { ?>
						<li class="jfsplb">
							<a href="<?php echo U('Admin/Integral/iGoodsList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								积分商品列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(38,session('role_pri'))) { ?>
						<li class="dhddlb">
							<a href="<?php echo U('Admin/Integral/iOrderList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								兑换订单列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(39,session('role_pri'))) { ?>
						<li class="tbddlb">
							<a href="<?php echo U('Admin/Merchant/tbOrder');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								淘宝订单列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<!--<li class="">
							<a href="<?php echo U('Banner/HomeBanner');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								拿快递
							</a>
							<b class="arrow"></b>
						</li>-->
					</ul>
				</li>

				<li class="xtsz">
					<a href="" class="dropdown-toggle">
						<i class="icon-cogs"></i>
						<span class="menu-text"> 系统设置 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(40,session('role_pri'))) { ?>
						<li class="tsxxlb">
							<a href="<?php echo U('Admin/System/pushList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								推送消息列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(41,session('role_pri'))) { ?>
						<li class="yjfklb">
							<a href="<?php echo U('Admin/System/feedList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								意见反馈列表
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(42,session('role_pri'))) { ?>
						<li class="fwxy">
							<a href="<?php echo U('Admin/System/serviceAgreement');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								服务协议
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(43,session('role_pri'))) { ?>
						<li class="kfrx">
							<a href="<?php echo U('Admin/System/customerPhone');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								客服热线
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(44,session('role_pri'))) { ?>
						<li class="bbgx">
							<a href="<?php echo U('Admin/System/versionManage');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								版本更新
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>

				<li class="pcgl">
					<a href="" class="dropdown-toggle">
						<i class="icon-desktop"></i>
						<span class="menu-text"> PC管理 </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<ul class="submenu nav-show stgl">
						<!--===========-->
						<?php if(in_array(45,session('role_pri'))) { ?>
						<li class="pcdsj">
							<a href="<?php echo U('Admin/Index/eventList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								PC大事件
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
						<?php if(in_array(46,session('role_pri'))) { ?>
						<li class="pchzcs">
							<a href="<?php echo U('Admin/Index/partnerList');?>">
								<i class="menu-icon fa fa-caret-right"></i>
								PC合作厂商
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
						<!--===========-->
					</ul>
				</li>
			</ul><!-- nav-list -->

			<!-- <div class="sidebar-collapse" id="sidebar-collapse">
				<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
			</div> -->

			<script type="text/javascript">
				try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
			</script>
		</div>


	</div><!-- /.main-container-inner -->

	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="icon-double-angle-up icon-only bigger-110"></i>
	</a>
<!--左侧导航栏-->
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">首页</a>
                </li>
                <li class="active">搭配管理</li>
                <li class="active">搭配列表</li>
                <li class="active">添加搭配商品</li>
            </ul><!-- .breadcrumb -->
        </div>

        <div id="commodity_details">
            <h1><img src="/axd/Public/back_img/ico.png"><?php if(empty($_GET['id'])): ?>添加<?php else: ?>修改<?php endif; ?>搭配商品
                <a href="javascript:history.go(-1);"><span><img src="/axd/Public/back_img/return.png"></span></a></h1>
            <div id="commodity_list">
                <!--通用信息_开始-->
                <form action="/axd/Admin/Collocation/addCollocationGoodsPage" method="post" id="goods_form" enctype="multipart/form-data" >

                    <div id="commodity_main" class="clear">
                        <table>
                            <input type="hidden" value="<?php echo ($index_x); ?>" name="index_x">
                            <input type="hidden" value="<?php echo ($index_y); ?>" name="index_y">
                            <tr>
                                <th>所属分类：</th>
                                <td>
                                    <select name="sex" id="edit_sex">
                                        <option value="1">男神</option>
                                        <option value="2">女神</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>商品类别：</th>
                                <td>
                                    <select id="edit_second">
                                        <?php if(is_array($second_list)): foreach($second_list as $key=>$s): ?><option value="<?php echo ($s["g_cate_id"]); ?>"><?php echo ($s["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    <select id="edit_third" name="g_cate_id">
                                        <?php if(is_array($third_list)): foreach($third_list as $key=>$t): ?><option value="<?php echo ($t["g_cate_id"]); ?>"><?php echo ($t["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>商品名称</th>
                                <td><input type="text" name="name"></td>
                            </tr>
                            <tr>
                                <th>商品图片：</th>
                                <td>
                                    <img src="" id="to_img">
                                    <input type="file" id="form_file" onchange="getImageFormat('form_file','to_img');" name="form_file"/>
                                </td>
                            </tr>
                            <tr>
                                <th>价格：</th>
                                <td><input type="text" name="price"></td>
                            </tr>
                            <tr>
                                <th>淘宝链接：</th>
                                <td><input type="text" name="tb_link"></td>
                            </tr>
                            <tr>
                                <th>有效日期：</th>
                                <td>
                                    <input type="text" readonly="true" id="dateinfo" name="end_time">
                                </td>
                            </tr>
                            <tr>
                                <th>文字介绍</th>
                                <td>
                                    <textarea name="text_content"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>收藏数：</th>
                                <td><input type="text" value="0" name="collect_count"></td>
                            </tr>
                            <tr>
                                <th>评论数：</th>
                                <td><input type="text" value="0" name="comment_count"></td>
                            </tr>
                        </table>
                    </div>
                    <input id="li1_btn" type="button" value="保存"/>
                </form>
                <!--通用信息_结束-->
            </div>
        </div>
    </div><!-- /.main-content -->
</div><!--main-container-->

<!-- basic scripts -->
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
		<script src="/axd/Public/assets/js/bootstrap.min.js"></script>
		<script src="/axd/Public/assets/js/typeahead-bs2.min.js"></script>
		<!-- page specific plugin scripts -->
		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="/axd/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/axd/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/axd/Public/assets/js/jquery.slimscroll.min.js"></script>
		<script src="/axd/Public/assets/js/jquery.easy-pie-chart.min.js"></script>
		<script src="/axd/Public/assets/js/jquery.sparkline.min.js"></script>
		<!-- ace scripts -->
		<script src="/axd/Public/assets/js/ace-elements.min.js"></script>
		<script src="/axd/Public/assets/js/ace.min.js"></script>
		<!-- inline scripts related to this page -->
		<!--弹出层开始-->
		<script>
			$(document).ready(function($){
				$('body').append('<div class="rs-overlay" />');
				$("a[rel='rs-dialog']").each(function(){
					var trigger 	= $(this);
					var rs_dialog 	= $('#' + trigger.data('target'));
					var rs_box 		= rs_dialog.find('.rs-dialog-box');
					var rs_close 	= rs_dialog.find('.close');
					var rs_overlay 	= $('.rs-overlay');
					if( !rs_dialog.length ) return true;
			
					// Open dialog
					trigger.click(function(){
						//Get the scrollbar width and avoid content being pushed
						var w1 = $(window).width();
						$('html').addClass('dialog-open');
						var w2 = $(window).width();
						c = w2-w1 + parseFloat($('body').css('padding-right'));
						if( c > 0 ) $('body').css('padding-right', c + 'px' );
			
						rs_overlay.fadeIn('fast');
						rs_dialog.show( 'fast', function(){
							rs_dialog.addClass('in');
						});	
						return false;
					});
			
					// Close dialog when clicking on the close button
					rs_close.click(function(e){			
						rs_dialog.removeClass('in').delay(150).queue(function(){
							rs_dialog.hide().dequeue();	
							rs_overlay.fadeOut('slow');
							$('html').removeClass('dialog-open');
							$('body').css('padding-right', '');		
						});
						return false;
					});
			
					// Close dialog when clicking outside the dialog
					rs_dialog.click(function(e){
						rs_close.trigger('click');		
					});
					rs_box.click(function(e){
						e.stopPropagation();
					});		
				});
			});
		</script>
		<!--弹出层结束-->



</body>

<script>
    $(".dpgl").addClass("active open");
    $(".dpgl .dplb").addClass("active");
    $('#li1_btn').click(function(){
        $('#goods_form').ajaxSubmit({
            url:"/axd/Admin/Collocation/addCollocationGoodsPage",
            dataType: "json",
            beforeSend: function() {
                $('#li1_btn').attr('disabled','true');
                $('#li1_btn').attr('value','上传中...');
            },
            type: "post",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            success : function(data){
                alert(data.msg);
                if(0==data.errorCode){
                    location.href = document.referrer;
                }else{
                    $('#li1_btn').removeAttr('disabled');
                    $('#li1_btn').attr('value','保存');
                }
            }
        });
    });
</script>
</html>