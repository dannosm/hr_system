error_massage = function () {
};

error_massage.prototype.success = function (options) {
	
	$(options.id).html("");
	$(options.id).append(this.html('primary',options.msg));
	$(options.id).fadeIn();
	setTimeout(function(){ $(options.id).fadeOut() }, 3000); 	
};
error_massage.prototype.failed = function (options) {  

	$(options.id).html("");
	$(options.id).append(this.html('danger',options.msg));
	$(options.id).fadeIn();
	setTimeout(function(){ $(options.id).fadeOut() }, 3000); 	
  
};
error_massage.prototype.failed_validasi_input = function (options) {  

  $("#massage_errors").html("");
  $("#massage_errors").append(this.html('danger','Field Required or Format Input Wrong'));
  $("massage_errors").fadeIn();
  setTimeout(function(){ $("#massage_errors").fadeOut() }, 3000); 
  
};
error_massage.prototype.html =function(alerts,msg){
return '<div class="alert alert-'+alerts+' alert-dismissible fade show" role="alert">'
		+msg+
        '<a href="#" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
          '</a>'+
        '</div>'
}

error_massage.prototype.loading =function(options){
	if(options.type == 'show'){
		$(options.id).html(" ");
		$(options.id).append('<span class="dashboard-spinner spinner-xs" style="align-content: center;"></span>');
	}else{
		$(options.id).html(" ");
	}
}

error_massage.prototype.file_download =function(urls){
  $.ajax({
                url: urls,
                method: 'GET',
                xhrFields: {
                responseType: 'blob'
                },
                success: function (data) {
                  var a = document.createElement('a');
                  var url = window.URL.createObjectURL(data);
                  //console.log(url);
                  a.href = url;
                  a.download = urls;
                  a.click();
                  window.URL.revokeObjectURL(url);
                  $(".overlay").hide();
                }
            });
}

error_massage.prototype.rupiahR =function(id){
	return result = this.formatRupiah(parseFloat(id), 'Rp. ','y');
}
error_massage.prototype.rupiah =function(id){
  var rupiah = $(id).val().replace(/\./g,'');
  result = this.formatRupiah(rupiah, 'Rp. ','x');
    $(id).val(result);
}
error_massage.prototype.formatRupiah =function(angka, prefix,ty){
  
  var number_string = angka.toString(),      
  split       = number_string.split(','),
  sisa        = split[0].length % 3,
  rupiah        = split[0].substr(0, sisa),
  ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if(ribuan){
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }
  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;      
  return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}

