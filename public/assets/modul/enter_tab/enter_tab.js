var load = 0;
 $.fn.enter_tab = function (options) {
    
    if(load == 0){
      $('[data-nextTab="1"]').focus();
    }
    load = 1; 
  $(this).keypress(function(e) {
    if (e.keyCode == 13) {
        //var id = e.currentTarget;
        var i = $(this).attr("data-nextTab");
        i = parseInt(i)+1;
        $('[data-nextTab="'+i+'"]').focus();
    }

//group function 
    /* var group = ['A','B','C','D','E'];

            var vr = [];
          for (var i = 0; i < group.length; i++) {
                
                if(group[i] == y){

                  var ii = i + 1;
                  y= group[ii];
                  vr.push(y);
                  $(".focusv"+y+"-1").focus();
                  //window.scrollToP(0,1000);
                  return;
                }

                
          }*/
  });

 };




