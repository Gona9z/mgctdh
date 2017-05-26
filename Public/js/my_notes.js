$(function(){
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
            if($(window).scrollTop() > 100){
                jump_show.show();
            }else{
                jump_show.hide();
            }

        });
    }
    jump_top($('.jump_box '),$('.jump_box'));
});