$(function(){
    $('#edit_sex').change(function(){
        $.post(MODULE+'/Merchant/getGoodsCate',{'cid':$(this).val()},function(data){
            var str = '';
            $.each(data.cate_list,function(){
                str += '<option value="'+this.g_cate_id+'">'+this.name+'</option>';
            })
            $('#edit_second').html(str);
        });
    });
    $('#edit_second').change(function(){
        $.post(MODULE+'/Merchant/getGoodsCate',{'cid':$(this).val()},function(data){
            var str = '';
            $.each(data.cate_list,function(){
                str += '<option value="'+this.g_cate_id+'">'+this.name+'</option>';
            })
            $('#edit_third').html(str);
        });
    });
})
