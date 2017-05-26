$(function(){

    //筛选变色
    $('#god_male .choose_img li').hover(function(){
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
    $('#god_male .choose_text li').click(function(){
        $(this).addClass('border').siblings().removeClass();
    });


    //宝贝选页浮动居中
    var page_ul = $('.choose_page > ul').width()/2;
    $('.choose_page ul').css('margin-left',-page_ul);


    //第二级添加样式
    $('.choose_text li p:eq(0)').addClass('border');
    $('.choose_text li div:eq(0)').show();
    $('.choose_text li:eq(0) li:eq(0)').find('img').addClass('choose_img');
    $('.choose_text li:eq(0) li:eq(0)').find('span').addClass('color');
    $('.choose_text li p').click(function(){
        $(this).addClass('border').parent().siblings().children('p').removeClass('border');
    });
    //有图片鼠标经过添加样式
    $('.choose_box li').hover(function(){
        $(this).siblings().children('div').children('img').removeClass('add_choose');
        $(this).children('div').children('img').addClass('add_choose');
        $(this).children('span').addClass('choose_color');
        $('.choose_box li').click(function(){
            $('.choose_text li div ul li img').removeClass();
            $('.choose_text li div ul li span').removeClass();
            $(this).children('div').children('img').addClass('choose_img');
            $(this).children('span').addClass('color');
        });
    },function(){
        $(this).children('div').children('img').removeClass('add_choose');
        $(this).children('span').removeClass('choose_color');
    });
    //切换内容
    $('.choose_text li p').click(function(){
        var index = $(this).index();
        $(this).siblings('div').show();
        $(this).parent().siblings().children('div').hide();
    });


});