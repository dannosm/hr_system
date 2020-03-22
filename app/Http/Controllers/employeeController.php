<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employeeModel;
use App\employeeDetailModel;
use App\salaryAttributeDataModel;
use Illuminate\Support\Facades\Hash;
use App\shiftDetailModel;
use Auth;
use Illuminate\Support\Str;

class employeeController extends Controller
{
     public function index(){
    	 return view('employee.employee');
    }

    function employee_get(Request $request){

     	$draw=$request['draw'];
		try {

			$user = employeeModel::employee_get($request);
			$total =  employeeModel::employee_get_count($request)->count();


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

    function employee_add(){
         return view('employee.employee_add');
    }

    function employee_save(Request $request){
        try{

            $user = Auth::user();
            //group employee
            $add = new employeeModel;  
            $add->creator = $user->id;
            $add->name = $request->get('name');
            $add->email = $request->get('email');
            $add->password = Hash::make($request->get('password'));
            $add->username = $request->get('username');
            $add->telphone = $request->get('telphone');
            $add->birth_place = $request->get('birth_place');
            $add->birth_day = $request->get('birth_day');
            $add->gender = $request->get('gender');
            $add->status = $request->get('status');
            $add->division_id = $request->get('division');
            $add->shift_id = $request->get('shift');
            $add->position_id = $request->get('position');
            $add->leave = $request->get('leave');
            $result = $add->save();
            $lastId = $add->id;
            //group employee end

            //employee detail
            $add = new employeeDetailModel;
            $add->user_id = $lastId;
            $add->card_id = $request->get('id_card');
            $add->telephone2 = $request->get('telphone_2');
            $add->religion = $request->get('religion');
            $add->bank_account = $request->get('bank_account');
            $add->bank_name = $request->get('bank_name');
            $add->foto = $this->employee_image_upload($request->file('avatar'));
            $add->marriage = $request->get('marriage');
            $add->address = $request->get('address');
            $add->country = $request->get('country');
            $add->description = $request->get('description');
            $add->join_at = $request->get('join_at');
            $add->date_last_contract = $request->get('date_contract');
            $add->employment = $request->get('employment');
            $add->bpjs_ketenaga_kerjaan = $request->get('bpjs_ketenaga_kerjaan');
            $add->bpjs_kesehatan = $request->get('bpjs_kesehatan');
            $add->save();
            //employee detail end

            //shift detail
            $add = New shiftDetailModel;
            $add->shift_id = $request->get('shift');
            $add->employee_id = $lastId;
            $add->save();

            //employee salary
            if(!empty($request->get('salary'))){

               foreach ($request->get('salary') as $key => $value) {
                
                $add = new salaryAttributeDataModel;
                    $add->employee_id = $lastId;
                    $add->creator = $user->id;
                    $add->salary_attribute_id = $key;
                    $add->value = str_replace('.', '', $value);
                    $add->save();
                } 
               
            }
            //employee salary end

            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function employee_edit($id){

         $data = employeeModel::employee_get_by_id($id);

         return view('employee.employee_edit')->with('data',$data[0]);
    }

    function employee_update(Request $request){
        try{

              $user = Auth::user();

            //group employee
            $add = employeeModel::where('id', $request->get('id'))->firstOrFail(); 
            $add->creator = $user->id;
            $add->name = $request->get('name');
            $add->email = $request->get('email');
            $add->password = Hash::make($request->get('password'));
            $add->username = $request->get('username');
            $add->telphone = $request->get('telphone');
            $add->birth_place = $request->get('birth_place');
            $add->birth_day = $request->get('birth_day');
            $add->gender = $request->get('gender');
            $add->status = $request->get('status');
            $add->division_id = $request->get('division');
            $add->shift_id = $request->get('shift');
            $add->position_id = $request->get('position');
            $add->leave = $request->get('leave');
            $result = $add->save();
            //group employee end

            //employee detail
            $add = employeeDetailModel::where('user_id', $request->get('id'))->firstOrFail(); 
            $add->card_id = $request->get('id_card');
            $add->telephone2 = $request->get('telphone_2');
            $add->religion = $request->get('religion');
            $add->bank_account = $request->get('bank_account');
            $add->bank_name = $request->get('bank_name');
            $add->foto = $this->employee_image_upload($request->file('avatar'));
            $add->marriage = $request->get('marriage');
            $add->address = $request->get('address');
            $add->country = $request->get('country');
            $add->description = $request->get('description');
            $add->join_at = $request->get('join_at');
            $add->date_last_contract = $request->get('date_contract');
            $add->employment = $request->get('employment');
            $add->bpjs_ketenaga_kerjaan = $request->get('bpjs_ketenaga_kerjaan');
            $add->bpjs_kesehatan = $request->get('bpjs_kesehatan');
            $add->save();
            //employee detail end
            $add = shiftDetailModel::where('employee_id',$request->get('id'))->firstOrFail();
            $add->shift_id = $request->get('shift');
            $add->save();

            //employee salary
            if(!empty($request->get('salary'))){

               foreach ($request->get('salary') as $key => $value) {
                $check = salaryAttributeDataModel::check_employee_salary_attribute($request->get('id'),$key);

                if(count($check) ==0){
                    $add = new salaryAttributeDataModel;
                    $add->employee_id = $request->get('id');
                    $add->creator = $user->id;
                    $add->salary_attribute_id = $key;
                    $add->value = str_replace('.', '', $value);
                    $add->save();

                    }else{
                   $add = salaryAttributeDataModel::where('employee_id', $request->get('id'))->where('salary_attribute_id', $key)->firstOrFail(); 
                    $add->value = str_replace('.', '', $value);
                    $add->save();
                 }
                } 
               
            }
           
            //employee salary end
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


    function employee_get_raw(Request $request){
         try {

            $search = $request->get('q');
            if(empty($request->get('q'))){
              $search = 'xnullx';
            }
            
            $output = employeeModel::employee_get_by_name($search);

            echo json_encode($output);
        } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }

    }

    function employee_delete(Request $request){
        try{
            $delete1 = employeeModel::employee_delete($request);
            $delete = employeeDetailModel::employee_detail_delete($request);
            $delete = employeeSalaryModel::employee_salary_delete($request);

            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete1, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function employee_image_upload($image){

         if($image !=''){
                 $photo = $image;
                 $destinationPath = base_path() . '/public/images/';
                 $photo->move($destinationPath, $photo->getClientOriginalName());
                 $name = $photo->getClientOriginalName();
                 return $name;
            }
    }

    function employee_login(Request $request){
        $user = Auth::user();
        $data = employeeModel::employee_get_data($user->id);

        $data['_token'] = Str::random(60);
        return response()->json($data,200);

    }


    function employee_get_api(Request $request){

        try {

            if(!empty($request->get('employee_id'))){
             $employee = employeeModel::employee_get_by_id_api($request->get('employee_id'));

            }else{
             $employee = employeeModel::employee_get_api();
           }
          
            return response()->json($employee,200);   

        } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }

    }



}
