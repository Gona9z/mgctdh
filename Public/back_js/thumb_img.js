//////////////////////////////上传图片----预览---开始
//获取input[file]图片的url Important
function getFileUrl(fileId) {
    var url;
    var file = document.getElementById(fileId);
    var agent = navigator.userAgent;
    if (agent.indexOf("MSIE")>=1) {
        url = file.value;
    } else if(agent.indexOf("Firefox")>0) {
        url = window.URL.createObjectURL(file.files.item(0));
    } else if(agent.indexOf("Chrome")>0) {
        url = window.URL.createObjectURL(file.files.item(0));
    }
    return url;
}
//文件选择   form_file：所选文件位置id to_img:图片展示位置id
function getImageFormat(form_file,to_img){
    var imageFile = $("#"+form_file).val();
    if(imageFile!=''){
        if (!/\.(jpg|jpeg|png|JPG|PNG)$/.test(imageFile)) {
            $("#"+form_file).val("");
            alert("所选图片格式错误!");
        }else{
            //读取图片后预览
            var imgPre = document.getElementById(to_img);
            imgPre.src = getFileUrl(form_file);
        }
    }
}
//////////////////////////////上传图片----预览---结束