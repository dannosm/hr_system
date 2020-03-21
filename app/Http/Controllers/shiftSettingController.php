<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\shiftSettingModel;
use App\shifModel;

use Illuminate\Support\Facades\Hash;
use Auth;

class shiftSettingController extends Controller
{
    public function index(){

        if($this->authSession(10,'r') == 1){return redirect('home');}


        $shift = shiftSettingModel::where('id',1)->get();
      

    	return view('shift.shift_setting')->with('shift',$shift[0]);
    }

    function shift_setting_get_by_id(Request $request){

		try {

        	$draw=$request['draw'];

			$data = shiftSettingModel::where('id',1)->get();

		    return json_encode($data);

		} catch (Exception $e) {
			echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));			
		}
    }


    function shift_setting_update(Request $request){
        try{
            
            if($this->authSession(10,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

             $user = Auth::user();
             $add = shiftSettingModel::where('id', 1)->firstOrFail();
             $add->tipe = $request->get('tipe');
             $add->status = $request->get('status');
             $add->shift_list = json_encode($request->get('shift'));
             $add->schedule =$request->get('schedule');
             $add->sync_auto =$request->get('sync_auto');
             $add->shift_list = json_encode($request->get('shift'));
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    
}
