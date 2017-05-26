$(function(){

    //筛选变色
    $('#couples .choose_img li').hover(function(){
        $(this).children('p').addClass('hover_color');
        $(this).children('div').addClass('hover_border');
        $(this).click(function(){
            $(this).children('p').addClass('color').siblings('div').addClass('border');
            $(this).siblings().children('p').removeClass('color').siblings('div').removeClass('border');
        });
    },function(){
        $(this).children('p').removeClass('hover_color');
        $(this).children('div').removeClass('hover_border');
    });
    $('#couples .choose_text li').click(function(){
        $(this).addClass('border').siblings().removeClass();
    });


    //宝贝选页浮动居中
    var page_ul = $('.choose_page > ul').width()/2;
    $('.choose_page ul').css('margin-left',-page_ul);


    //第二级添加样式
    $('.choose_img li span:eq(0)').addClass('color');
    $('.choose_img li img:eq(0)').addClass('border');
    $('.choose_img li').hover(function(){
        $(this).children().children('img').addClass('border_hover');
        $(this).children('span').addClass('color_hover');
    },function(){
        $(this).children().children('img').removeClass('border_hover');
        $(this).children('span').removeClass('color_hover');
    });
    $('.choose_img li').click(function(){
        $(this).siblings().children().children('img').removeClass('border');
        $(this).siblings().children('span').removeClass('color');
        $(this).children().children('img').addClass('border');
        $(this).children('span').addClass('color');

    });



});