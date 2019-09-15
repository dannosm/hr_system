<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\permissionModel;
use Auth;

class permissionController extends Controller
{
     public function index(){
    	 return view('permission.permission');
    }

    function permission_get(Request $request){

     	$draw=$request['draw'];
		try {

			$data = permissionModel::permission_get($request);
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

    function permission_add(){
         return view('permission.permission_add');
    }

     function permission_save(Request $request){
        try{
            
            $user = Auth::user();

            $add = new permissionModel;
            $add->type = $request->get('type');
            $add->category = $request->get('category');
            $add->user_id = $request->get('employee');
            $add->date_start =  $request->get('date_start');
            $add->date_end = $request->get('date_end');
            $add->description =  $request->get('description');
            $add->creator =  $user->id;
            $add->days =  $request->get('days');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function permission_edit($id){

         $data = permissionModel::permission_get_by_id($id);

         return view('permission.permission_edit')->with('data',$data[0]);
    }

    function permission_update(Request $request){
        try{
             
            $user = Auth::user();
            $add = permissionModel::where('id', $request->get('id'))->firstOrFail();
            $add->type = $request->get('type');
            $add->category = $request->get('category');
            $add->user_id = $request->get('employee');
            $add->date_start =  $request->get('date_start');
            $add->date_end = $request->get('date_end');
            $add->description =  $request->get('description');
            $add->creator =  $user->id;
            $add->days =  $request->get('days');
            $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function permission_delete(Request $request){
        try{
            $delete = permissionModel::permission_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
