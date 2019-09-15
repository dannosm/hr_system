<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employeeModel;
use App\employeeDetailModel;
use App\employeeSalaryModel;
use Illuminate\Support\Facades\Hash;
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

            //employee salary
            $add = new employeeSalaryModel;
            $add->user_id = $lastId;
            $add->basic_salary = $request->get('basic_salary');
            $add->meal_allowance = $request->get('meal_allowance');
            $add->bonus = $request->get('bonus');
            //$add->communication = $request->get('communication');
            $add->bpjs_ketenaga_kerjaan_salary = $request->get('bpjs_ketenaga_kerjaan_salary');
            $add->pph = $request->get('pph');
            $add->positional_allowance = $request->get('posotional_allowance');
            $add->transport_allowances = $request->get('transport_allowance');
            $add->commission = $request->get('commission');
            $add->bpjs_kesehatan_salary = $request->get('bpjs_kesehatan_salary');
            $add->allowances_outside_the_city = $request->get('allowance_outside_the_city');
            $add->save();
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

            //employee salary
            $add = employeeSalaryModel::where('user_id', $request->get('id'))->firstOrFail(); 
            $add->basic_salary = $request->get('basic_salary');
            $add->meal_allowance = $request->get('meal_allowance');
            $add->bonus = $request->get('bonus');
            //$add->communication = $request->get('communication');
            $add->bpjs_ketenaga_kerjaan_salary = $request->get('bpjs_ketenaga_kerjaan_salary');
            $add->pph = $request->get('pph');
            $add->positional_allowance = $request->get('posotional_allowance');
            $add->transport_allowances = $request->get('transport_allowance');
            $add->commission = $request->get('commission');
            $add->bpjs_kesehatan_salary = $request->get('bpjs_kesehatan_salary');
            $add->allowances_outside_the_city = $request->get('allowance_outside_the_city');
            $add->save();
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
            $delete = employeeModel::employee_delete($request);
            $delete = employeeDetailModel::employee_detail_delete($request);
            $delete = employeeSalaryModel::employee_salary_delete($request);

            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
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
}
