<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rekruitmenModel;
use Auth;

class rekruitmenController extends Controller
{
     public function index(){

        if($this->authSession(4,'r') == 1){return redirect('home');}

    	 return view('rekruitmen.rekruitmen');
    }

    function rekruitmen_get(Request $request){

		try {
        $draw=$request['draw'];

			$user = rekruitmenModel::rekruitmen_get($request);
			$total = rekruitmenModel::rekruitmen_get_count($request)->count();

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

    function rekruitmen_add(){

        if($this->authSession(4,'w') == 1){return redirect('home');}

         return view('rekruitmen.rekruitmen_add');
    }

    function rekruitmen_save(Request $request){
        try{
           
           if($this->authSession(4,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $user = Auth::user();
            $add = new rekruitmenModel;
              if($request->file('files') !=''){

                 $photo = $request->file('files');

                 $destinationPath = base_path() . '/public/rekruitmen/';
                 $photo->move($destinationPath, $photo->getClientOriginalName());
                 $name = $photo->getClientOriginalName();
                 $add->path =$name;
               }
            
            $add->title = $request->get('title');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function rekruitmen_edit($id){

        if($this->authSession(4,'w') == 1){return redirect('home');}

         $data = rekruitmenModel::rekruitmen_get_by_id($id);

         return view('rekruitmen.rekruitmen_edit')->with('data',$data[0]);
    }

    function rekruitmen_update(Request $request){
        try{

           if($this->authSession(4,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

              $user = Auth::user();
              $add = rekruitmenModel::where('id', $request->get('id'))->firstOrFail();
              if($request->file('files') !=''){

                     $photo = $request->file('files');
                     $destinationPath = base_path() . '/public/rekruitmen/';
                     $photo->move($destinationPath, $photo->getClientOriginalName());
                     $name = $photo->getClientOriginalName();
                     $add->path =$name;
                }
                
	            $add->title = $request->get('title');
                $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function rekruitmen_delete(Request $request){
        try{

           if($this->authSession(4,'d') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $delete =  rekruitmenModel::rekruitmen_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
