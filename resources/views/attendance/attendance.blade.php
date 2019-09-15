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
                                        <h4 class="card-header-title">Attendance List</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="#" class="btn btn-success btn-sm"><i class="fas fa-play"></i> Finger Print</a>
                                            <a href="#" class="btn btn-primary btn-sm "><i class="fas fa-sync-alt"></i> Update Data</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                     <table class="table table-striped table-bordered" id="attendace_list">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Description</th>
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

$(document).ready(function () {


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
</script>
@endpush

