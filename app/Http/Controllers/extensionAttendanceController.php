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

            if(!empty($request->get('all_in_one'))){

            	$md->salary_module_id = $request->get('id');
            	$md->title = $request->get('all_in_one');
            	$md->value = json_encode(array('tipe' => 1 ,'value'=> str_replace(".", "", $request->get('all_in_one_value'))));
                $md->extensions = $request->get('extensions');
                
            	$md->save();
            }else{      

                $att = $request->get('late_deduction_value') == '' ? 0:$request->get('late_deduction_value');
                $bre = $request->get('late_breack_value') == '' ? 0:$request->get('late_breack_value');

                $md->salary_module_id = $request->get('id');
                $md->title = 'double';
                $md->value = json_encode(array('tipe' =>2 ,'module'=> array('attendance'=>str_replace('.', "", $att),'breack'=>str_replace(".", "", $bre))));
                $md->extensions = $request->get('extensions');
                $md->save();

            }

            return json_encode(array('msg'=>'Sava Data Success', 'content'=>true, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


     static function getResultExtensions($module,$value){       
        $att = $module['att'];
        $key = array_search($module['employee_id'], array_column($att, 'user_id'));

        if(!empty($key) || $key === 0){
           
            $att= $att[$key];
            $ext = json_decode($module['extensions_value'],true);
            if($ext['tipe'] == 1){

                $sub1 = $att->telat_masuk + $att->telat_isti;
                $total = $sub1 * $ext['value'];

               return $total;

            }else{

                $sub1 = $att->telat_masuk * $ext['module']['attendance'];
                $sub2 =  $att->telat_isti * $ext['module']['breack'];
                $total = $sub1 + $sub2;
                return $total ;
            }

        }else{

            return 0;
        }

    }


}
