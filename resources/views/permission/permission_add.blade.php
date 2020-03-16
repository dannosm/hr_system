@extends('layouts.app')
  
@push('header')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/vendor/select2/css/select2.css">
@endpush
@section('content')
<!--header content -->
               <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title breadcrumb">Data Tables </h2>
                            <hr style="margin-top:-1%;">
                         </div>
                    </div>
                </div> -->

<!-- end header conten -->
<!-- start row -->
 <div class="row">
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chd">
                           <div class="card-header d-flex">
                                        <h4 class="card-header-title language big-text">ADD PERMISSION</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> <span class="language" >Save</span></a>
                                            <a href="{{url('/permission')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> <span class="language" >Back</span></a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                            <!--card-body-->
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Name</label>
                                            <div class="col-9 col-lg-10">
                                               <select class="form-control enter_tab input_validasi select_data" data-nextTab='1' name="employee">
                                                   <option class="language">Choose</option>
                                               </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Category</label>
                                            <div class="col-9 col-lg-10">
                                                 <select class="form-control enter_tab input_validasi "  name="category">
                                                   <option value="" class="language">Choose</option>
                                                   <option value="sick" class="language">Sick</option>
                                                   <option value="permit" class="language">Permit</option>
                                                   <option value="outstation" class="language">OutStation</option>
                                                   <option value="late" class="language">Late</option>
                                                   <option value="leave" class="language">Leave</option>
                                                   <option value="paid_leave" class="language">Paid Leave</option>
                                                   <option value="special_permission" class="language">Special Permission</option>
                                                   <option value="remaining_leave" class="language">Remaining Leave</option>
                                                   <option value="other" class="language">other</option>
                                               </select>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Date Start</label>
                                            <div class="col-9 col-lg-10">
                                             <input type="text" class="form-control enter_tab input_validasi datepicker dateDiff" name="date_start" id="date_start"  autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Date End</label>
                                            <div class="col-9 col-lg-10">
                                            <input type="text" class="form-control enter_tab input_validasi datepicker dateDiff" name="date_end" id="date_end"  autocomplete="off" />
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Days</label>
                                            <div class="col-9 col-lg-10">
                                              <input type="number" name="days" readonly class="form-control enter_tab input_validasi " id="days"style="width:10%">
                                              
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Description</label>
                                            <div class="col-9 col-lg-10">
                                              <textarea class="form-control enter_tab input_validasi"  name="description"></textarea>
                                            </div>
                                        </div>

                                       
                            <!--end card body-->
                            <input type="hidden" name="type" value="permission">
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>
                <!--end row-->
@csrf

@endsection

@push('footer')

<script type="text/javascript">
    var errors = new error_massage();
    $(".enter_tab").enter_tab();
    $(document).ready(function(){
    
     $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Employee',token:$("input[name='_token']").val(),field:"select2_employee"});
} );

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
    var employee = $("select[name='employee']").val();
    var category = $("select[name='category']").val();
    var date_start = $("input[name='date_start']").val();
    var date_end = $("input[name='date_end']").val();
    var days = $("input[name='days']").val();
    var description = $("textarea[name='description']").val();
    var type = $("input[name='type']").val();


    var token = $("input[name='_token']").val();

    dataPost = {'_token':token,employee:employee,category:category,date_start:date_start,date_end:date_end,days:days,description:description,type:type};

     $.ajax({
                url:"{{url('/permission/save')}}",
                data:dataPost,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
        
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                       $("input.form-control").val("");
                       $("textarea.form-control").val("");
                       $("select.form-control").val("");

                       errors.success({id:"#massage_errors",msg:response.msg});
                  }else{
                        errors.failed({id:"#massage_errors",msg:response.msg});
                  }
                   
                },error: function (error) {
                    msg = JSON.stringify(error.responseJSON.errors);
                    //msg = error.responseJSON.errors.email;
                    errors.loading({id:"#loading_alerts",type:'hide'});
                    errors.failed({id:"#massage_errors",msg:"Save Data Failed"+msg});
                }
           });
    }
});
$("#lastButton").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})
$( function() {
    $( ".datepicker" ).datepicker({
        format: "yyyy-mm-dd",
           autoclose: true,
        orientation: "bottom"
    }).on('changeDate', function (ev) {
        
          function daysDifference(d0, d1) {
        var diff = new Date(+d1).setHours(12) - new Date(+d0).setHours(12);
        return Math.round(diff/8.64e7);
      }


            date1 = $("#date_start").val();
            date2 = $("#date_end").val();
         
            if(date1 !== '' || date2 !==''){
            var x = daysDifference(new Date(date1),new Date(date2));
            if(x < 0){
                errors.failed({id:"#massage_errors",msg:"minimum days 1"});
            }
            
             $("#days").val(x + 1);
            
         }
        })

});


</script>


@endpush
