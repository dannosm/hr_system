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
  <!-- Default Box -->



 <div class="row">

         
            <!-- /.box-header -->
            <!-- Box Body -->
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chd">
                           <div class="card-header d-flex">
                                        <h4 class="card-header-title language">Attendance List</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" onclick="absensi_update_data()" class="btn btn-primary btn-sm "><i class="fas fa-sync-alt"></i> <span class="language">Update Data</span></a>
                                        </div>
                                    </div>
            <div class="card-body" style="margin-top:-50px; ">

                  <!-- Default Box -->
                <div
                    style="padding: 20px;border: 1px solid #d8d8d8;border-radius: 5px;margin-top: 50px;position: relative;">
                    <div style="position: absolute;top: -10px;font-size: 15px;font-weight: bold;background: white;">
                        Filter</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location" class="language">Status</label>
                                <select id="location" name="location" class="form-control">
                                    <option value="" class="language">Pilih</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal" class="language">Date</label>
                                <input type="text" id="tanggal" name="tanggal" class="form-control">
                            </div>
                            <input type="hidden" id="start">
                            <input type="hidden" id="end">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location" class="language">Division</label>
                                <input type="text" class="form-control" id="no_order">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button onclick="filter();" class="btn btn-primary btn-sm ">Filter</button>
                            <button onclick="clearFilter();" class="btn btn-default btn-sm ">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- Box Body -->
        
            
          
             
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>

                                <div class="table-responsive">
                                     <table class="table table-striped table-bordered" id="attendace_list">
                    <thead>
                        <tr>
                            <th class="language">Name</th>
                            <th class="language">Check In</th>
                            <th class="language">Check Out</th>
                            <th class="language">Description</th>
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


        <!--  start modal  -->
    <div class="modal fade" id="modal_finger_print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title language" id="exampleModalLabel">Update Data</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                </div>
                <div class="modal-body">
                            <div id="loading_alertsmodal" class="col-md-12" align="center"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>

                   <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                   <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right language">Date Start</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" name="start" placeholder="date start" class="datepicker input_validasi" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right language">Date End</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" name="end" placeholder="date end" class="datepicker input_validasi" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Finger Print</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                            <input type="checkbox" id="finger_print_all" name="mesin_finger_all" value="all" checked= />&nbsp;<span class="language">All</span>
                                                
                                            </div>
                                        </div>
                        <div id="list_finger_print">

                            <div class="form-group row">
                                            <label class="col-12 col-sm-2 col-form-label text-sm-right">&nbsp;</label>
                                            <div class="col-12 col-sm-8 col-lg-8 list_finger_print_value">
                                           
                                                
                                            </div>
                                        </div>
                        </div>
                    </form>
              
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <a href="javascript:void(0)" id="saveAdd" class="btn btn-primary">Submit</a>
                </div>

            </div>
        </div>
    </div>

                    

        <!-- edn modal  -->
@csrf

@endsection

@push('footer')
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
<script type="text/javascript">
$( function() {
    $( ".datepicker" ).datepicker({
        format: "yyyy-mm-dd",
           autoclose: true,
        orientation: "bottom"
    })
});

$(document).ready(function () {
var errors = new error_massage();
finger_print_get_list();
//rooot firt
$("#list_finger_print").hide();
_nav();

 $('#attendace_list').DataTable({
    ordering: false,
    "processing": true,
    "serverSide": true,
    "ajax":{
        url :"{{url('/attendance/get')}}",
            type: "POST",
            data:{'_token': $("input[name='_token']").val()},            
        "dataSrc": function ( json ) {
            //Make your callback here.
            if(json.token_status=='valid'){
            
              return json.data;

            }
        }  
      },
    "columns":[
        {data:"name"},  
    {data:"check_in"},  
    {data:"check_out"},
    {data:"description"},  
    ],
    "columnDefs": [ {
            "targets": 0,
            "orderable": false
    } ],

    
} );

});

//rpute js
function _nav(){
    $("#finger_print_all").on('click',function(){ var params = this; select_finger_print(params);})
}
//endroot js
function absensi_update_data(){
    $("#modal_finger_print").modal('show');    
}

function select_finger_print(params){
        if($("#finger_print_all").is(":checked") == true){
            $("#list_finger_print").hide();
            $(".finger_list").prop("checked",true);
        }else{
            $("#list_finger_print").show();
            if(parseInt(list_fingerprint.length) < 1 ){
                finger_print_get_list();
            }
            $(".finger_list").prop("checked",false);
            return;
        }
}

var list_fingerprint = [];
function finger_print_get_list(){

     $.ajax({
                url:"{{url('/master-fingerprint/get-list')}}",
                dataType: 'JSON',
                method: 'POST',
                data:{'_token': $("input[name='_token']").val()},
                cache: false,
                success: function(response) {
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                        $(response.content).each(function(idx,val){
                            $(".list_finger_print_value").append("<input type='checkbox' name='mesin_finger[]' checked class='finger_list' value='"+val.id+"' /> "+val.name+' [Ip: '+val.ip,'] <br>');
                            list_fingerprint.push(val.id);
                        })
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

$("#saveAdd").click(function(){
  
  errors.loading({id:"#loading_alertsmodal",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
   
    var formData = new FormData($("#form2")[0]);
    var formDataSerialized = $("#form2").serialize();

     $.ajax({
                url:"{{url('/attendance/update-data')}}",
                dataType: 'JSON',
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
        
                  errors.loading({id:"#loading_alertsmodal",type:'hide'});
                  if(response.success == true){
                     

                       errors.success({id:"#massage_errors",msg:response.msg});
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
});
</script>




@endpush

