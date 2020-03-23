<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\salaryAttributeModel;
use App\salaryModuleDetailModel;
use App\payrollModel;
use App\attendanceModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Auth;


class payrollController extends Controller
{

    /*payroll setting start*/

     public function payroll_salary_attribute(){
    	 return view('payroll.payroll_setting');
     }

     public function payroll(){
        if($this->authSession(6,'r') == 1){return redirect('home');}
         return view('payroll.payroll');
     }


      public function index(){
        
        if($this->authSession(6,'r') == 1){return redirect('home');}
         return view('payroll.payroll_print');
     }

     function payroll_setting_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = salaryAttributeModel::salary_attribute_get($request);
			$total = salaryAttributeModel::salary_attribute_get_count($request)->count();

		    $output['draw']=$draw;
            if($total){
                $output['recordsTotal']=$output['recordsFiltered']=$total;
            }else{
                $output['recordsTotal']=$output['recordsFiltered']=$draw;   
            }
            $output['success']=TRUE;
            $output['token_status']='valid';
            $output['data'] = $data;
          
			echo json_encode($output);
		} catch (Exception $e) {
			echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));			
		}
    }

    
   public function payroll_setting_add(){
    	 return view('payroll.payroll_setting_add');
     }

   function payroll_setting_save(Request $request){

    	 try{
        	$user = Auth::user();
            $add = new salaryAttributeModel;
            $add->name = $request->get('name');
            $add->type = $request->get('type');
            $add->creator = $user->id;
            $result = $add->save();

            if(!empty($request->get('modul'))){

                $modul = new salaryModuleDetailModel();
                $modul->salary_module_id = $request->get('modul');
                $modul->salary_attribute_id = $add->id;
                $modul->save();

            }
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        } 

    }

    public function payroll_setting_edit($id){

         $data = salaryAttributeModel::salary_attribute_get_by_id($id);
         return view('payroll.payroll_setting_edit')->with('data',$data[0]);
    }

    function payroll_setting_update(Request $request){
        try{

             $user = Auth::user();
             $add = salaryAttributeModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->type = $request->get('type');
             $add->status = $request->get('status');
             $add->creator = $user->id;

              if(!empty($request->get('modul'))){
                $add->module_id = $request->get('modul');
            }
             $result = $add->save();
            
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


     function payroll_setting_delete(Request $request){
        try{
            
            $delete = salaryAttributeModel::salary_attribute_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function payroll_salary_attribute_get(Request $request){

        $data = salaryAttributeModel::salary_attribute_get_status_active($request);
        $data2 = salaryAttributeModel::salary_attribute_get_status_active_module_id($request);

        return array("data"=>$data,"data2"=>$data2);

    }


    /*payroll setting end*/

    public function payrol_print(){
    	 return view('employee.employee');
    }


    public function payroll_get_data(Request $request){
         try{
            
           

           if($this->authSession(6,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}


            $get_data_payroll =  payrollModel::payroll_get_data_by_id($request);

            if(!empty($get_data_payroll)){
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$get_data_payroll, 'success'=>TRUE));    
            }else{
             return json_encode(array('msg'=>'Data Tidak Ditemukan', 'content'=>"Data Tidak Ditemukan", 'success'=>FALSE));    
            }
              
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        } 
    }


    public function get_list_payroll(Request $request){
         try{
            
           

           if($this->authSession(6,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}


            $get_data_payroll =  payrollModel::get_payroll_list($request);

            if(!empty($get_data_payroll)){
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$get_data_payroll, 'success'=>TRUE));    
            }else{
             return json_encode(array('msg'=>'Data Tidak Ditemukan', 'content'=>"Data Tidak Ditemukan", 'success'=>FALSE));    
            }
              
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        } 
    }


    public function payroll_sync(Request $request){
        try{
            
           if($this->authSession(6,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

        //get attribute salary by company
           $payroll = array();
           $pending = array();
           $data = salaryAttributeModel::salary_attribute_get_by_employee();
           $att = attendanceModel::attendance_calculate_late(date('m'),date('Y'));


           foreach ($data as $key => $value) {
                $nilai =0;
                if($value->value !== '' || !empty($value->value)){
                    $nilai =$value->value;
                }

                if($value->module_id !=0){
                     
                     $pending[$value->employee_id][] = array('type'=>$value->type,'extensions_value'=>$value->extensions_value,'id'=>$value->salary_attribute_id,'extensions'=>$value->extensions,'title'=>$value->name);
                }

                if($value->type == 1){
                    if($value->module_id ==0){
                        $payroll[$value->employee_id]['addition'][]  = array('id' => $value->salary_attribute_id,'title'=>$value->name,'value' => $nilai); 
                   }
                }else{

                    if($value->module_id ==0){
                        $payroll[$value->employee_id]['reduce'][]  =  array('id' => $value->salary_attribute_id,'title'=>$value->name,'value' => $nilai);
                    }  
                }   
           }

           //echo json_encode($payroll[1]);

           //detele buulan yang sama 

           $delete = payrollModel::payroll_sync_delete_month(date('Y'),date('m'));

           foreach ($payroll as $key => $value) {
        
                foreach ($pending[$key] as $keys => $values) {
                    $model_name = 'App\Http\Controllers\ '.$values['extensions'];
                    $model_name = str_replace(' ', '', $model_name);
                    $values['employee_id'] = $keys;
                    $values['att'] = $att;

                    $nilai = $model_name::getResultExtensions($values,$value);

                    
                    if($values['type'] == 1){
                       $value['addition'][]  = array('id' => $values['id'],'title'=>$values['title'],'value' => $nilai);
                    }else{
                        $value['reduce'][]  =  array('id' => $values['id'],'title'=>$values['title'],'value' => $nilai);
                    }

                }

              
                $add = New payrollModel;
                $add->employee_id = $key;
                $add->sync_date = date("Y-m-d");
                $add->json_data = json_encode($value);
                $add->save();

           }
         
         return json_encode(array('msg'=>'Sava Data Success', 'content'=>count($payroll), 'success'=>TRUE));    
            
              
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        } 
    }



    public function payroll_export_to_excel(Request $request){

        $get_data_payroll =  payrollModel::get_payroll_list($request);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'NAME');
        $sheet->setCellValue('C1', 'TOTAL');
        $i = 1;

        foreach ($get_data_payroll as $key => $value) {
            $data = json_decode($value->json_data,true);
            $sub1 = 0;
            $sub2 = 0;
            $total = 0;
            if(!empty($data)){    
                foreach ($data['addition'] as $k => $val) {
                    $sub1 +=$val['value'];
                }
                foreach ($data['reduce'] as $ks => $vals) {
                    $sub2 +=$vals['value'];
                }
                $total = $sub1-$sub2;
            }
                $i++;
                $sheet->setCellValue('A'.$i,$value->nik);
                $sheet->setCellValue('B'.$i, $value->name);
                $sheet->setCellValue('C'.$i, number_format($total,0,'.',','));


        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('payroll.xlsx');

     
        return json_encode(array('msg'=>'Sava Data Success', 'content'=>"", 'success'=>TRUE));    


    
    }

}
