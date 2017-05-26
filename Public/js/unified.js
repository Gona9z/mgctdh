$(function(){
    //使ie兼容placeholder
    $(function(){
        if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur();
        };
    })
    function placeholderSupport() {
        return 'placeholder' in document.createElement('input');
    }



    //鼠标进入放大招
    function top_show(r,show){
        r.hover(function(){
            show.stop(true,false).slideDown(500);
        },function(){
            show.stop(true,false).slideUp(500);
        });
    }

    top_show($('.app_ewm'),$('.ewm'));
    top_show($('.login_box'),$('.head_background'));


    //获取当前页面高度
    function pageHeight() {
        return document.body.scrollHeight;
    }
    $("#maskLayer").height(pageHeight());
    //窗口改变，遮罩层自适应
    $(window).resize(function(){
        $("#maskLayer").height(pageHeight());
    });

    //点击登录弹出登录框
    $('#top_nav .login').click(function(){
        $('#maskLayer').show();
        $('#login').show();
        $("#maskLayer").height(pageHeight());
    });
    $('#login .fork').click(function(){
        $('#maskLayer').hide();
        $('#login').hide();
    });

    //社区生活-登录框弹出
    $('.login_i').click(function(){
        $('#maskLayer').show();
        $('#login').show();
        $("#maskLayer").height(pageHeight());
    });
    //商品相关-登录框弹出
    $('.login_g').click(function(){
        $('#maskLayer').show();
        $('#login').show();
        $("#maskLayer").height(pageHeight());
    });
   /* $('.collection > a').click(function(){
        if($('.collection').hasClass('heart')){
            $('.collection').removeClass('heart');
        }else{
            $('.collection').addClass('heart');
            $('.collection_success').show();
            setTimeout(function(){
                $('.collection_success').hide();
            },1000);
        }
    });*/



    //宝贝选页浮动居中
    var page_div = $('.choose_page > div').width()/2;
    $('.choose_page div').css('margin-left',-page_div);

    $(document).ready(function () {
        $('.nav_box ul a').each(function () {
            if ($($(this))[0].href == String(window.location)){
                $(this).children().addClass('selected').attr('href', 'javascript:void(0);');
            }
        });
    })


    $('.choose_text > li').click(function(){
        var index = $(this).index();
        $(".choose_show_box .choose_show").eq(index).show().siblings().hide();
    })









//分享
//     $('.share > a').click(function(){
//         $('#maskLayer').show();
//         $('#share').show();
//         $("#maskLayer").height(pageHeight());
//     });
//     $('#share .fork').click(function(){
//         $('#maskLayer').hide();
//         $('#share').hide();
//     });


    //收藏
    $('.collection a').click(function(){
        var pathName=window.document.location.pathname;
        var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
        var this_obj = $(this);
        var subject_id = $(this).parent().parent().parent().attr('data-sid');
        var type = $(this).children('div').hasClass('collection_heart_ico')?1:0;
        $.ajax({
            type: "GET",
            url: projectName+"/User/checkIsLogin?"+Math.random(),
            success: function(data){
                // console.log(data);
                // var result = eval(data);
                // var status = result.status;
                var status = data.status;
                if(status){
                    $.post(projectName+'/Subject/collectSubject',{'sid':subject_id,'type':type},function(data){
                        if(this_obj.children('div').hasClass('collection_heart_ico')){
                            this_obj.children('div').attr('class','collection_ico');
                            $('.collection_failure').show();
                            setTimeout(function(){
                                $('.collection_failure').hide();
                            },1000);
                        }else{
                            this_obj.children('div').attr('class','collection_heart_ico');
                            $('.collection_success').show();
                            setTimeout(function(){
                                $('.collection_success').hide();
                            },1000);
                        }
                    });
                }else{
                    $('#maskLayer').show();
                    $('#login').show();
                    $("#maskLayer").height(pageHeight());
                }
            }
        });
    });









})