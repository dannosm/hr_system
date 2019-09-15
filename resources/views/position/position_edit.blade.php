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
                                        <h4 class="card-header-title">EDIT Position</h4>

                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/position')}}" class="btn btn-dark btn-sm "><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                            <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                    <input type="hidden" value="{{$data->id}}" name="id">

                                        @csrf      
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Position</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" class="form-control enter_tab input_validasi " data-nextTab='1' name="name" value="{{$data->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Description</label>
                                            <div class="col-9 col-lg-10">
                                                <textarea name="description" class="form-control enter_tab" data-nextTab='2'>{{$data->description}}</textarea>
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
    $(document).ready(function(){
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
                url:"{{url('/position/update')}}",
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



</script>
@endpush


