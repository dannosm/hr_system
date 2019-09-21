 $.fn.select_delete = function (options) {
  	
  	var $submit = $(options.buttons).hide(),   
	$cbs=$(this).change(function () {

	   $(options.select_child).prop('checked',this.checked);
        $submit.toggle( $cbs.is(":checked") );
    });

    $(options.buttons).on('click',function(){
	  errors.loading({id:"#loading_alerts",type:'show'});
	  var selected_value = [];  
	    $(options.select_child+':checked').each(function(){
	      var d = $(this).val();
	      selected_value.push(d);
	    });
	    var urlini=document.URL;

	  //var jsonString = JSON.stringify(selected_value);
	   myData={'list_id':selected_value,'_token':options.token};

	   $.ajax({
	    url : options.urls,
	    type: "POST",
        dataType: 'JSON',
	    data : myData,
	    success: function(response)
	     {
	     	load_data();
	     	errors.loading({id:"#loading_alerts",type:'hide'});
	          if(response.success == true){
	               errors.success({id:"#massage_errors",msg:response.msg});
	          }else{
	                errors.failed({id:"#massage_errors",msg:response.msg});
	          }
	      },
	      error: function (error) {
                    msg = JSON.stringify(error.responseJSON.errors);
                    //msg = error.responseJSON.errors.email;
                    errors.loading({id:"#loading_alerts",type:'hide'});
                    errors.failed({id:"#massage_errors",msg:"Save Data Failed"+msg});
                }
	    });

	});

     
 };
