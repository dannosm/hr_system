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
                                        <h4 class="card-header-title language">ADD GROUP ROLE</h4>

                                        <div class="toolbar ml-auto">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm language" id="saveAdd"><i class="fa fa-save"></i> Save</a>
                                            <a href="{{url('/group-role')}}" class="btn btn-dark btn-sm language"><i class="fas fa-sign-out-alt"></i> Back</a>
                                        </div>
                                    </div>
                            <div class="card-body">
                            <!--card-body-->
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>
                                <form action="#" id="form2" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                        <input type="hidden" name="group_role_id" value="">
                                        <div class="form-group row">
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Group Name</label>
                                            <div class="col-9 col-lg-10">
                                                <input type="text" class="form-control enter_tab input_validasi " data-nextTab='1'  placeholder="Group Name" name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row statuss" >
                                            <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right language">Status</label>
                                            <div class="col-9 col-lg-10">
                                               <select name="status" class="form-control input_validasi">
                                                <option value="enable" class="language">Enable</option>
                                                <option value="disable" class="language">Disable</option>
                                                 
                                               </select>
                                            </div>
                                        </div>
                                     
                                        <div style="overflow: auto;display: none;" class="table-role">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                              <th>Role</th>
                                              <th><input type="checkbox" name="select_read" id="read_all" value="">  Read </th>
                                              <th><input type="checkbox" name="select_write" id="write_all" value="">  Write</th>
                                              <th><input type="checkbox" name="select_delete" id="delete_all" value="">  Delete</th>
                                            </tr>
                                          </thead>
                                          <tbody class="list-role">
                        
                                          </tbody>
                                        </table>
                                      </div>
                                </form>
                                       
                            <!--end card body-->
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>
                <!--end row-->


@endsection

@push('footer')
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>


<script type="text/javascript">
    var errors = new error_massage();
    $(".enter_tab").enter_tab();

$("#lastButton").keyup(function(e){
     if (e.keyCode == 13) {
        $("#saveAdd").trigger('click');
     }
})   

$("#saveAdd").click(function(){
   errors.loading({id:"#loading_alerts",type:'show'});
  var group_id = $("input[name='group_role_id']").val();
  

//validasi apakah sudah buat group name
  if(group_id == ''){
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
                  url:"{{url('/group-role/save')}}",
                  dataType: 'JSON',
                  method: 'POST',
                  data: formData,
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(response) {
          
                    errors.loading({id:"#loading_alerts",type:'hide'});
                    if(response.success == true){
                        // $("input.form-control").val("");
                         //$("textarea.form-control").val("");
                         $("input[name='group_role_id']").val(response.content);
                         $(".statuss").css({'display':'none'});
                         $(".table-role").removeAttr('style');
                         $(".table-role").css({'overflow':'auto'});

                         get_detail_role();
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

    }else{

      

     if(list_role.length == 0){
        errors.loading({id:"#loading_alerts",type:'hide'});
        return;
     }else{
       

         $.ajax({
                    url:"{{url('/group-role/save')}}",
                    dataType: 'JSON',
                    method: 'POST',
                    data: {group_id:group_id,detail_role:list_role,'_token': $("input[name='_token']").val()},
                    cache: false,
                    success: function(response) {
            
                      errors.loading({id:"#loading_alerts",type:'hide'});
                      if(response.success == true){
                          
                         errors.success({id:"#massage_errors",msg:response.msg});
                         location.reload();

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

});

var list_role = [];
function get_detail_role(){

   $.ajax({
                  url:"{{url('/role/get-raw')}}",
                  dataType: 'JSON',
                  method: 'GET',
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(response) {
          
                    errors.loading({id:"#loading_alerts",type:'hide'});
                    if(response.success == true){
                      
                        $(response.content).each(function(idx,val){
                          list_role.push({role_id:val.role_id,write:0,read:0,delete:0});


                          $(".list-role").append(

                              "<tr>"
                              +"<td>"+val.role_name+"</td>"
                              +"<td><input type='checkbox' name='"+val.role_id+"' value='read' class='select_role select_reads' /></td>"
                              +"<td><input type='checkbox' name='"+val.role_id+"' class='select_role select_writes' /></td>"
                              +"<td><input type='checkbox' name='"+val.role_id+"' value='delete' class='select_role select_deletes' /></td>"
                              +"</tr>"
                          );

                        });

                        call_select();

                        console.log(list_role)
                        
                      $cbs=$("#read_all").change(function () {


                       $(".select_reads").prop('checked',this.checked);
                       $('.select_role').trigger('change')
                      })


                      $cbs=$("#write_all").change(function () {


                       $(".select_writes").prop('checked',this.checked);
                       $('.select_role').trigger('change')
                      })


                      $cbs=$("#delete_all").change(function () {


                       $(".select_deletes").prop('checked',this.checked);
                       $('.select_role').trigger('change')
                      })

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

function call_select(){

$(".select_role").on('click change',function(){
  var param  = $(this);
  id = param.attr('name');
  name = param.val();
    if(param.is(":checked")){

      var role = list_role.find(role => role.role_id == id)
      if(typeof role !== 'undefined'){

          if(name == 'write'){
            role.write = 1;
          }else if(name == 'read'){
            role.read = 1;
          }else{
            role.delete = 1;
          }
      }

    }else{

       var role = list_role.find(role => role.role_id == id)
      if(typeof role !== 'undefined'){

          if(name == 'write'){
            role.write = 0;
          }else if(name == 'read'){
            role.read = 0;
          }else{
            role.delete = 0;
          }
      }

    }

    console.log(list_role);
})

}



</script>
@endpush
