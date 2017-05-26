$(function(){
    $('#push_type').change(function(){
        if('1'==$(this).val()){
            $('#school_mode').hide();
            $('#user_mode').show();
        }else if('2'==$(this).val()){
            $('#school_mode').show();
            $('#user_mode').hide();
        }else{
            $('#school_mode').hide();
            $('#user_mode').hide();
        }
    });
});