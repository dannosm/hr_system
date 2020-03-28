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
                                        <h4 class="card-header-title language big-text">PERMISSION</h4>
                                        <div class="toolbar ml-auto">
                                         @if(session()->get('roles')[2]->role_delete == 1)
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm language" id="deleteBtn">Delete</a>
                                        @endif
                                        @if(session()->get('roles')[2]->role_write == 1)
                                            <a href="{{url('/permission/add')}}" class="btn btn-primary btn-sm "><i class="fa fa-plus"></i><span class="language" > Add</span></a>
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
                            <th class="language">Employee</th>
                            <th class="language">Category</th>
                            <th class="language">Date Start</th>
                            <th class="language">Date End</th>
                            <th class="language">Days</th>
                            <th class="language">Description</th>
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
@csrf

@endsection


@push('footer')
<script type="text/javascript">
var errors = new error_massage();
$("#select_all").select_delete({buttons:'#deleteBtn',select_child:'.child',urls:"{{url('permission/delete')}}",token:$("input[name='_token']").val()});

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
        url :"{{url('/permission/get')}}",
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
    {data:"category"},
    {data:"date_start"},  
    {data:"date_end"},
    {data:"days"},
    {data:"description"},

    { data: null, render: function ( data, type, row ) {
            let id = "{{URL::to('/')}}/permission/edit/"+data['id'];
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



</script>
@endpush

