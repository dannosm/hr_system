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
                                        <h4 class="card-header-title">ADD USERS </h4>

                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/users')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                             
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Name</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="text" required="" data-parsley-type="email" placeholder="Nama" class="form-control enter_tab input_validasi " data-nextTab='1' name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">username</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="text" required="" data-parsley-type="email" placeholder="User Name" class="form-control enter_tab input_validasi" data-nextTab='2' name="username">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Email</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="email" required="" data-parsley-type="email" placeholder="Email" class="form-control enter_tab input_validasi" data-nextTab='3' name="email">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label for="inputPassword2" class="col-3 col-lg-2 col-form-label text-right">Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputPassword2" type="password" required="" placeholder="Password" class="form-control enter_tab re-password" data-repassword='1' data-min='8' data-nextTab='4' name="password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputWebSite" class="col-3 col-lg-2 col-form-label text-right">Re Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="repassword" type="password" data-min='8'  data-repassword='2' placeholder="Re Password" class="form-control enter_tab re-password" data-nextTab='5' name="repassword">
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

$("#repassword").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})   

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi2 = $(".re-password").input_validasi({type:'required,password,min'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

 if(validasi1 == false || validasi2 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
    var name = $("input[name='name']").val();
    var username = $("input[name='username']").val();
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var repassword = $("input[name='repassword']").val();
    var token = $("input[name='_token']").val();

    dataPost = {'_token':token,name:name,username:username,email:email,password:password,repassword:repassword};

     $.ajax({
                url:"{{url('/users/save')}}",
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

