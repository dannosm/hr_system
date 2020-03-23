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
                                        <h4 class="card-header-title language">Attendance Late Module</h4>

                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm language" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/salary-module')}}" class="btn btn-dark btn-sm language"><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <input type="hidden" name="extensions" value="extensionAttendanceController">

                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Event</label>
                                            <div class="col-9 col-lg-10" >

                                                <input type=checkbox name="all_in_one" id="all_in_one" value="all_in_one" style="margin: 12px;"><span class="language eventc">All in One &nbsp;

                                                  <input type=checkbox name="late_deduction" id="late_deduction" value="late_deduction" style="margin: 12px;"><span class="language eventc">Late Reduction &nbsp;

                                                    <input type=checkbox name="late_breack" id="late_breack" value="late_breack" style="margin: 12px;"><span class="language eventc">Late Break Reduction &nbsp;
                                            </div>
                                        </div>

                                        <div class="form-group row all_in_one" style="display: none;">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Amount</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" name="all_in_one_value" class="form-control rupiah" id="all_in_one_value" oninput="errors.rupiah(this)">
                                            </div>
                                        </div>

                                        <div class="form-group row late_deduction" style="display: none;">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Amount Attendance Late</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" name="late_deduction_value" class="form-control rupiah" id="late_deduction_value" oninput="errors.rupiah(this)">
                                            </div>
                                        </div>

                                        <div class="form-group row late_breack" style="display: none;" >
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Amount Late Break</label>
                                            <div class="col-9 col-lg-10">
                                              <input type="text" name="late_breack_value" class="form-control rupiah" id="late_breack_value" oninput="errors.rupiah(this)">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Status</label>
                                            <div class="col-9 col-lg-10">
                                                <select name="status" class="form-control" id="status">
                                                  <option value="active">Active</option>
                                                  <option value="nonactive">Non Active</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                       
                            <!--end card body-->
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>
                <!--end row-->
              @php $arr = json_decode($data[0]->value,true); $tipe = $arr['tipe']; @endphp


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
});

$(document).ready(function(){
  $("#status").val("{{$data[0]->status}}");
    var tipe = "{{$tipe}}";
    if(tipe == '1'){
     $(".all_in_one").removeAttr('style');
     $("#all_in_one").prop("checked",true);
     $("#all_in_one_value").val(errors.rupiahR("{{@$arr['value']}}"));
    }else{

     $(".late_deduction").removeAttr('style');
     $("#late_deduction").prop("checked",true);
     $("#late_deduction_value").val(errors.rupiahR("{{@$arr['module']['attendance']}}"));

     $(".late_breack").removeAttr('style');
     $("#late_breack").prop("checked",true);
     $("#late_breack_value").val(errors.rupiahR("{{@$arr['module']['breack']}}"));
    }
})   

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
 // var validasi1 = $(".input_validasi").input_validasi({type:'required'});
var validasi1 = true;

 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
   
    var formData = new FormData($("#form2")[0]);
        console.log(formData);

   var formDataSerialized = $("#form2").serialize();
       console.log(formDataSerialized);     

     $.ajax({
                url:"{{url('/extension/attendance-late/save')}}",
                dataType: 'JSON',
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
        
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                       

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


$("#late_deduction").change(function(){
  if($(this).is(":checked")){
    $(".late_deduction").removeAttr('style');
    $(".all_in_one").css('display','none');
    $("#all_in_one").prop("checked",false);

  }else{
    $(".late_deduction").css('display','none');

  }
})

$("#late_breack").change(function(){
  if($(this).is(":checked")){
    $(".late_breack").removeAttr('style')
    $(".all_in_one").css('display','none');
    $("#all_in_one").prop("checked",false);

  }else{
    $(".late_breack").css('display','none');
  }
})

$("#all_in_one").change(function(){
  if($(this).is(":checked")){
    $(".late_deduction").css('display','none')
    $(".late_breack").css('display','none')
    $("#late_deduction").prop("checked",false);
    $("#late_breack").prop("checked",false);
    $(".all_in_one").removeAttr('style');

  }else{
    $(".all_in_one").css('display','none');

  }
})


$(".rupiah").on('keyup',function(){
  $(this).val().replace
})


</script>
@endpush
