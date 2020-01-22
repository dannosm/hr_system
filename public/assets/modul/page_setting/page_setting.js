page_setting = function () {
 // setTimeout(function(){ this.change(id) }, 5000);  
};


page_setting.prototype.set_page = function (options) {
   $.ajax({
      url : options.url,
      type: "POST",
        dataType: 'JSON',
      data :{_token:options.token},
      success: function(response)
       {
        var data = response.content;
          $(data).each(function(idx,val){
               switch(val.type) {
                  case 'image':
                    $("#set_image_"+val.id).attr("src", "images/"+val.image); 
                    console.log(val.id,val.image);
                  break;
                default:
                break;
              }
          })
          return;
        },
        error: function (error) {
                   language.changes({url:options.url_asset,id:'id'});
                }
      });
};

