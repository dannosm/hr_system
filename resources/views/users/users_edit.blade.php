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
                                       
                                       <!--  <div class="form-group row">
                                            <label for="inputPassword2" class="col-3 col-lg-2 col-form-label text-right">Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputPassword2" type="password" required="" placeholder="Password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputWebSite" class="col-3 col-lg-2 col-form-label text-right">Re Password</label>
                                            <div class="col-9 col-lg-10">
                                                <input id="inputWebSite" type="url" required="" data-parsley-type="url" placeholder="Re Password" class="form-control">
                                            </div>
                                        </div> -->
                                
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

$("#saveAdd").click(function(){
  errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
    var name = $("input[name='name']").val();
    var username = $("input[name='username']").val();
    var email = $("input[name='email']").val();
    var token = $("input[name='_token']").val();
    var id = $("input[name='id']").val();

    dataPost = {'_token':token,name:name,username:username,email:email,id:id};
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
</script>
@endpush
