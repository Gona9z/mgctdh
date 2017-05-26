$(function(){
    $('#about .left li').click(function(){
        var index = $(this).index();
        $(this).children('span').addClass('color');
        $(this).children('div').addClass('about_left_ico');
        $(this).siblings().children('span').removeClass('color');
        $(this).siblings().children('div').removeClass('about_left_ico');
        $('#about .right ul').children('li').eq(index).show().siblings().hide();
    });
});