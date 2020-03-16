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
                                        <h4 class="card-header-title language">Payslip
                                        </h4>

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
                                <label for="location" class="language">Employee</label>
                               <select class="form-control enter_tab input_validasi select_data clearFilter" data-nextTab='1' name="employee" id="employee_id">
                                                   <option class="language">Choose</option>
                                               </select>
                            </div>
                        </div>
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
                            <button onclick="payslip_print();" class="btn btn-success btn-sm language" id="btn_print" style="display: none;">Print</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- Box Body -->
        
            
                            <div class="card-body">
                            <div id="massage_errors"></div>
                            <div id="loading_alerts" class="col-md-12" align="center"></div>

                                <div class="table-responsive " id="div_payslip" style="display: none;">
                                     <table class="table table-striped table-bordered" >
                                        <thead>
                                            <tr >
                                                <th class="language th1" style="border-right: none;">BTKMART</th>
                                                <th class="language th2" colspan="3" style="border-left: none;text-align:center;">Payslip</th>

                                            </tr>
                                             <tr>
                                                <td class="language head1" >Date </td>
                                                <td class="language head2 slip_date" colspan="3" id="slip_date">: </td>
                                            </tr>

                                             <tr>
                                                <td class="language" >Name </td>
                                                <td class="language employee_name" colspan="3" id="employee_name">: </td>
                                            </tr>
                                             <tr>
                                                <td class="language" >Division </td>
                                                <td class="language employee_division" colspan="3" id="employee_division">: </td>
                                            </tr>
                                             <tr>
                                                <td class="language" >Position </td>
                                                <td class="language employee_position" colspan="3" id="employee_position">: </td>
                                            </tr>
                                             <tr>
                                                <td class="language" >NIK </td>
                                                <td class="language employee_nik" colspan="3" id="employee_nik">:</td>
                                            </tr>
                                            
                                        </thead>
                                        <tbody class="list-ready">

                                           
                                            
                                        </tbody>
                                        <tfoot>
                                         <tr>
                                                <td class="language" >Sub Total I </td>
                                                <td class="language"  id="subtotal_I"></td>
                                                <td class="language" >Sub Total II </td>
                                                <td class="language"  id="subtotal_II"></td>
                                            </tr>
                                        </tfoot>
                                        
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
    <table id="customers">

  <tr>
    <td align="left" valign="top">
     <img src="/images/btktype.png" alt="BTKMART">
    </td>
    <td align="left" valign="bottom" style="font-size:30px;font-weight: bold;float: left; margin-top:30px;margin-left: -50%" class="language">PAYSLIP</td>
  </tr>
</table>  

<br>
<br>


 <table class="table table-striped table-bordered" id="customerss">
                <thead>
                     <tr>
                        <td class="language head1 bo" style="border: none;">Date </td>
                        <td class="language head2 slip_date " style="border: none;" colspan="3">: </td>
                    </tr>

                     <tr>
                        <td class="language bo" style="border: none;">Name </td>
                        <td class="language employee_name bo" style="border: none;" colspan="3" >: </td>
                    </tr>
                     <tr>
                        <td class="language" style="border: none;">Division </td>
                        <td class="language employee_division" style="border: none;" colspan="3">: </td>
                    </tr>
                     <tr>
                        <td class="language" style="border: none;">Position </td>
                        <td class="language employee_position" colspan="3" style="border: none;">: </td>
                    </tr>
                     <tr>
                        <td class="language" style="border: none;" >NIK </td>
                        <td class="language employee_nik" colspan="3" style="border: none;">:</td>
                    </tr>
                    
                </thead>
                <tbody class="list-ready">

                   
                    
                </tbody>
                <tfoot>
                 <tr>
                        <td class="language" >Sub Total I </td>
                        <td class="language"  id="subtotal_I">:</td>
                        <td class="language" >Sub Total II </td>
                        <td class="language"  id="subtotal_II">:</td>
                    </tr>
                </tfoot>
                            
</table>
<table style="margin-right: 5%;float: right;">
  <tr>
    <td><?php date("Y F d") ;?><br>Hrd Signature</td>
  </tr>
