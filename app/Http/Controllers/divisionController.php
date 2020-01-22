<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\divisionModel;
use Illuminate\Support\Facades\Hash;
use Auth;


class divisionController extends Controller
{
    public function index(){
    	 return view('division.division');
    }

    function division_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = divisionModel::division_get($request);
			$total = divisionModel::division_get_count($request)->count();

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

    function division_add(){
         return view('division.division_add');
    }

    function division_save(Request $request){
        try{
           
         
        	$user = Auth::user();
            $add = new divisionModel;
            $add->name = $request->get('name');
            $add->description = $request->get('description');
            $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function division_edit($id){

         $data = divisionModel::division_get_by_id($id);

         return view('division.division_edit')->with('data',$data[0]);
    }

    function division_update(Request $request){
        try{

             $user = Auth::user();
             $add = divisionModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->description = $request->get('description');
             $add->creator = $user->id;
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function division_delete(Request $request){
        try{
            $delete = divisionModel::division_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
