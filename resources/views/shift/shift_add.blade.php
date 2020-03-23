@extends('layouts.app')

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
                                        <h4 class="card-header-title">ADD SHIFT</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/shift')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                            <!--card-body-->
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Name</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="text" required="" placeholder="Name Group Shift" class="form-control enter_tab input_validasi" data-nextTab='1' name="group_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Check In*</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="time" required="" data-parsley-type="email" placeholder="H:I:s" class="form-control enter_tab input_validasi "  name="check_in">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Check Out*</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="time"  placeholder="H:I:s"  class="form-control enter_tab input_validasi "  name="check_out">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Late Limit</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="lastButton" type="text"  placeholder="Exp 15"  class="form-control enter_tab input_validasi_number"  name="late_limit">
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">&nbsp;</label>
                                            <div class="col-9 col-lg-10" style="color: red;">
                                                Note : Jika Memilih durasi maka, keteralambatan jam istirahat dihitung berdasarkan durasi , contoh 60 menit , maka waktu istirahat adalah 60 , dan jika lebih dari 60 menit, maka dianggap telat 
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Duration</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="checkbox"  id="duration" placeholder="Exp 60"   name="duration" value="duration"> &nbsp; Yes 
                                            </div>
                                        </div>

                                        <div class="form-group row yes-duration" style="display: none;">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Duration breack</label>
                                             <div class="input-group col-9 col-lg-10">
                                                <div class="input-group-prepend"><span class="input-group-text language">Minute</span></div>
                                                <input type="number" placeholder="0" class="form-control" name="duration_breack" value="">
                                            </div>
                                        </div>

                                         <div class="form-group row no-duration" style="display: none;">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Breack In</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="time"  class="form-control "  name="breack_in" value="">
                                            <span>Format : H:i  exp 08:00</span>
                                            </div>
                                        </div>


                                         <div class="form-group row no-duration" style="display: none;">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Breack Out</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="time" class="form-control "  name="breack_out" value="">
                                              <span>Format : H:i  exp 08:00</span>
                                            </div>
                                        </div>
                                       
                            <!--end card body-->
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
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>

<script type="text/javascript">
    var errors = new error_massage();
    $(".enter_tab").enter_tab();

$("#lastButton").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})  
$("#duration").change(function(){
  
  if($(this).is(":checked")){
    $(".yes-duration").removeAttr('style');
    $(".no-duration").css('display','none');
  }else{
     $(".no-duration").removeAttr('style');
    $(".yes-duration").css('display','none');
  }
})


$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});
  var validasi2 = $(".input_validasi_number").input_validasi({type:'required,number'});


 if(validasi1 == false || validasi2 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
    var group_name = $("input[name='group_name']").val();
    var check_in = $("input[name='check_in']").val();
    var check_out = $("input[name='check_out']").val();
    var late_limit = $("input[name='late_limit']").val();
    var token = $("input[name='_token']").val();
        var duration = $("#duration:checked").val();
    var duration_breack = $("input[name='duration_breack']").val();
    var breack_in = $("input[name='breack_in']").val();
    var breack_out = $("input[name='breack_out']").val();


    dataPost = {'_token':token,group_name:group_name,check_in:check_in,check_out:check_out,late_limit:late_limit,duration:duration,duration_breack:duration_breack,breack_in:breack_in,breack_out:breack_out};

     $.ajax({
                url:"{{url('/shift/save')}}",
                data:dataPost,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
        
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                       $("input.form-control").val("");
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

</script>

@endpush
