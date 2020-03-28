<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\settingModel;
use Illuminate\Support\Facades\Hash;
use Auth;

class settingController extends Controller
{

     public function index(){

        if($this->authSession(18,'r') == 1){return redirect('home');}

    	 return view('setting.setting');
    }

    function setting_get(Request $request){

		try {
        $draw=$request['draw'];

			$data = settingModel::setting_get($request);
			$total = settingModel::setting_get_count($request)->count();
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

    function setting_add(){

        if($this->authSession(18,'w') == 1){return redirect('home');}

         return view('setting.setting_add');
    }

    function setting_save(Request $request){
        try{
            
           if($this->authSession(18,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

        	$user = Auth::user();
            $add = new settingModel;
            $add->name = $request->get('name');
            $add->type = $request->get('type');
            $add->setting_json = $request->get('setting_json');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function setting_edit($id){

        if($this->authSession(18,'w') == 1){return redirect('home');}

         $data = settingModel::setting_get_by_id($id);

         return view('setting.setting_edit')->with('data',$data[0]);
    }

    function setting_update(Request $request){
        try{

           if($this->authSession(18,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

             $user = Auth::user();
             $add = settingModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->type = $request->get('type');
             $add->setting_json = $request->get('setting_json');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function setting_delete(Request $request){
        try{

           if($this->authSession(18,'d') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $delete = settingModel::setting_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

     function setting_modul_save(Request $request){
        try{
           
            $add = settingModel::where('id', $request->get('id'))->firstOrFail();
             $add->image = $this->image_upload($request->file('gambar'));
             $result = $add->save();            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

        function image_upload($image){

         if($image !=''){
                 $photo = $image;
                 $destinationPath = base_path() . '/public/images/';
                 $photo->move($destinationPath, $photo->getClientOriginalName());
                 $name = $photo->getClientOriginalName();
                 return $name;
            }
    }


    public function setting_set_page(Request $request){
         try{
            
           if($this->authSession(18,'r') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $page = settingModel::all();
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$page, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }
    }



}
