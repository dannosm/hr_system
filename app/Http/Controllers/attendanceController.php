<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\attendanceModel;
class attendanceController extends Controller
{
    public function index(){

    	 return view('attendance.attendance');
    }

      function attendance_get(){

     	$draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
		try {

			$user = attendanceModel::attendance_get();
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
}
