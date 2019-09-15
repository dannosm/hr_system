 $.fn.input_validasi = function (options) {
  
    var error = true;
      var focus1= 0;
     var classlist = $(this).attr('class').split(' ').join('_');
      $(".note-validasi"+classlist).html(" ");
    $(this).each(function(){

      var x = check_validasi(options.type,this.value,this);
      if(x.length > 0){
        error = false;
        if(focus1 == 0){
          $(this).focus();
        }
        focus1 = focus1 +1;

         $(this).after(function(){

          return '<div class="note-validasi'+classlist+'" style="color:red;">'+x.join()+'</div>';
      })
    }


  })

   return error  ; 
 
 };


 function check_validasi(tipe,val,id){
  var tipe = tipe.split(',');
   var errors =[];
  
  for (var i = 0; i < tipe.length; i++) {
      
      switch(tipe[i]) {
      case 'required':
          if(val === ""){
           
           errors.push(' Field Tidak Boleh Kosong ');   
         
          }else if(typeof val == 'undefined'){
           errors.push(' Field Tidak Boleh Kosong ');   
           
          }
        break;
      case 'email':
        // code block
        break;
      case 'number':
        if(val !== "" && isNaN(val)){
          errors.push('Isi Harus Angka'); 
        }
        break;
      case 'max':
      if(val.length > 5){
          errors.push(' Maksimal 5 Karakter ');   
      }
      break;
      case 'min':
      min = $(id).attr('data-min');
      if(val.length < min){
          errors.push(' Minimal Karakter Yang Harus diisi '+min+' ');   
      }
      break;
      case 'password':
      pass1 = $("[data-repassword='1']").val();
      pass2 = $("[data-repassword='2']").val();
      if(pass1 !== pass2){
          errors.push('Password Tidak Sama');   
      }
      break;
      default:
       
      
      }

  }
      return errors;

 }


