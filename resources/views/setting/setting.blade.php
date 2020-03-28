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
<style>
{
  box-sizing: border-box;
}

.zoom:hover {
  -ms-transform: scale(5.5); /* IE 9 */
  -webkit-transform: scale(5.5); /* Safari 3-8 */
  transform: scale(5.5); 
}
</style>
 <div class="row">
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chd">
                           <div class="card-header d-flex">
                                        <h4 class="card-header-title">SETTINGS</h4>
                                        <div class="toolbar ml-auto">

                                            @if(session()->get('roles')[18]->role_delete == 1)
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm language" id="deleteBtn">Delete</a>
                                            @endif

                                            @if(session()->get('roles')[18]->role_write == 1)
                                            <a href="{{url('/setting/add')}}" class="btn btn-primary btn-sm language"><i class="fa fa-plus"></i> Add</a>
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
                            <th class="language">Name</th>
                            <th class="language">Type</th>
                            <th class="language">Value</th>
                            <th class="language">Setting</th>
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
$("#select_all").select_delete({buttons:'#deleteBtn',select_child:'.child',urls:"{{url('division/delete')}}",token:$("input[name='_token']").val()});

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
        url :"{{url('/setting/get')}}",
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
    {data:"type"},  
    { data: null, render: function ( data, type, row ) {
             let id = data['type'];
             var setting = setting_modul_type(data);
              return setting[0].image;

            } },
     { data: null, render: function ( data, type, row ) {
             let id = data['type'];
             var setting = setting_modul_type(data);
              return setting[0].settings;
            } },
    { data: null, render: function ( data, type, row ) {
        //Combine the first and last names into a single table field
            //let id = "{{URL::to('/')}}/setting/save-modul/"+data['id'];
            return '<a href="javascript:void(0)" onclick="setting_modul_save('+data['id']+')" class="btn btn-rounded btn-primary">Simpan</a>';
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

function setting_modul_type(data){
    var setting = [];
    switch(data['type']) {
      case 'image':
        images = '<img src="images/'+data['image']+'" alt="" class="user-avatar-md rounded-circle zoom">';
        settings = ' <form action="#" id="form_'+data['id']+'" class="form-horizontal" enctype="multipart/form-data">'
                    +'<input type="hidden" name="type" value="'+data['type']+'" />'
                    +'<input type="file" name="gambar" id="gambar_upload" />'
                    +'</form>';
        setting.push({image:images,settings:settings});
        break;
        case 'text':
        setting.push({image:"cinta",settings:"dsadsadasd"});
        break;
        default:
        setting.push({image:"cinta",settings:"dsadsadasd"});
        break;
    }

    return setting;



}


  
function setting_modul_save(id){
     var formData = new FormData($("#form_"+id)[0]);
     var formDataSerialized = $("#form_"+id).serialize();
     formData.append('_token', $("input[name='_token']").val());
     formData.append('id', id);

     $.ajax({
                url:"{{url('/setting/modul-save')}}",
                dataType: 'JSON',
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
        
                  errors.loading({id:"#loading_alerts",type:'hide'});
                  if(response.success == true){
                       $("input.form-control").val("");
                       $("input[type='file']").val("");
                       load_data();
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

</script>
@endpush

