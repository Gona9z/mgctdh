$(function(){
    //管理员管理
    if(null==$('.glyjslb').val() && null==$('.glylb').val()){
        $('.glygl').hide();
    }
    //代理管理
    if(null==$('.dllb').val() && null==$('.dldd').val()){
        $('.dlgl').hide();
    }
    //会员管理
    if(null==$('.hylb').val() && null==$('.xxlb').val()){
        $('.hygl').hide();
    }
    //公共管理
    if(null==$('.glyjslb').val() && null==$('.kdlb').val() && null==$('.qdylb').val()){
        $('.gggl').hide();
    }
    //商品管理
    if(null==$('.spfllb').val() && null==$('.splb').val() && null==$('.tkllb').val()){
        $('.spgl').hide();
    }
    //文章管理
    if(null==$('.wzfllb').val() && null==$('.wzlb').val()){
        $('.wzgl').hide();
    }
    //广告管理
    if(null==$('.gglb').val()){
        $('.adgl').hide();
    }
    //搭配管理
    if(null==$('.dpfllb').val() && null==$('.dplb').val()){
        $('.dpgl').hide();
    }
    //校趣管理
    if(null==$('.xqfllb').val() && null==$('.xqtzlb').val()){
        $('.xqgl').hide();
    }
    //评论管理
    if(null==$('.wzpl').val() && null==$('.sppl').val() && null==$('.xqpl').val() && null==$('.dppl').val()){
        $('.plgl').hide();
    }
    //积分管理
    if(null==$('.jfsplb').val() && null==$('.dhddlb').val() && null==$('.tbddlb').val()){
        $('.jfgl').hide();
    }
    //系统管理
    if(null==$('.tsxxlb').val() && null==$('.yjfklb').val() && null==$('.fwxy').val() && null==$('.kfrx').val() && null==$('.bbgx').val()){
        $('.xtsz').hide();
    }
    //PC管理
    if(null==$('.pcdsj').val() && null==$('.pchzcs').val()){
        $('.pcgl').hide();
    }
})
