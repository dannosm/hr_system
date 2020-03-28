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
                                        <h4 class="card-header-title language">Role</h4>
                                        <div class="toolbar ml-auto">

                                            @if(session()->get('roles')[5]->role_delete == 1)
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm language" id="deleteBtn">Delete</a>
                                            @endif
                                            @if(session()->get('roles')[5]->role_write == 1)
                                                 <a href="{{url('/group-role/add')}}" class="btn btn-primary btn-sm language"><i class="fa fa-plus"></i> Add</a>
                                            @endif
                                        </div>
                                    </div>
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <div class="table-responsive">
                                     <table class="table table-striped table-bordered" id="attendace_list">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" name="select_all" title="checked all" ></th>
                            <th class="language">Group Name</th>
                            <th class="language">Status</th>
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
<script src="{{URL::to('/')}}/assets/modul/select_delete/select_delete.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
<script type="text/javascript">
var errors = new error_massage();
$("#select_all").select_delete({buttons:'#deleteBtn',select_child:'.child',urls:"{{url('group-role/delete')}}",token:$("input[name='_token']").val()});

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
        url :"{{url('/group-role/get')}}",
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
             let id = data['group_role_id'];
              return '<input class="child" type="checkbox" name="user_target_id[]"  onclick="unCheck()" value="'+id+'">';
            } },
    {data:"group_name"},  
    {data:"status"},
    { data: null, render: function ( data, type, row ) {
            // Combine the first and last names into a single table field
            let id = "{{URL::to('/')}}/group-role/edit/"+data['group_role_id'];
            return '<a href="'+id+'" class="btn btn-rounded btn-primary">Edit</a>';
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

