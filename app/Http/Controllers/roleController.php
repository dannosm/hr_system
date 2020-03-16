<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roleModel;
use Illuminate\Support\Facades\Hash;
use Auth;

class roleController extends Controller
{
     public function index(){
    	 return view('role.role');
    }


    function role_get_raw(){
        $data = roleModel::all();

     return json_encode(array('msg'=>'Get Data Berhasil', 'content'=>$data, 'success'=>TRUE));    

    }

    function role_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = roleModel::role_get($request);
			$total = roleModel::role_get_count($request)->count();

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

    function role_add(){
         return view('role.role_add');
    }

    function role_save(Request $request){
        try{
           
        	$user = Auth::user();
            $add = new roleModel;
            $add->role_name = $request->get('name');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function role_edit($id){

         $data = roleModel::role_get_by_id($id);

         return view('role.role_edit')->with('data',$data[0]);
    }

    function role_update(Request $request){
        try{

             $user = Auth::user();
             $add = roleModel::where('role_id', $request->get('id'))->firstOrFail();
             $add->role_name = $request->get('name');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function role_delete(Request $request){
        try{
            $delete = roleModel::role_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
