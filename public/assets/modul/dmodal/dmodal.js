/* $.fn.dmodal = function (options) {
  $(this).click(function(){
    dmodalx(options);
  })
}*/

dmodal= function(options){
};


dmodal.prototype.get_modal = function(options){
  
   var fields = [];
   $(options.field).each(function(idx,val){
       var fieldx = '<div class="form-group row">'
            +'<label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Division</label>'
            +'<div class="col-9 col-lg-10">'+
             dmodal.html(val)
            +'</div>'
        +'</div>'
        fields.push(fieldx);
   });

  $(options.div_id).append(dmodal.modal_head(options.title)+'<form id"form-dmodal"><div class="modal-body">'+fields+'</div>'+dmodal.modal_footer(options.bclose,options.bsave));

};



dmodal.prototype.html = function(data){
    switch(data.type){
      case 'text':
        return "<input type='text' name='"+data.name+"' value='"+data.value+"' class='"+data.class+" id='"+data.id+"' "+data.attribute+"/>"; 
      break;
      case 'select':
        return "<select class='"+data.class+"' name='"+data.name+"' id='"+data.id+"' "+data.attribute+" ></select>";
      break;
      case 'textarea':
        return "<textarea name='"+data.name+"' class='"+data.class+"' id='"+data.id+"' "+data.attribute+""
      break;
      case 'checkbox':
        return "<input type='checkbox' name='"+data.name+"' value='"+data.value+"' class='"+data.class+" id='"+data.id+"' "+data.attribute+"/>"; 
      break;
      case 'radio':
        return "<input type='radio' name='"+data.name+"' value='"+data.value+"' class='"+data.class+" id='"+data.id+"' "+data.attribute+"/>"; 
      break;

      default:
      return ""
    }

};

dmodal.prototype.modal_head =function(title){
    return '<div class="modal fade" id="dmodalx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'
              +'<div class="modal-dialog" role="document">'
                  +'<div class="modal-content">'
                      +'<div class="modal-header">'
                          +'<h5 class="modal-title" id="exampleModalLabel">'+title+'</h5>'
                            +'<a href="#" class="close" data-dismiss="modal" aria-label="Close">'
                                      +'<span aria-hidden="true">&times;</span>'
                                  +'</a>'
                      +'</div>'
}

dmodal.prototype.modal_footer =function(bclose,bsave){
    var bclose = bclose[0];
    var bsave = bsave[0];
    return     '<div class="modal-footer">'
                +'<a href="#" class="btn btn-secondary" data-dismiss="modal">'+bclose.label+'</a>'
                  +'<a href="#" class="btn btn-primary onclick="'+bsave.onclick+'">'+bsave.label+'</a>'
              +'</div>'
          +'</div>'
          +'</div>'
    +'</div>'
  +'</div>'

}

var dmodal = new dmodal();