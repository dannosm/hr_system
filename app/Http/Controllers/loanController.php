<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\loanModel;
use Auth;

class loanController extends Controller
{
     public function index(){
    	 return view('loan.loan');
    }

    function loan_get(Request $request){

     	$draw=$request['draw'];
		try {

			$data = loanModel::loan_get($request);
			$total = loanModel::loan_get_count($request)->count();


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

    function loan_add(){
         return view('loan.loan_add');
    }

    function loan_save(Request $request){
        try{
            
            $user = Auth::user();

            $add = new loanModel;
            $add->type = $request->get('type');
            $add->user_id = $request->get('employee');
            $add->date =  date("Y-m-d");
            $add->description =  $request->get('description');
            $add->creator =  $user->id;
            $add->amount =  $request->get('amount');
            $add->status = 'ongoing';
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function loan_edit($id){

         $data = loanModel::loan_get_by_id($id);

         return view('loan.loan_edit')->with('data',$data[0]);
    }

    function loan_update(Request $request){
        try{
             
            $user = Auth::user();
            $add = loanModel::where('id', $request->get('id'))->firstOrFail();
            $add->type = $request->get('type');
            $add->user_id = $request->get('employee');
            $add->date =  date("Y-m-d");
            $add->description =  $request->get('description');
            $add->creator =  $user->id;
            $add->amount =  $request->get('amount');
            $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function loan_delete(Request $request){
        try{
            $delete = loanModel::loan_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
