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
                                        <h4 class="card-header-title">EDIT EMPLOYEE</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/employee')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                                       <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                            <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$data->employee_id}}">
                            <!--card-body-->
                            <!--simple card-->
                                <div class="simple-card">
                                    <ul class="nav nav-tabs" id="myTab5" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active border-left-0" id="home-tab-simple" data-toggle="tab" href="#home-simple" role="tab" aria-controls="home" aria-selected="true">Account</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab-simple" data-toggle="tab" href="#profile-simple" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab-simple" data-toggle="tab" href="#contact-simple" role="tab" aria-controls="contact" aria-selected="false">Company</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" id="contact-tab-simple" data-toggle="tab" href="#salary-simple" role="tab" aria-controls="salary" aria-selected="false">Salary</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent5">
                                        <div class="tab-pane fade show active" id="home-simple" role="tabpanel" aria-labelledby="home-tab-simple">
                                           <!--tab account-->
                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Name*</label>
                                            <div class="col-3 col-lg-9">
                                               <input type="text" value="{{$data->name}}" class="form-control form-control-sm tab enter_tab input_validasi" data-nextTab='1' placeholder="employee" name="name" >
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Username*</label>
                                            <div class="col-lg-9">
                                                <input  type="text" value="{{$data->username}}" class="form-control form-control-sm enter_tab input_validasi" data-nextTab='2' placeholder="username" name="username">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Email</label>
                                            <div class="col-lg-9">
                                               <input  type="text" value="{{$data->email}}" class="form-control form-control-sm enter_tab" data-nextTab='3' placeholder="Email" name="email">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Telphone*</label>
                                            <div class="col-lg-9">
                                                <input type="text" value="{{$data->telphone}}" class="form-control form-control-sm enter_tab input_validasi" data-nextTab='4' placeholder="telphone" name="telphone">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Password*</label>
                                            <div class="col-lg-9">
                                               <input type="password"  class="form-control form-control-sm enter_tab" data-nextTab='5' placeholder="password" name="password" disabled>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-3 col-lg-3 col-form-label text-right">Gender</label>
                                            <div class="col-lg-9">
                                                <select class="form-control form-control-sm enter_tab" data-nextTab='6' name="gender"/>
                                                    <option value="">Choose</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Shift</label>
                                            <div class="col-lg-9">
                                                <select class="form-control form-control-sm enter_tab select_shift" data-nextTab='7' placeholder="Shift Group" name="shift" id="shift" />
                                                    <option value="">Choose</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Status</label>
                                            <div class="col-lg-9">
                                                 <select class="form-control form-control-sm enter_tab" data-nextTab='8' placeholder="status" name="status"/>
                                                    <option value="">Choose</option>
                                                    <option value="active">Active</option>
                                                    <option value="nonactive">Nonactive</option>
                                                    <option value="leave">Leave</option>
                                                </select>
                                            </div>
                                          </div>
                                        </div>
                                           <!--tab account end-->

                                        </div>
                                        <div class="tab-pane fade" id="profile-simple" role="tabpanel" aria-labelledby="profile-tab-simple">
                                           <!--tab profile-->

                                            <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">ID Card</label>
                                            <div class="col-3 col-lg-9">
                                               <input type="text" value="{{$data->card_id}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='9' placeholder="id card / ktp" name="id_card" >
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Telphone 2</label>
                                            <div class="col-lg-9">
                                                <input  type="text" value="{{$data->telephone2}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='10' placeholder="telphone 2" name="telphone_2">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Birth Place</label>
                                            <div class="col-lg-9">
                                               <input  type="text" value="{{$data->birth_place}}" class="form-control form-control-sm tab enter_tab " data-nextTab='11' placeholder="Birth Place" name="birth_place">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Birth Day</label>
                                            <div class="col-lg-9">
                                                <input  type="text" value="{{$data->birth_day}}" class="form-control form-control-sm tab enter_tab datepicker" data-nextTab='12' placeholder="Birth Day" name="birth_day">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Marriage</label>
                                            <div class="col-lg-9">
                                               <select class="form-control form-control-sm enter_tab" data-nextTab='13' placeholder="Marriage" name="marriage"/>
                                                    <option value="">Choose</option>
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="widow">widow</option>
                                                    <option value="widower">widower</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-3 col-lg-3 col-form-label text-right">Religion</label>
                                            <div class="col-lg-9">
                                                <select class="form-control form-control-sm enter_tab" data-nextTab='14' placeholder="Religion" name="religion"/>
                                                    <option value="">Choose</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Katholik">Katholik</option>
                                                    <option value="Protestan">Protestan</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                </select>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Bank Name</label>
                                            <div class="col-lg-9">
                                                <input  type="text" value="{{$data->bank_name}}" class="form-control form-control-sm tab enter_tab " data-nextTab='15' placeholder="Bank Name" name="bank_name">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Bank Account</label>
                                            <div class="col-lg-9">
                                                 <input  type="text" value="{{$data->bank_account}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='16' placeholder="Bank Account" name="bank_account">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Country</label>
                                            <div class="col-lg-9">
                                                <input  type="text" value="{{$data->country}}" class="form-control form-control-sm tab enter_tab " data-nextTab='17' placeholder="Country" name="country">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Avatar</label>
                                            <div class="col-lg-9">
                                                 <input type="file" value="" class="form-control form-control-sm tab enter_tab"  name="avatar" data-nextTab='18'>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Address</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control form-control-sm tab enter_tab " data-nextTab='19' placeholder="Address" name="address">{{$data->address}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-3 col-form-label text-right">Description</label>
                                            <div class="col-lg-9">
                                                  <textarea class="form-control form-control-sm tab enter_tab " data-nextTab='20' placeholder="Description" name="description">{{$data->description}}</textarea>
                                          </div>
                                        </div>
                                      </div>
                                           <!--tab profile end-->
                                        </div>
                                        <div class="tab-pane fade" id="contact-simple" role="tabpanel" aria-labelledby="contact-tab-simple">
                                           <!-- tab company -->

                                        <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Division</label>
                                            <div class="col-lg-8">
                                                 <select class="form-control form-control-sm enter_tab select_division" data-nextTab='21' name="division"/>
                                                    <option value="">Choose</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Position</label>
                                            <div class="col-lg-8">
                                                 <select class="form-control form-control-sm enter_tab select_position" data-nextTab='22' name="position"/>
                                                    <option value="">Choose</option>
                                                </select>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Joint At</label>
                                            <div class="col-lg-8">
                                                 <input type="text" value="{{$data->join_at}}" class="form-control form-control-sm tab enter_tab datepicker" data-nextTab='23' placeholder="Join At" name="join_at">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Date Contract</label>
                                            <div class="col-lg-8">
                                                 <input  type="text" value="{{$data->date_last_contract}}" class="form-control form-control-sm tab enter_tab datepicker" data-nextTab='24' placeholder="Date Last Contract" name="date_contract">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Employment</label>
                                            <div class="col-lg-8">
                                                  <select class="form-control form-control-sm enter_tab" data-nextTab='25' name="employment"/>
                                                    <option value="contract">Contract</option>
                                                    <option value="permanent">Permanent</option>
                                                    <option value="freelance">FreeLance</option>
                                                    <option value="trial">Trial</option>
                                                    <option value="parttime">Parttime</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Leave</label>
                                            <div class="col-lg-8">
                                                 <input  type="text" value="{{$data->leave}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='26' placeholder="Leave" name="leave">
                                          </div>
                                        </div>
                                      </div>

                                       <div class="form-row">
                                         <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Bpjs Tenaker</label>
                                            <div class="col-lg-8">
                                                  <input  type="text" value="{{$data->bpjs_ketenaga_kerjaan}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='27' placeholder="Account Number Bpjs" name="bpjs_ketenaga_kerjaan">
                                            </div>
                                          </div>
                                          <div class="form-group row col-lg-2">
                                            &nbsp;
                                          </div>
                                          <div class="form-group row col-lg-5">
                                            <label for="inputEmail2" class="col-lg-4 col-form-label text-right">Bpjs Kesehatan</label>
                                            <div class="col-lg-8">
                                                 <input  type="text" value="{{$data->bpjs_kesehatan}}" class="form-control form-control-sm tab enter_tab input_angka" data-nextTab='28' placeholder="Account Number" name="bpjs_kesehatan">
                                          </div>
                                        </div>
                                      </div>

                                           <!-- end tab company -->

                                        </div>
                                        <div class="tab-pane fade salary_attribute_list" id="salary-simple" role="tabpanel" aria-labelledby="salary-tab-simple">
                                            <!-- tab salary -->


                                            <!-- tab salary end -->
                                        </div>
                                    </div>
                                </div>
                            <!--end card-->

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
@csrf


