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
                                        <h4 class="card-header-title language">SHIFT SETTING</h4>
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
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Status</label>
                                            <div class="col-9 col-lg-10">
                                                <select name="status" class="form-control input_validasi" id="status">
                                                    <option value="active" class="language">Active</option>
                                                    <option value="nonactive" class="language">Non Active</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Auto Sync</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="checkbox" name="auto_sync" id="auto_sync" value="1" class="language">&nbsp;&nbsp;Yes
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Schedule</label>
                                            <div class="col-9 col-lg-10">
                                               <input type="text" name="schedule" class="datepicker form-control" value="{{$shift->schedule}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Type</label>
                                            <div class="col-9 col-lg-10">
                                                <select name="tipe" class="form-control input_validasi" id="tipe">
                                                    <option value="random" class="language">Random</option>
                                                    <option value="alternate" class="language">Alternate</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Shift</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" name="attribute_group" class="select_group form-control">
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
                <!--end row-->
@csrf
@endsection

@push('footer')
<script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
<script src="{{URL::to('/')}}/assets/modul/select_group/select_group.js"></script>
<script src="{{URL::to('/')}}/assets/vendor/bootstrap3-typeahead.js"></script>





<script type="text/javascript">
    var errors = new error_massage();
    $(".enter_tab").enter_tab();

$("#lastButton").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})  


$(document).ready(function(){
    $("#status").val("{{$shift->status}}");
    $("#tipe").val("{{$shift->tipe}}");
    var auto_sync = "{{$shift->sync_auto}}";
    if(auto_sync == 1){
        $("#auto_sync").prop("checked",true);
    }

    $(".select_group").select_group({url:"{{url('/select2-group/get-like')}}",value_name:'attribute_list_detail',validasi:'not-same-data',url_get:"{{url('/shift-setting/get-by-id')}}",token:$("input[name='_token']").val()});
   //$(".select_shift").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Shift',token:$("input[name='_token']").val(),field:"select2_shift"});

});

$( function() {
   
    $( ".datepicker" ).datepicker({
         format: "d",
    viewMode: "days", 
    minViewMode: "days",
        orientation: "bottom",
           autoclose: true
    })
});



$("#saveAdd").click(function(){

    var status = $("select[name='status']").val();
    var tipe = $("select[name='tipe']").val();
    var token = $("input[name='_token']").val();
    var auto_sync = $("#auto_sync").val();
    var schedule = $("input[name='schedule']").val();

     var shift = [];
      $('.attribute_list_detail').each(function(){
        shift.push({id:this.value,'name':$(this).data('no-name')})
      })


      if(shift.length < 2 && status == 'active'){
        alert("Pilih Salah Satu Shift");
        errors.loading({id:"#loading_alerts",type:'hide'});
        return;
      }

      if($('#auto_sync').is(":checked") && schedule ==""){
         alert("Schedule Tidak Boleh Kosong");
         return;
      }
   
    errors.loading({id:"#loading_alerts",type:'show'}); 

    dataPost = {'_token':token,status:status,tipe:tipe,shift:shift,sync_auto:auto_sync,schedule:schedule};

     $.ajax({
                url:"{{url('/shift-setting/update')}}",
                data:dataPost,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
        
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                       //$("input.form-control").val("");
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
    
});
</script>
@endpush

