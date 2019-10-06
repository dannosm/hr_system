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
                                        <h4 class="card-header-title language big-text">Salary Attribute</h4>
                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm language" id="deleteBtn">Delete</a>
                                           <!--  <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dmodalx"><i class="fa fa-plus" ></i> <span class="language" >Add</span>Modul</a> -->
                                            <a href="{{url('/payroll-setting/add')}}" class="btn btn-primary btn-sm "><i class="fa fa-plus"></i> <span class="language" >Add</span>Attribute</a>
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
                            <th class="language">Name</th>
                            <th class="language">Module</th>
                            <th class="language">Type</th>
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

                <div id="modalx"> </div>
@csrf

@endsection
@push('footer')
<script src="{{URL::to('/')}}/assets/modul/select_delete/select_delete.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/dmodal/dmodal.js"></script>

<script type="text/javascript">
var errors = new error_massage();

$("#select_all").select_delete({buttons:'#deleteBtn',select_child:'.child',urls:"{{url('payroll-setting/delete')}}",token:$("input[name='_token']").val()});

$(document).ready(function () {
    load_data();
    addModul();
});

function load_data(){
 $('#attendace_list').DataTable().destroy();
$('#attendace_list').DataTable({
    ordering: false,
    "processing": true,
    "serverSide": true,
    "ajax":{
        url :"{{url('/payroll-setting/get')}}",
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
             let id = data['id'];
              return '<input class="child" type="checkbox" name="user_target_id[]"  onclick="unCheck()" value="'+id+'">';
            } },
    {data:"name"}, 
    {data:"module_name"}, 
     { data: null, render: function ( data, type, row ) {
            // Combine the first and last names into a single table field
           var status = data['type'];

           if(status == 1){
            return "<span class='language'>Additon</span>";
           }else{
            return "<span class='language'>Deduction</span>";
           }
        } }, 
    {data:"status"},  
    { data: null, render: function ( data, type, row ) {
            // Combine the first and last names into a single table field
            let id = "{{URL::to('/')}}/payroll-setting/edit/"+data['id'];
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

function addModul(){

    dmodal.get_modal({
        "div_id":"#modalx",
       "title":"Add Modul Attribute",
       "bclose":[{label:'Close'}],
       "bsave":[{label:'Save',onclick:"modul_save()"}],
        "field":[
                {type:'select',name:"attribute",class:"form-control select_attribute",id:'',value:""},
                {type:'select',name:"attribute",class:"form-control select_salary_module",id:'',value:""},
        ],    
    })

    $(".select_attribute").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Attribute',token:$("input[name='_token']").val(),field:"select_attribute_salary"});
    $(".select_salary_module").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Module',token:$("input[name='_token']").val(),field:"select_salary_module"});


}

function modul_save(){
    errors.loading({id:"#loading_alerts",type:'show'});
  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

 if(validasi1 == false){
    errors.loading({id:"#loading_alerts",type:'hide'});
    return;
 }else{
   
    var formData = new FormData($("#form-dmodal")[0]);
    var formDataSerialized = $("#form-dmodal").serialize();

     $.ajax({
                url:"{{url('/payroll-setting/save')}}",
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
                       $("textarea.form-control").val("");

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

}

</script>
@endpush

