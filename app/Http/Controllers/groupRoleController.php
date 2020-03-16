<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\groupRoleModel;
use App\groupRoleDetailModel as grd;

use Illuminate\Support\Facades\Hash;
use Auth;


class groupRoleController extends Controller
{
     public function index(){
    	 return view('group_role.group_role');
    }

    function group_role_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = groupRoleModel::group_role_get($request);
			$total = groupRoleModel::group_role_get_count($request)->count();

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

    function group_role_add(){
         return view('group_role.group_role_add');
    }

    function group_role_save(Request $request){
        try{
            

           if(empty($request->get('group_id'))){ 
            	$user = Auth::user();
                $add = new groupRoleModel;
                $add->group_name = $request->get('name');
                $add->status = $request->get('status');
                $result = $add->save();
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$add->group_role_id, 'success'=>TRUE));    

          }else{

                    foreach ($request->get("detail_role") as $key => $value) {
                        
                        $add = new grd;
                        $add->role_id = $value['role_id'];
                        $add->role_write = $value['write'];
                        $add->role_read = $value['read'];
                        $add->role_delete = $value['delete'];
                        $add->group_id = $request->get('group_id');
                        $result = $add->save();
                        
                    }

                return json_encode(array('msg'=>'Sava Data Success', 'content'=>true, 'success'=>TRUE)); 

          }
            

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function group_role_edit($id){

         $data = groupRoleModel::where('group_role_id',$id)->get();


         return view('group_role.group_role_edit')->with('data',$data[0]);
        
    }

    function group_role_update(Request $request){
        try{


               $up = groupRoleModel::where('group_role_id', $request->get('group_id'))->firstOrFail();
                $up->group_name = $request->get('group_name');
                $up->status = $request->get('status');
                $result = $up->save();
                //delete detail
                $delete = grd::delete_raw_all($request->get('group_id'));
              foreach ($request->get("detail_role") as $key => $value) {
                        
                        $add = new grd;
                        $add->role_id = $value['role_id'];
                        $add->role_write = $value['write'];
                        $add->role_read = $value['read'];
                        $add->role_delete = $value['delete'];
                        $add->group_id = $request->get('group_id');
                        $result = $add->save();
                        
                    }

                return json_encode(array('msg'=>'Sava Data Success', 'content'=>true, 'success'=>TRUE)); 


        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function group_role_delete(Request $request){
        try{
            $delete = groupRoleModel::group_role_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


    function group_role_detail_get_by_id(Request $request){
        try{
            $data = grd::group_role_detail_get_by_id($request->get('id'));
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$data, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
