$(function(){


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

    //宝贝选页浮动居中
    var page_ul = $('.choose_page > ul').width()/2;
    $('.choose_page ul').css('margin-left',-page_ul);
});