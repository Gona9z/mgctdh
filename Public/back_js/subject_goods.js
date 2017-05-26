$(function(){
    changFirst(1);

    //一级变化
    $('#edit_sex').change(function(){
        changFirst($(this).val());
    });
    function changFirst(id){
        $.post('/axd/Admin/Goods/getGoodsCate',{'cid':id},function(data){
            var str = '';
            $.each(data.cate_list,function(){
                str += '<option value="'+this.g_cate_id+'">'+this.name+'</option>';
            })
            $('#edit_second').html(str);
            changeSecond($('#edit_second').val());
        });
    }
    //二级变化
    $('#edit_second').change(function(){
        changeSecond($(this).val());
    });
    function changeSecond(id){
        $.post('/axd/Admin/Goods/getGoodsCate',{'cid':id},function(data){
            var str = '';
            $.each(data.cate_list,function(){
                str += '<option value="'+this.g_cate_id+'">'+this.name+'</option>';
            })
            $('#edit_third').html(str);
            changeThird($('#edit_third').val());
        });
    }
    //三级变化-填充商品
    $('#edit_third').change(function(){
        changeThird($(this).val());
    });
    function changeThird(id){
        $.post('/axd/Admin/Goods/getGoodsByCate',{'gc_id':id},function(data){
            var str = '';
            $.each(data.g_list,function(){
                str += '<option value="'+this.goods_id+'">ID:'+this.goods_id;
                str += ' 名称:'+this.name+'</option>';
            })
            $('#goods_list_v').html(str);
        });
    }
})
