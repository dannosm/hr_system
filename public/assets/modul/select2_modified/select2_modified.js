 $.fn.select2_modified = function (options) {
   $(this).select2({

      ajax: {
        url:options.url,
        dataType: 'json',
        delay: 250,
        type:"POST",
        data: function (params) {

            return {
                q: params.term,
                _token: options.token // search term
            };
        },
        processResults: function (data) {
          console.log(data);

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
        placeholder: options.label,
        minimumInputLength: 0,
      });

      if(typeof options.value !=='undefined'){
         var newOption = new Option(options.value.text,options.value.id , true, true);
         $(this).append(newOption).trigger('change');
      }
}



