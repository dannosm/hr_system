<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\userModel;
use Illuminate\Support\Facades\Hash;
use Auth;



class userController extends Controller
{
     public function index(){
    	 return view('users.users');
    }

    function user_get(Request $request){

		try {
        $draw=$request['draw'];

			$user = userModel::user_get($request);
			$total = userModel::user_get_count($request)->count();

		    $output['draw']=$draw;
            if($total){
                $output['recordsTotal']=$output['recordsFiltered']=$total;
            }else{
                $output['recordsTotal']=$output['recordsFiltered']=$draw;   
            }
            $output['success']=TRUE;
            $output['token_status']='valid';
            $output['data'] = $user;
          

			echo json_encode($output);
		} catch (Exception $e) {
			echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));			
		}
    }

    function user_add(){
         return view('users.users_add');
    }

    function user_save(Request $request){
        try{
           
           $this->validate($request,[
            'username' =>'unique:users',
            'email' =>'unique:users',
            ]);

            $add = new userModel;
            $add->name = $request->get('name');
            $add->username = $request->get('username');
            $add->email = $request->get('email');
            $add->password =  Hash::make($request->get('password'));
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function user_edit($id){

         $user = userModel::user_get_by_id($id);

         return view('users.users_edit')->with('user',$user[0]);
    }

    function user_update(Request $request){
        try{
             
             $add = userModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->username = $request->get('username');
             $add->email = $request->get('email');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function user_delete(Request $request){
        try{
            $delete = userModel::user_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


    function user_language(Request $request){
        $id = Auth::user()->id;
        $user = userModel::user_get_by_id($id);
        if (!empty($user)) {
            return json_encode(array('bhs' =>$user[0]->user_language));
        }
            return json_encode(array('bhs' =>'id'));
    }


    function save_language(Request $request){
        try{
             $id = Auth::user()->id;
             $add = userModel::where('id', $id)->firstOrFail();
             $add->user_language = $request->get('id');
             $result = $add->save();
            
            return json_encode(array('bhs' =>$request->get('id')));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


    


}
