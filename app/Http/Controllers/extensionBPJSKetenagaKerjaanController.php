<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\salaryModuleModel as salaryModule;
use App\salaryModuleDetailModel as 	salaryMDetail;

class extensionBPJSKetenagaKerjaanController extends Controller
{
    function extension_bpjs_ketenaga_kerjaan_save(Request $request){
        try{
           
           if($this->authSession(9,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}
        	$user = Auth::user();
            
            $add = salaryModule::where('id', $request->get('id'))->firstOrFail();
            $add->status = $request->get('status');
            $add->save();

            $salaryMDetail = salaryMDetail::extension_delete_insert($request->get('id'));
            $md = new salaryMDetail;
          
        	$md->salary_module_id = $request->get('id');
        	$md->title = $request->get('bpjs_ketenaga_kerjaan');
            $md->extensions = $request->get('extensions');


            $data_json =  json_encode(array('company_persen' => $request->get('company_persen'),'employee_persen'=>$request->get('employee_persen')));
        	$md->value = $data_json;
        	$md->save();
           
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>true, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


     static function getResultExtensions($module,$value){

        #get extension rumus

        
        $like = 1;
        $result = array_filter($value['addition'], function ($item) use ($like) {
         if ($item['id'] == $like) {
             return true;
         }
        return false;
        });

        $extensions = json_decode($module['extensions_value'],true);
        $basic_salary = $result[key($result)]['value'];
        $persen = $extensions['employee_persen'];
        $results = ($basic_salary * $persen)/100;
       
        return $results;

    }


}
