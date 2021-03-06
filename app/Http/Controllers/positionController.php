<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\positionModel;
use Illuminate\Support\Facades\Hash;
use Auth;

class positionController extends Controller
{
    public function index(){
    	 return view('position.position');
    }

    function position_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = positionModel::position_get($request);
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

    function position_add(){
         return view('position.position_add');
    }

    function position_save(Request $request){
        try{
           
         
        	$user = Auth::user();
            $add = new positionModel;
            $add->name = $request->get('name');
            $add->description = $request->get('description');
            $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function position_edit($id){

         $data = positionModel::position_get_by_id($id);

         return view('position.position_edit')->with('data',$data[0]);
    }

    function position_update(Request $request){
        try{

             $user = Auth::user();
             $add = positionModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->description = $request->get('description');
             $add->creator = $user->id;
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function position_delete(Request $request){
        try{
            $delete = positionModel::position_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
