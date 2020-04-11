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
                                        <h4 class="card-header-title">SHIFT MASTER</h4>
                                        <div class="toolbar ml-auto">
                                            
                                            
                                            @if(session()->get('roles')[10]->role_delete == 1)
                                            <a href="#" class="btn btn-danger btn-sm language" id="deleteBtn">Delete</a>
                                            @endif
                                            @if(session()->get('roles')[10]->role_read == 1)
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm language" id="printBtn">Print</a>
                                            @endif
                                            @if(session()->get('roles')[10]->role_write == 1)
                                            @if($sync == 0)
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm language" onclick="sync_()">Shifting</a>
                                            @endif
                                            <a href="{{url('/shift-setting')}}" class="btn btn-success btn-sm language">Setting</a>
                                            <a href="{{url('/shift/add')}}" class="btn btn-primary btn-sm language"><i class="fa fa-plus"></i> Add</a>
                                            @endif

                                        </div>
                                    </div>
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <div class="table-responsive ov-hd">
                                     <table class="table table-striped table-bordered" id="attendace_list">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" name="select_all" title="checked all" ></th>
                            <th class="language">Name</th>
                            <th class="language">Check In</th>
                            <th class="language">Check out</th>
                            <th class="language">Late Limit</th>
                            <th class="language">Option</th>
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


<!-- module print -->

<div id="coba">
    <style>
#customerss {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customerss td, #customerss th {
    border: 1px solid #ddd;
    padding: 8px;
}


#customerss tr:nth-child(even){background-color: #f2f2f2;}

#customerss tr:hover {background-color: #ddd;}

#customerss th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}


#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
}

#customers td, #customers th {
    padding: 8px;
}


#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

.bo{
    border: none;
}



</style>
</div>
<div id="printarea" style="display: none;">
<!--     <table id="customers">

  <tr>
    <td align="left" valign="top">
     <img src="/images/btktype.png" alt="BTKMART">
    </td>
    <td align="left" valign="bottom" style="font-size:30px;font-weight: bold;float: left; margin-top:30px;margin-left: -50%" class="language">JADWAL SHIFT KARYAWAN</td>
  </tr>
</table>  

<br> -->
<br>


 <table class="table table-striped table-bordered" id="customerss">
    <thead>
                     <tr style="border: none;">
                        <td colspan="3" align="center" style="border: none;"><h4>JADWAL SHIFT KARYAWAN<BR>Bulan : {{date("F Y")}}</h4></td>
                    </tr>
    </thead>
    <tbody id="list_shift">

    </tbody>
                            
</table>
</div>

<!-- end module print-->
@csrf

@endsection

@push('footer')
<script src="{{URL::to('/')}}/assets/modul/select_delete/select_delete.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
<script type="text/javascript">
var errors = new error_massage();
$("#select_all").select_delete({buttons:'#deleteBtn',select_child:'.child',urls:"{{url('shift/delete')}}",token:$("input[name='_token']").val()});

$(document).ready(function () {
load_data();
});


function load_data(){
 $('#attendace_list').DataTable().destroy();
 $('#attendace_list').DataTable({
    ordering: false,
    "processing": true,
    "serverSide": true,
    "ajax":{
        url :"{{url('/shift/get')}}",
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
    { data: null, render: function ( data, type, row ) {
                
              return '<input class="child" type="checkbox" name="user_target_id[]" onclick="unCheck()" value="'+data['id']+'" >';
            } },
    {data:"name"},  
    {data:"time_in"},  
    {data:"time_out"},
    {data:"late_limit"},  

    { data: null, render: function ( data, type, row ) {
            // Combine the first and last names into a single table field
            let id = "{{URL::to('/')}}/shift/edit/"+data['id'];
            return '<a href="'+id+'" class="btn btn-rounded btn-primary language">Edit</a>';
        } },
    ],
    "columnDefs": [ {
            "targets": 0,
            "orderable": false
    } ],

    
} );

}

function unCheck(){
    var $submit = $("#deleteBtn").hide(),   
    $cbs=$('.child').change(function () {
   // $("input:checkbox.child").prop('checked',this.checked);
    $submit.toggle( $cbs.is(":checked") );
    document.getElementById("select_all").checked = false;
  });
}


$("#printBtn").click(function(){

    $.ajax({
        url:"{{('/shift/print')}}",
        type:"POST",
        data:{_token:$("input[name='_token']").val(),tipe:'print'},
        dataType:"JSON",
        cache:false,
        success:function(response){

            
            if(response.success == true){   

                var html_td = [];    
                var html_head ="";
                $("#list_shift").html(" ");     
                $(response.content).each(function(idx,val){
                    html_td.push("<tr><td>"+val.id+"</td><td>"+val.name+"</td><td>"+val.shift_name+"</td></tr>");
                })
                html_head = "<tr><td width='1'>NIK</td><td>NAME</td><td>SHIFT</td></tr>";
                $("#list_shift").append(html_head+html_td.join(""));

                 $("#printarea").removeAttr('style');
                  newWin= window.open();
                  newWin.document.write(document.getElementById('coba').innerHTML);
                  newWin.document.write(document.getElementById('printarea').innerHTML);
                  newWin.document.close();
                  newWin.focus();
                  //newWin.print();
                  //newWin.document.close();
                   setTimeout(function(){ 
                  newWin.print();

                    newWin.document.close();
                $("#printarea").css('display','none');

                   }, 1000);

            }
        },
        errors:function(error){

        }
    });
});


function sync_(){
     $.ajax({
        url:"{{('/shift/print')}}",
        type:"POST",
        data:{_token:$("input[name='_token']").val(),tipe:'sycn'},
        dataType:"JSON",
        cache:false,
        success:function(response){
            if(response.success == true){

                 alert("Update Shift Berhasil");

            }else{
                 alert(response.msg);
            }
        },
        errors:function(error){

        }
    });
}
</script>
@endpush

