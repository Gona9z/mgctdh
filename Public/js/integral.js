$(function(){
    //宝贝选页浮动居中
    var page_ul = $('.choose_page > ul').width()/2;
    $('.choose_page ul').css('margin-left',-page_ul);

    $('#couples .praise p').click(function(){
        var pathName=window.document.location.pathname;
        var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
        // console.log(projectName);
        $.ajax({
            type: "GET",
            url: projectName+"/User/checkIsLogin?"+Math.random(),
            success: function(data){
                // var result = eval(data);
                // var status = result.status;
                var status = data.status;
                if(status){
                    $('#maskLayer').show();
                    $('#information').show();
                }else{
                    $('#maskLayer').show();
                    $('#login').show();
                    $("#maskLayer").height(pageHeight());
                }
            }
        });
    });
    $('#information .share_fork').click(function(){
        $('#maskLayer').hide();
        $('#information').hide();
    });



   $('.baby_details ul li .praise').click(function(){
       var jifen = $(this).prev().children('span').html();
       var name = $(this).parent().prev().children().children('p').html();
       var a_id = $(this).parent().parent().attr('data-i_gid');
       $('.t_info p:eq(0)').text(name);
       $('.t_info p:eq(1)').text(jifen);
       $('.t_info input:eq(0)').attr('value',a_id);
   });





});