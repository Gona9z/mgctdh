$(function(){
    $('#edit_sex').change(function(){
        $.post(MODULE+'/Goods/getGoodsCate',{'cid':$(this).val()},function(data){
            var str = '';
            $.each(data.cate_list,function(){
                str += '<option value="'+this.g_cate_id+'">'+this.name+'</option>';
            })
            $('#edit_second').html(str);
        });
    });

    $('.class_ab').change(function(){
        if($(this).val()== 2){
            $('.class_b_b').hide();
        }else{
            $('.class_b_b').show();
        }
    });

});