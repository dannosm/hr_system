
attribute = function () {

};
attribute.prototype.get = function (id) { 

  $.ajax({
      type: "POST",
      url: urls+"product-attribute-group/get-by-id-category/"+company_id+"/"+token,
      data: {id:id,product_id:product_ids}, 
      cache: false,

      success: function(response){
       
       var result = JSON.parse(response);
       var data = result.content;
       console.log(data);
       append_html(data);

      }
    }); 
    
};

$(document).ready(function(){
 $('.js-data-example-ajax').select2({

      ajax: {
        url: urls+"product-attribute-group/get/"+company_id+"/"+token+"/0",
        dataType: 'json',
        delay: 250,
        type:"POST",
        data: function (params) {

            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
          //console.log(data);

            return {
                results: data
            };
        },
        cache: true
        },
        
        afterSelect :function (data){
          if(data.id !== ''){
            $('.nextBtn').focus();
          }
        },
        placeholder: 'Ketikan Nama Supplier',
        minimumInputLength: 0,
        /*
        formatResult: function(element){
          return element.text + ' (' + element.id + ')';
        },
        formatSelection: function(element){
          return element.text + ' (' + element.id + ')';
        },
        escapeMarkup: function(m) {
          return m;
        }*/
      });
 });

//get data attribute
$("#supplier").on('change',function(){
	var id = $(this).val();
	$("#product_attribute").val(id);
	$.ajax({
      type: "POST",
      url: urls+"product-attribute-group/get-by-id/"+company_id+"/"+token,
      data: {id:id,product_id:product_ids}, 
      cache: false,

      success: function(response){
       
       var result = JSON.parse(response);
       console.log(result);
       var data = result.content;
       $(".attribute_list").html(" ");
   		append_html(data);

      }
    });
})


function append_html(data){

	$(data).each(function(index,val){
		var model = JSON.parse(val.model);

		$(".attribute_list").append(

			  '<div class="form-group required field_'+val.cat_id+'" >'+
                '<label class="col-sm-2 control-label" for="input-name">'+model.label+'</label>'+
                '<div class="col-sm-10">'+
               html_type(val.id,model.tipe,model.name,val.valuess,model.class,val.cat_id)+
               '</div>'+
               '</div>' 

		);
	});
}

function html_type(id,tipe,name,value,classs,cat_id){

	if(tipe == 'text' || tipe == "number"){
		return "<input type='"+tipe+"' class='form-control attribute_save "+classs+"' value='"+value+"' name='att["+cat_id+","+id+"]'>";
	}else if(tipe == 'select'){

		return "<select class='form-control attribute_save "+classs+"'  name='att["+id+"]' ><option value=''>Pilih</option></select>";
	}else if(tipe == 'textarea'){
		return "<textarea class='form-control attribute_save "+classs+"' name='att["+id+"]'>"+value+","+cat_id+"</textarea>";
	}else if( tipe == 'radio' || tipe == "checkbox"){
		var cheked = '';
		if(value !== null){
			cheked = "checked";
		}
		return "<input type='"+tipe+"' class='attribute_save "+classs+"' "+cheked+" value='"+value+","+cat_id+"' name='att["+id+"]'>";	
	}

}



