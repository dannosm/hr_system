<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\salaryAttributeModel;
use Auth;


class payrollController extends Controller
{

    /*payroll setting start*/

     public function payroll_salary_attribute(){
    	 return view('payroll.payroll_setting');
     }

     function payroll_setting_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = salaryAttributeModel::salary_attribute_get($request);
			$total = $data->count();

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
        return $data;

    }


    /*payroll setting end*/

    public function payrol_print(){
    	 return view('employee.employee');
    }

}
