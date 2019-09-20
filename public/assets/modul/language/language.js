var id ='';
language = function () {
 // setTimeout(function(){ this.change(id) }, 5000);  
};


language.prototype.change = function (options) {
   var id = options.id; 
  this.change_flag(id);
   
fetch('./assets/modul/language/data.json')
  .then(function(response) {
    return response.json();
  })
  .then(function(myJson) {

      console.log(myJson.id)
     $(".language").each(function(){
        var x = $(this).text().trimLeft();
        if(id === 'id'){
             var result = myJson.id.find(data => data.id === x)
        }else{
             var result = myJson.us.find(data => data.id === x)
        }
        if(typeof result !== 'undefined'){
          $(this).text(' '+result.value);
        } 
    })

  });   
};

language.prototype.changes = function (options) {
   var id = options.id; 
   this.change_flag(id);
   
fetch(options.url)
  .then(function(response) {
    return response.json();
  })
  .then(function(myJson) {
     $(".language").each(function(){
        var x = $(this).text().trimLeft().toLowerCase();
        if(id === 'id'){
             var result = myJson.id.find(data => data.id.toLowerCase() === x)
        }else{
             var result = myJson.us.find(data => data.id.toLowerCase() === x)
        }
        if(typeof result !== 'undefined'){
          $(this).text(' '+result.value);
        } 
    })

  });   
};

language.prototype.change_flag = function (id) {

   if(id === 'id'){
       $(".language-flag").html("");
       $(".language-flag").append('<i class="flag-icon flag-icon-id"></i>');
    }else{
       $(".language-flag").html("");
       $(".language-flag").append('<i class="flag-icon flag-icon-us"></i>');
    }

};

language.prototype.check_language = function (options) {

   $.ajax({
      url : options.url,
      type: "POST",
        dataType: 'JSON',
      data :{_token:options.token},
      success: function(response)
       {
        
            language.changes({url:options.url_asset,id:response.bhs});
        },
        error: function (error) {
                   language.changes({url:options.url_asset,id:'id'});
                }
      });

};


language.prototype.save_language = function (options) {

   $.ajax({
      url : options.url,
      type: "POST",
        dataType: 'JSON',
      data :{_token:options.token,id:options.id},
      success: function(response)
       {
            language.changes({url:options.url_asset,id:response.bhs});
        },
        error: function (error) {
                   language.changes({url:options.url_asset,id:'id'});
                }
      });

};


