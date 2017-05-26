$(function(){



    //首页轮播图
    var index = 0;
    var li_num = $('.sliding_box .sliding li').length;
    var li_width = $('.sliding_box .sliding li').width();
    var ul_width = li_width*li_num;
    var margin_left_shu = $('.shu_num').width()/2;
    $('.shu_num').css('margin-left',-margin_left_shu);
    $('.sliding').css('width',ul_width);
    $('.shu_num > li').each(function(){
        $(this).mousemove(function(){
            index = $(this).index();
            var left_mobile = li_width * index;
            $('#banner .sliding').stop(true,false).animate({left:-left_mobile});
            $(this).addClass('selected').siblings().removeClass('selected');
        });
    });
    setInterval(function(){
        index++
        if(index > li_num-1){
            index = 0;
        }
        var left_mobile = li_width * index;
        $('#banner .sliding').stop(true,false).animate({left:-left_mobile});
        $('.shu_num li:eq('+index+')').addClass('selected').siblings().removeClass('selected');
    },3000);

    //跳转到页面顶部，位置的判断
    if($(window).width() < 1280){
        $('.jump_top').css('right','0');
    }else{
        $('.jump_top').css('left','50%');
    }
    $(window).resize(function(){
        if($(window).width() < 1280){
            $('.jump_top').css('right','0');
        }else{
            $('.jump_top').css('left','50%');
        }
    });
    //回到顶部，没有超出500px隐藏图标
    function jump_top(jump_click,jump_show){
        jump_click.click(function () {
            $("html,body").animate({scrollTop:0});//回到顶端
            return false;
        });

        $(window).scroll(function(){
            if($(window).scrollTop() > 500){
                jump_show.show();
            }else{
                jump_show.hide();
            }

        });
    }
    jump_top($('.jump_box '),$('.jump_box'));





});