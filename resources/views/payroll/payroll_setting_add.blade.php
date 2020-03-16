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
                                        <h4 class="card-header-title language big-text">EDIT ATTRIBUTE PAYROLL</h4>

                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/payroll/salary-attribute')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Name</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" class="form-control enter_tab input_validasi " data-nextTab='1'  placeholder="Lable Or Name Attribute Salary" name="name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Type</label>
                                            <div class="col-9 col-lg-10">
                                              <select class="form-control enter_tab input_validasi" name="type" >
                                                <option value="">Pilih Type</option>
                                                <option value="1">Addition</option>
                                                <option value="2">Deduction</option>
                                              </select>
                                            </div>
                                        </div>

                                       <div class="form-group row">
                                          <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Module</label>
                                          <div class="col-9 col-lg-10">
                                            <select class="form-control enter_tab select_salary_module" name="modul" >
                                              <option value="">Pilih Modul</option>
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

    $(document).ready(function(){
      $(".select_salary_module").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Module',token:$("input[name='_token']").val(),field:"select_salary_module"});
    });

    $("#saveAdd").click(function(){
      errors.loading({id:"#loading_alerts",type:'show'});
      var validasi1 = $(".input_validasi").input_validasi({type:'required'});

     if(validasi1 == false){
        errors.loading({id:"#loading_alerts",type:'hide'});
        return;
     }else{
       
        var formData = new FormData($("#form2")[0]);
            console.log(formData);

       var formDataSerialized = $("#form2").serialize();
           console.log(formDataSerialized);     

         $.ajax({
                    url:"{{url('/payroll-setting/save')}}",
                    dataType: 'JSON',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
            
                      errors.loading({id:"#loading_alerts",type:'hide'});
                      if(response.success == true){
                           $("input.form-control").val("");
                           $("textarea.form-control").val("");

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