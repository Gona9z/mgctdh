$(function(){

    //筛选变色
    $('#dormitory .choose_img li').hover(function(){
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
    $('#dormitory .choose_text li').click(function(){
        $(this).addClass('border').siblings().removeClass();
    });


    //宝贝选页浮动居中
    var page_ul = $('.choose_page > ul').width()/2;
    $('.choose_page ul').css('margin-left',-page_ul);



});