</table>
</body>
</div>

@csrf

@endsection

@push('footer')
 <script src="{{URL::to('/')}}/assets/modul/input_validasi/input_validasi.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/enter_tab/enter_tab.js"></script>
 <script src="{{URL::to('/')}}/assets/modul/error_massage/error_massage.js"></script>

<script type="text/javascript">

$( function() {
    
     $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Employee',token:$("input[name='_token']").val(),field:"select2_employee"});

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

function load_data(){

 $("#btn_print").css('display','none');
 $("#div_payslip").css('display','none');

  var validasi1 = $(".input_validasi").input_validasi({type:'required'});

      if(validasi1 == false){
         errors.loading({id:"#loading_alerts",type:'hide'});
         return;
      }else{

           var employee_id = $("#employee_id").val();
           var periode = $("#periode").val();
           var years = $("#years").val();

           console.log(employee_id,periode,years);


        $.ajax({
                    url:"{{url('/payroll/get-data')}}",
                    dataType: 'JSON',
                    method: 'POST',
                    data: {employee_id:employee_id,years:years,periode:periode,'_token': $("input[name='_token']").val()},
                    cache: false,
              
                    success: function(response) {
            
                      errors.loading({id:"#loading_alertsmodal",type:'hide'});
                      if(response.success == true){

                    var detail = response.content[0];
                        $(".slip_date").text(': '+detail.slip_date);
                        $(".employee_name").text(': '+detail.name);
                        $(".employee_position").text(': '+detail.positions);
                        $(".employee_division").text(': '+detail.division);
                        $(".employee_nik").text(': '+detail.nik);

                         var data = response.content[0].json_data; 
                            data  = JSON.parse(data);
                         var reduce = data.reduce;
                         var addtion = data.addition;

                         if(reduce.length > addtion.length){
                            var xcount = reduce.length; 
                            var wcount = addtion.length;
                            var tipe = 'r';  
                         }else{
                            var xcount = addtion.length;
                            var wcount = reduce.length;
                            var tipe = 'a';
                         }
                         tbody =[];
                         $('.list-ready').html("");
                         for (var i = 0; i < xcount; i++) {
                            if(tipe == 'a'){

                                 var add = '<td>'+addtion[i].title+'</td><td> Rp '+errors.rupiahR(addtion[i].value)+'</td>';

                                 if(i+1 > wcount){
                                     var red = "<td></td><td></td>";
                                 }else{
                                    var red = '<td>'+reduce[i].title+'</td><td> Rp '+errors.rupiahR(reduce[i].value)+'</td>';
                                 }

                            }else{

                                 if(i+1 > wcount){
                                     var add = "<td></td><td></td>";
                                 }else{
                                     var add = '<td>'+addtion[i].title+'</td><td> Rp '+errors.rupiah(addtion[i].value)+'</td>';
                                 }
                                 var red = '<td>'+reduce[i].title+'</td><td> Rp '+errors.rupiahR(reduce[i].value)+'</td>';

                            }


                            tbody.push("<tr>"+add,red+"</tr>");
                         }

                         var items1 = data.reduce;
                         var sub1 = items1.reduce((currentTotal,item)=>{
                            console.log(item.value,item)
                            return parseInt(item.value) + parseInt(currentTotal);
                         },0);
                        $("#subtotal_II").text("Rp "+errors.rupiahR(sub1));

                        var items2 = data.addition;
                         var sub2 = items2.reduce((currentTotal,item)=>{
                            console.log(item.value,item)
                            return parseInt(item.value) + parseInt(currentTotal);
                         },0);
                        $("#subtotal_I").text("Rp "+errors.rupiahR(sub2));

                         $(".list-ready").append(tbody.join());

                         $("#btn_print").removeAttr("style");
                         $("#div_payslip").removeAttr("style");


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

function payslip_print(){
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

function clearFilter(){
  $(".clearFilter").val(" ");
  $(".select_data").select2_modified({url:"{{url('/select2/get-raw')}}",label:'Choose Employee',field:"select2_employee",open:true,tipe:1});
}

</script>




@endpush

