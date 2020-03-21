<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\shiftModel;
use App\shiftSettingModel;
use App\employeeModel;
use App\shiftDetailModel;


class shiftController extends Controller
{
     public function index(){
         
         if($this->authSession(10,'r') == 1){return redirect('home');}
         $data = shiftSettingModel::where('id',1)->get();
    	 return view('shift.shift')->with('sync',$data[0]->sync_auto);
    }

    function shift_get(Request $request){

     	$draw=$request['draw'];
  

		try {

			$data = shiftModel::shift_get($request);
			$total = shiftModel::shift_get_count($request)->count();


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

    function shift_add(){

        if($this->authSession(10,'w') == 1){return redirect('home');}
         return view('shift.shift_add');
    }

    function shift_save(Request $request){
        try{
           
           if($this->authSession(10,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $add = new shiftModel;
            $add->name = $request->get('group_name');
            $add->time_in = $request->get('check_in');
            $add->time_out = $request->get('check_out');
            $add->late_limit =  $request->get('late_limit');
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function shift_edit($id){

        if($this->authSession(10,'w') == 1){return redirect('home');}
         $data = shiftModel::shift_get_by_id($id);

         return view('shift.shift_edit')->with('data',$data[0]);
    }

    function shift_update(Request $request){
        try{

           if($this->authSession(10,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}
             
             $add = shiftModel::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('group_name');
             $add->time_in = $request->get('check_in');
             $add->time_out = $request->get('check_out');
             $add->late_limit =  $request->get('late_limit');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function shift_delete(Request $request){
        try{

           if($this->authSession(10,'d') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $delete = shiftModel::shift_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function shift_print(Request $request){
        try{

           if($this->authSession(10,'r') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $setting = shiftSettingModel::shift_setting_get();

            $set = $setting[0];

            if($set->status != 'active'){
                return json_encode(array('msg'=>'Shift Setting Disable', 'content'=>'', 'success'=>FALSE));    
            }

            #autosycn
            if($set->sync_auto == 1){
              
                #schedule
                if($set->lst == 0 ){

                    $shiftt = json_decode($set->shift_list,true);
                    $employee = employeeModel::employee_shift_get();
                    $delete = shiftDetailModel::shift_detail_delete();
                    #tipe
                    if($set->tipe == 'random'){
                        $data = "";
                      
                        $c = count($employee);
                        $i = 1;
                        foreach ($employee as $key => $value) {
                             $shift = $shiftt;

                              $tt = array_search($value->shift_id, array_column($shift, 'id'));
                              
                              if(!empty($tt) || $tt ===0){
                                unset($shift[$tt]);
                              }
                              $shift_select = $shift[key($shift)]['id'];
                             if(count($shift) > 1){
                              $keys = rand(0,count($shift)-1);
                               $shift_select = $shift[$keys]['id'];
                             }

                            if($i == $c){
                                $data .= "('".$value->id."','".$shift_select."');";
                            }else{
                                $data .= "('".$value->id."','".$shift_select."'),";
                            }

                            $i++;
                        }   

                        $save = shiftDetailModel::shift_detail_insert($data); 
                        $update = shiftSettingModel::where('id',1)->firstOrFail();
                        $update->last_update = date('Y-m-d');
                        $update->save();
                                         
                    }else{

                        $c = count($employee);
                        $i = 1;
                        $data = "";
                        foreach ($employee as $key => $value) {
                            $shift = $shiftt;
                            $tt = array_search($value->shift_id, array_column($shift, 'id'));
                              
                            if(!empty($tt) || $tt ===0){
                                unset($shift[$tt]);
                            }


                             $shift_select = $shift[key($shift)]['id'];
                             if(count($shift) > 1){

                               $keys = $tt+1;
                             
                               
                               if($keys > count($shift)){
                                    $shift_select = $shift[0]['id'];

                               }else{
                                   $shift_select = $shift[$keys]['id'];
                               }

                             }

                            if($i == $c){
                                $data .= "('".$value->id."','".$shift_select."');";
                            }else{
                                $data .= "('".$value->id."','".$shift_select."'),";
                            }

                            $i++;
                        }   

                        $save = shiftDetailModel::shift_detail_insert($data); 
                        $update = shiftSettingModel::where('id',1)->firstOrFail();
                        $update->last_update = date('Y-m-d');
                        $update->save();


                    }
                    #endtipe

                }
                #endschedule
              
            }else{

                if($request->get('tipe') == 'print'){
                    $detail_shift = employeeModel::employee_shift_get();
                    return json_encode(array('msg'=>'Print Data Success', 'content'=>$detail_shift, 'success'=>TRUE));    

                }

                    $shiftt = json_decode($set->shift_list,true);
                    $employee = employeeModel::employee_shift_get();
                    $delete = shiftDetailModel::shift_detail_delete();

                 #tipe
                    if($set->tipe == 'random'){
                        $data = "";
                      
                        $c = count($employee);
                        $i = 1;
                        foreach ($employee as $key => $value) {
                             $shift = $shiftt;

                              $tt = array_search($value->shift_id, array_column($shift, 'id'));
                              
                              if(!empty($tt) || $tt ===0){
                                unset($shift[$tt]);
                              }
                              $shift_select = $shift[key($shift)]['id'];
                             if(count($shift) > 1){
                              $keys = rand(0,count($shift)-1);
                               $shift_select = $shift[$keys]['id'];
                             }

                            if($i == $c){
                                $data .= "('".$value->id."','".$shift_select."');";
                            }else{
                                $data .= "('".$value->id."','".$shift_select."'),";
                            }

                            $i++;
                        }   

                        $save = shiftDetailModel::shift_detail_insert($data); 
                        $update = shiftSettingModel::where('id',1)->firstOrFail();
                        $update->last_update = date('Y-m-d');
                        $update->save();
                                         
                    }else{

                        $c = count($employee);
                        $i = 1;
                        $data = "";
                        foreach ($employee as $key => $value) {
                            $shift = $shiftt;
                            $tt = array_search($value->shift_id, array_column($shift, 'id'));
                              
                            if(!empty($tt) || $tt ===0){
                                unset($shift[$tt]);
                            }


                             $shift_select = $shift[key($shift)]['id'];
                             if(count($shift) > 1){

                               $keys = $tt+1;
                             
                               
                               if($keys > count($shift)){
                                    $shift_select = $shift[0]['id'];

                               }else{
                                   $shift_select = $shift[$keys]['id'];
                               }

                             }

                            if($i == $c){
                                $data .= "('".$value->id."','".$shift_select."');";
                            }else{
                                $data .= "('".$value->id."','".$shift_select."'),";
                            }

                            $i++;
                        }   

                        $save = shiftDetailModel::shift_detail_insert($data);
                        $update = shiftSettingModel::where('id',1)->firstOrFail();
                        $update->last_update = date('Y-m-d');
                        $update->save();

                    }
                    #endtipe

            }
            #endautosync

            $detail_shift = employeeModel::employee_shift_get();

            return json_encode(array('msg'=>'Detail Shist', 'content'=>$detail_shift, 'success'=>TRUE)); 

        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }
}
