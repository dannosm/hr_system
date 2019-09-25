attribute_salary = function (options) {
	this.attribute_salary_get(options);
};

attribute_salary.prototype.append_html = function (id,data) {
	$(id).html("");
	var div_app = [];
	var num = 0;

	$(data).each(function(idx,val){
		num = num+1;
		if(num % 2 == 0){
			 div_app.push('<div class="form-group row col-lg-2">&nbsp;</div>'+
			 attribute_salary.html(val.id,val.name,num,val.value)
			 +'</div>');
		}else{
			div_app.push('<div class="form-row">'+attribute_salary.html(val.id,val.name,num,val.value));
		}
		
	});

		$(id).append(div_app.join(''));
		attribute_salary.rupiah();
		$(".enter_tab").enter_tab();

};

attribute_salary.prototype.attribute_salary_get = function (options) {

	$.ajax({
      type: "POST",
      url: options.url,
      data:{_token:options.token,id:options.id}, 
      cache: false,
     dataType: 'json',
      success: function(data){
  
      	attribute_salary.append_html(options.div_id,data)
      }

   });

};

attribute_salary.prototype.html = function (id,name,num,val) {
	

return   '<div class="form-group row col-lg-5">'
+'<label for="inputEmail2" class="col-lg-5 col-form-label text-right language">'+name+'</label>'
+'<div class="col-lg-7">'
 +     '<input type="text" value="'+val+'" class="form-control form-control-sm tab enter_tab rupiah" data-nextTab='+num+'  name="salary['+id+']">'
+'</div>'
+'</div>';
                             	
};

attribute_salary.prototype.rupiah = function(){
	
	$(".rupiah").on('keyup',function(){
    var id = $(this).val().replace(/\./g,'');
    var val = errors.rupiahR(id);
    $(this).val(val);
	})
};

