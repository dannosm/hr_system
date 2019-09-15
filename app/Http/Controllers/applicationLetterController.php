<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\applicationLetterModel;
use Auth;

class applicationLetterController extends Controller
{
     public function index(){
    	 return view('application_letter.application_letter');
    }

    function application_letter_get(Request $request){

		try {
        $draw=$request['draw'];

			$user = applicationLetterModel::application_letter_get($request);
			$total = $user->count();

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

    function application_letter_add(){
         return view('application_letter.application_letter_add');
    }

    function application_letter_save(Request $request){
        try{
           
            $user = Auth::user();
            $add = new applicationLetterModel;
              if($request->file('files') !=''){

                 $photo = $request->file('files');
                 $destinationPath = base_path() . '/public/application_letter/';
                 $photo->move($destinationPath, $photo->getClientOriginalName());
                 $name = $photo->getClientOriginalName();
                 $add->path = $destinationPath;
                 $add->file_name = $name;
               }
            
            $add->title = $request->get('title');
            $add->description = $request->get('description');
            $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function application_letter_edit($id){

         $data = applicationLetterModel::application_letter_get_by_id($id);

         return view('application_letter.application_letter_edit')->with('data',$data[0]);
    }

    function application_letter_update(Request $request){
        try{

              $user = Auth::user();
              $add = applicationLetterModel::where('id', $request->get('id'))->firstOrFail();
              if($request->file('files') !=''){

                     $photo = $request->file('files');
                     $destinationPath = base_path() . '/public/application_letter/';
                     $photo->move($destinationPath, $photo->getClientOriginalName());
                     $name = $photo->getClientOriginalName();
                     $add->path = $destinationPath;
                     $add->file_name = $name;
                }
                
	            $add->title = $request->get('title');
                $add->description = $request->get('description');
                $add->creator = $user->id;
                $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function application_letter_delete(Request $request){
        try{
            $delete =  applicationLetterModel::application_letter_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
