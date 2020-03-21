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
                                        <h4 class="card-header-title language">Payroll</h4>
                                        <div class="toolbar ml-auto">
                                            @if(session()->get('roles')[6]->role_write == 1)
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm language" onclick="payroll_sync()">Payroll Sync</a>
                                            @endif
                                        </div>
                                    </div>
                            <div class="card-body">
                 <!-- filter -->
                    <div
                    style="padding: 20px;border: 1px solid #d8d8d8;border-radius: 5px;margin-top: 50px;position: relative;">
                    <div style="position: absolute;top: -10px;font-size: 15px;font-weight: bold;background: white;">
                        Filter</div>
                    <div class="row">
                       <!--  <div class="col-md-4">
                            <div class="form-group">
                                <label for="location" class="language">Employee</label>
                               <select class="form-control enter_tab input_validasi select_data clearFilter" data-nextTab='1' name="employee" id="employee_id">
                                                   <option class="language">Choose</option>
                                               </select>
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal" class="language">Year</label>
                                <input type="text" id="years" name="years" class="form-control years input_validasi clearFilter" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location" class="language">Periode</label>
                                <input type="text" id="periode" name="periode" class="form-control input_validasi clearFilter" autocomplete="off">
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button onclick="load_data();" class="btn btn-primary btn-sm ">Filter</button>
                            <button onclick="clearFilter();" class="btn btn-default btn-sm ">Reset</button>
                            <button onclick="export_excel();" class="btn btn-success btn-sm language" id="export_excel" style="display: none;"><i class="fa fa-file-excel"></i> Export</button>


                        </div>
                    </div>
                </div>

            <!-- filter -->
        

                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <div class="table-responsive" id="list-gaji" style="display: none;">
                                     <table class="table table-striped table-bordered" id="attendace_list">
                    <thead>
                        <tr>
                            <th class="language">Nik</th>
                            <th class="language">Employee</th>
                            <th class="language">Total</th>
                        </tr>
                    </thead>
                    <tbody id="list-ready">
                        
                    </tbody>
                    
                </table>
                                </div>
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
<script src="{{URL::to('/')}}/assets/modul/select_delete/select_delete.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
<script type="text/javascript">
var errors = new error_massage();

$( function() {
    // $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Employee',token:$("input[name='_token']").val(),field:"select2_employee"});

    $( "#years" ).datepicker({
       format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    orientation: "bottom",
           autoclose: true

    })
     $( "#periode" ).datepicker({
       format: "MM",
    viewMode: "months", 
    minViewMode: "months",
        orientation: "bottom",
           autoclose: true

    })
});

function clearFilter(){
  $(".clearFilter").val(" ");
 // $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",token:$("input[name='_token']").val(),label:'Choose Employee',field:"select2_employee",open:true,tipe:1});
} 


$(document).ready(function () {
});
function load_data(){

 $("#list-gaji").css('display','none');
 $("#export_excel").css('display','none');


  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

      if(validasi1 == false){
         errors.loading({id:"#loading_alerts",type:'hide'});
         return;
      }else{

           var employee_id = $("#employee_id").val();
           var periode = $("#periode").val();
           var years = $("#years").val();

        $.ajax({
                    url:"{{url('/payroll/get-payroll-list')}}",
                    dataType: 'JSON',
                    method: 'POST',
                    data: {employee_id:employee_id,years:years,periode:periode,'_token': $("input[name='_token']").val()},
                    cache: false,
              
                    success: function(response) {
            
                      errors.loading({id:"#loading_alertsmodal",type:'hide'});
                      if(response.success == true){
                        var html=[];
                        $("#list-ready").html(" ");
                        $(response.content).each(function(idx,val){
                            console.log(val)

                            nama= "<td>"+val.name+"</td>";
                            nik= "<td>"+val.nik+"</td>";

                            if(val.json_data == 0){
                                totals = "<td>0</td>"; 
                            }else{
                                data = JSON.parse(val.json_data);

                                var sub1 = data.addition.reduce((currentTotal,item)=>{
                                    return parseInt(item.value) + parseInt(currentTotal);
                                 },0);


                                var sub2 = data.reduce.reduce((currentTotal,item)=>{
                                    return parseInt(item.value) + parseInt(currentTotal);
                                 },0);


                                subtotal = parseFloat(sub1)-parseFloat(sub2);
                                totals = "<td>"+errors.rupiahR(subtotal)+"</td>";

                            }

                            html.push("<tr>"+nik,nama,totals+"</tr>");

                        });


                         $("#list-ready").append(html.join(''));

                         $("#list-gaji").removeAttr("style");
                         $("#export_excel").removeAttr("style");


                          // errors.success({id:"#massage_errors",msg:response.msg});
                      }else{
                            errors.failed({id:"#massage_errors",msg:response.msg});
                      }
                       
                    },error: function (error) {
                        msg = JSON.stringify(error.responseJSON.message);
                        //msg = error.responseJSON.errors.email;
                        errors.loading({id:"#loading_alertsmodal",type:'hide'});
                        errors.failed({id:"#massage_errors",msg:msg});
                        $("#modal_finger_print").modal('hide');
                    }
               });
    }


}

function export_excel(){

   var validasi1 = $(".input_validasi").input_validasi({type:'required'});

      if(validasi1 == false){
         errors.loading({id:"#loading_alerts",type:'hide'});
         return;
      }else{

           var employee_id = $("#employee_id").val();
           var periode = $("#periode").val();
           var years = $("#years").val();

    $.ajax({
                    url:"{{url('/payroll/export-excel')}}",
                    dataType: 'JSON',
                    method: 'POST',
                    data: {employee_id:employee_id,years:years,periode:periode,'_token': $("input[name='_token']").val()},
                    cache: false,
                    success: function(response) {
                    
                      if(response.success == true){
                      let image= "{{URL::to('/')}}/payroll.xlsx";
                      errors.file_download(image);
                      }else{
                        alert("Export Excel Gagal");
                      }
                       
                    },error: function (error) {
                        msg = JSON.stringify(error.responseJSON.message);
                        //msg = error.responseJSON.errors.email;
                        errors.loading({id:"#loading_alertsmodal",type:'hide'});
                        errors.failed({id:"#massage_errors",msg:msg});
                        $("#modal_finger_print").modal('hide');
                    }
         });

  }

}


function payroll_sync(){

   $.ajax({
                    url:"{{url('/payroll/sync')}}",
                    dataType: 'JSON',
                    method: 'get',
                   
                    cache: false,
              
                    success: function(response) {
            
                      if(response.success == true){
                        alert("Sinkron Data Berhasil Total "+response.content);
                      }else{
                        alert("Sinkron Data Gagal");
                      }
                       
                    },error: function (error) {
                        msg = JSON.stringify(error.responseJSON.message);
                        //msg = error.responseJSON.errors.email;
                        errors.loading({id:"#loading_alertsmodal",type:'hide'});
                        errors.failed({id:"#massage_errors",msg:msg});
                        $("#modal_finger_print").modal('hide');
                    }
               });

    

}

</script>
@endpush

