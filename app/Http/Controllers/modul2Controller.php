<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\modul2Model;


class modul2Controller extends Controller
{
    function select2_get_raw(Request $request){
         try {

          /*  $search = $request->get('q');
            if(empty($request->get('q'))){
              $search = 'xnullx';
            }*/
            
            $output = modul2Model::select2_get_raw($request);

            echo json_encode($output);
        } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }

    }

}
