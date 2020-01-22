<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\shiftModel;

class shiftController extends Controller
{
     public function index(){
    	 return view('shift.shift');
    }

    function shift_get(Request $request){

     	$draw=$request['draw'];
  

		try {

			$data = shiftModel::shift_get($request);
			$total = shiftModel::shift_get_count($request)->count();


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

    function shift_add(){
         return view('shift.shift_add');
    }

    function shift_save(Request $request){
        try{
           
            $add = new shiftModel;
            $add->name = $request->get('group_name');
            $add->time_in = $request->get('check_in');
            $add->time_out = $request->get('check_out');
            $add->late_limit =  $request->get('late_limit');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function shift_edit($id){

         $data = shiftModel::shift_get_by_id($id);

         return view('shift.shift_edit')->with('data',$data[0]);
    }

    function shift_update(Request $request){
        try{
             
             $add = shiftModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('group_name');
             $add->time_in = $request->get('check_in');
             $add->time_out = $request->get('check_out');
             $add->late_limit =  $request->get('late_limit');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function shift_delete(Request $request){
        try{
            $delete = shiftModel::shift_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
