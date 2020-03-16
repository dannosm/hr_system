<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\salaryModuleModel as salaryModule;
use App\salaryModuleDetailModel as 	salaryMDetail;

class extensionAttendanceController extends Controller
{
    function extension_attendance_save(Request $request){
        try{
           
           if($this->authSession(9,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}
        	$user = Auth::user();
            
            $add = salaryModule::where('id', $request->get('id'))->firstOrFail();
            $add->status = $request->get('status');
            $add->save();

            $salaryMDetail = salaryMDetail::extension_delete_insert($request->get('id'));
            $md = new salaryMDetail;
            if(!empty($request->get('late_deduction'))){
            	$md->salary_module_id = $request->get('id');
            	$md->title = $request->get('late_deduction');
            	$md->value = $request->get('late_deduction_value');
                $md->extensions = $request->get('extensions');

                
            	$md->save();
            }
            if(!empty($request->get('late_breack'))){

            	$md->salary_module_id = $request->get('id');
            	$md->title = $request->get('late_breack');
            	$md->value = $request->get('late_breack_value');
                $md->extensions = $request->get('extensions');

            	$md->save();

            }
            if(!empty($request->get('all_in_one'))){
            	$md->salary_module_id = $request->get('id');
            	$md->title = $request->get('all_in_one');
            	$md->value = $request->get('all_in_one_value');
                $md->extensions = $request->get('extensions');
                
            	$md->save();
            }

            return json_encode(array('msg'=>'Sava Data Success', 'content'=>true, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


     static function getResultExtensions($param){
        return 30000;
    }


}
