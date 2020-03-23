<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\salaryModuleModel;
use Illuminate\Support\Facades\Hash;
use Auth;

class salaryModuleController extends Controller
{
    public function index(){

        if($this->authSession(9,'r') == 1){return redirect('home');}

    	return view('salary.salary_module');
    }

    function salary_module_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = salaryModuleModel::salary_module_get($request);
			$total = salaryModuleModel::salary_module_get_count($request)->count();

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

    function salary_module_add(){
        
        if($this->authSession(9,'w') == 1){return redirect('home');}


         return view('salary.salary_module_add');
    }

    function salary_module_save(Request $request){
        try{
           
           if($this->authSession(9,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}
        	$user = Auth::user();
            $add = new salaryModuleModel;
            $add->name = $request->get('name');
            $add->description = $request->get('description');
            $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function salary_module_edit($view,$id){
         
         if($this->authSession(9,'w') == 1){return redirect('home');}


         $data = salaryModuleModel::get_extension_module($id);

   
         return view('extension.'.$view)->with('id',$id)->with('data',$data);



    }

    function salary_module_update(Request $request){
        try{
            
            if($this->authSession(9,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

             $user = Auth::user();
             $add = salaryModuleModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->description = $request->get('description');
             $add->creator = $user->id;
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function salary_module_delete(Request $request){
        try{

           if($this->authSession(5,'d') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $delete = salaryModuleModel::salary_module_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
