<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\multipleDocumentModel;
use Auth;

class multipleDocumentController extends Controller
{
     public function index(){
    	 return view('multiple_document.multiple_document');
    }

    function multiple_document_get(Request $request){

		try {
        $draw=$request['draw'];

			$user = multipleDocumentModel::multiple_document_get($request);
			$total = multipleDocumentModel::multiple_document_get_count($request)->count();

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

    function multiple_document_add(){
         return view('multiple_document.multiple_document_add');
    }

    function multiple_document_save(Request $request){
        try{
           
            $user = Auth::user();
            $add = new multipleDocumentModel;
              if($request->file('files') !=''){

                 $photo = $request->file('files');
                 $destinationPath = base_path() . '/public/multiple_document/';
                 $photo->move($destinationPath, $photo->getClientOriginalName());
                 $name = $photo->getClientOriginalName();
                 $add->path = $destinationPath;
                 $add->file_name = $name;
               }
            
            $add->title = $request->get('title');
            $add->type = $request->get('type');
            $add->description = $request->get('description');
            $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function multiple_document_edit($id){

         $data = multipleDocumentModel::multiple_document_get_by_id($id);

         return view('multiple_document.multiple_document_edit')->with('data',$data[0]);
    }

    function multiple_document_update(Request $request){
        try{

              $user = Auth::user();
              $add = multipleDocumentModel::where('id', $request->get('id'))->firstOrFail();
              if($request->file('files') !=''){

                     $photo = $request->file('files');
                     $destinationPath = base_path() . '/public/multiple_document/';
                     $photo->move($destinationPath, $photo->getClientOriginalName());
                     $name = $photo->getClientOriginalName();
                     $add->path = $destinationPath;
                     $add->file_name = $name;
                }
                
	            $add->title = $request->get('title');
                $add->description = $request->get('description');
                $add->type = $request->get('type');
                $add->creator = $user->id;
                $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function multiple_document_delete(Request $request){
        try{
            $delete =  multipleDocumentModel::multipleDocument_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
