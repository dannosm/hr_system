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
                                        <h4 class="card-header-title language big-text">EDIT USERS</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i><span class="language" >Save</span></a>
                                            <a href="{{url('/users')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> <span class="language" >Back</span></a>
                                        </div> 
                                    </div>
                            <div class="card-body">
                             <!--card-body-->
                            <!--end massage card-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                            <!--end massage card-->
                             
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Name</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="text" required="" data-parsley-type="email" placeholder="Nama" class="form-control enter_tab input_validasi " data-nextTab='1' name="name" value="{{$user->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">username</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputEmail2" type="text" required="" placeholder="User Name" class="form-control enter_tab input_validasi" data-nextTab='2' name="username" value="{{$user->username}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Email</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="email" type="email" required="" data-parsley-type="email" placeholder="Email" class="form-control enter_tab input_validasi" data-nextTab='3' name="email" value="{{$user->email}}" >
                                            </div>
                                        </div>

                                          <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Role</label>
                                            <div class="col-9 col-lg-10">
                                               <select class="form-control enter_tab input_validasi select_data" data-nextTab='1' name="role">
                                                   <option class="language" value="">Choose</option>
                                               </select>
                                            </div>
                                        </div>

                                         <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Change Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="checkbox" name="change_pass" value="yes" id="change_pass" style="margin-top:10px;">
                                            </div>
                                        </div>
                                       
                                         <div class="form-group row pass" style="display:none;">
                                            <label for="inputPassword2" class="col-3 col-lg-2 col-form-label text-right">Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputPassword2" type="password" required="" placeholder="Password" class="form-control enter_tab re-password" data-repassword='1' data-min='8' data-nextTab='4' name="password">
                                            </div>
                                        </div>
                                        <div class="form-group row pass" style="display:none;">
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
<input type="hidden" name="id" value="{{$user->id}}">
@csrf
@endsection

@push('footer')
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>




<script type="text/javascript">
var errors = new error_massage();
$(".enter_tab").enter_tab();
$("#email").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})   

 $(document).ready(function(){
    
    $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Employee',token:$("input[name='_token']").val(),field:"select2_role",value:{id:"{{$user->role_group}}",text:"{{$user->group_name}}"}});
     
  
} );

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

    if($("#change_pass").is(":checked") == true ){
  var validasi2 = $(".re-password").input_validasi({type:'required,password,min'});

        if(validasi2 == false){

            errors.loading({id:"#loading_alerts",type:'hide'});
            return;

        }
    }
 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
    var name = $("input[name='name']").val();
    var username = $("input[name='username']").val();
    var email = $("input[name='email']").val();
    var token = $("input[name='_token']").val();
    var password = $("input[name='password']").val();
    var repassword = $("input[name='repassword']").val();
    var change_pass = $("#change_pass:checked").val();
    var role = $("select[name='role']").val();
    


    var id = $("input[name='id']").val();

    dataPost = {'_token':token,name:name,username:username,email:email,id:id,password:password,repassword:repassword,change_pass:change_pass,role:role};
     $.ajax({
                url:"{{url('/users/update')}}",
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
    }


});

$("#change_pass").on('click',function(){
    if($(this).is(':checked')){
        $(".pass").removeAttr('style');
    }else{
        $(".pass").css({'display':'none'})
    }
})
</script>
@endpush
