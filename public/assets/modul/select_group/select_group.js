var rowNum=0;

function removeRow(vals){

    $('#rowNum'+vals).remove();
}

 $.fn.select_group = function (options) {

     
    var idx = this;
     var field_name = options.value_name;
    $(this).after(function(){
      return '<div id="'+field_name+'" class="scrollbox" style="margin-top:5px;height:120px;width:100%;border:1px solid #ccc;overflow:auto;"> </div>';
    })

    
   if(options.url_get !== ''){
         $.ajax({
            type: "POST",
            url:options.url_get,
            data: {_token:options.token}, 
            cache: false,

            success: function(response){
              var result = JSON.parse(response);

                $(JSON.parse(result[0].shift_list)).each(function(idx,item){
                  
              var wrapper = $("#"+field_name); 
              var list_product=item.name+' <input type="hidden" class="'+field_name+'" name="'+field_name+'[]" data-no-name="'+item.name+'" id="val_'+item.id+'" value="'+item.id+'"></td>';
              var list_action_delete='<a class="btn btn-danger btn-sm language" style="color:#ffffff" onclick ="removeRow(\''+rowNum+'\')"><i class="fa fa-minus fa-fw"></i>Remove</a>';
              $(wrapper).append('<p id="rowNum'+rowNum+'">'+list_product+list_action_delete+'</p>');
              $(idx).val('');
                 rowNum++;

                })
               
             }
          });

    }



    //typehead function
    $(this).typeahead({
         //ajax: "<?php echo $BASE.'/'; ?>tester/olahdata"
          name:'select group',
          displayKey: 'name',
          source: function (query, process) {
            return $.get(options.url, { query: query }, function (data) { 
              data = $.parseJSON(data);
              return process(data);
            });
          },
          afterSelect :function (item){
              console.log(options.validasi);
              if(options.validasi == 'not-same-data'){
               var c = $("#val_"+item.id).val();
                if(typeof c !=='undefined'){
                  $(idx).val('');
                  alert("Data Sudah Ada!!, Matikan validasi untuk insert data yang sama");
                  return;
                }
              }
              var wrapper = $("#"+field_name); 
              var list_product=item.name+' <input type="hidden" class="'+field_name+'" name="'+field_name+'[]" id="val_'+item.id+'" data-no-name="'+item.name+'" value="'+item.id+'"></td>';
              var list_action_delete='<a class="btn btn-danger btn-sm language" style="color:#ffffff" onclick ="removeRow(\''+rowNum+'\')"><i class="fa fa-minus fa-fw"></i>Remove</a>';
              $(wrapper).append('<p id="rowNum'+rowNum+'">'+list_product+list_action_delete+'</p>');
              $(idx).val('');
              rowNum++;

          }
    });

 };