@endsection

@push('footer')
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/attribute_salary/attribute_salary.js"></script>



<script type="text/javascript">
    var errors = new error_massage();
    var attribute_salary = new attribute_salary({url:"{{url('payroll/salary-attribute-get')}}",token:$("input[name='_token']").val(),div_id:".salary_attribute_list",id:"{{$data->employee_id}}"});
    $(".enter_tab").enter_tab();

$("#lastButton").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})   
$(document).ready(function(){

  $(".select_shift").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Shift',token:$("input[name='_token']").val(),field:"select2_shift",value:{id:"{{$data->shift_id}}",text:"{{$data->shift}}"}});

  $(".select_position").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Position',token:$("input[name='_token']").val(),field:"select2_position",value:{id:"{{$data->position_id}}",text:"{{$data->position}}"}});

  $(".select_division").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Division',token:$("input[name='_token']").val(),field:"select2_division",value:{id:"{{$data->division_id}}",text:"{{$data->division}}"}});
})

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});
  var validasi2 = $(".input_angka").input_validasi({type:'number'});

 if(validasi1 == false || validasi2 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
   
    var formData = new FormData($("#form2")[0]);
    var formDataSerialized = $("#form2").serialize();

     $.ajax({
                url:"{{url('/employee/update')}}",
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

$( function() {
    $( ".datepicker" ).datepicker({
        format: "yyyy-mm-dd",
           autoclose: true,
        orientation: "bottom"
    })
});

$(".rupiah").on('keyup',function(){
    var id = $(this).val().replace(/\./g,'');
    var val = errors.rupiahR(id);
    $(this).val(val);
    console.log(val);
})



</script>
@endpush

