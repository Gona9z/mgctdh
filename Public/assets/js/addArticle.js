/*富文本編輯器方法調用*/
      $(function(){
          $('#edit').editable({inlineMode: false, alwaysBlank: true,language: "zh_cn"})
      });
      $(function(){
          $('#HDedit').editable({inlineMode: false, alwaysBlank: true,language: "zh_cn"})
      });
    /*tab切換欄調用*/
    $(function(){
    	$('#myTab li:eq(0) a').tab('show');
    });
   