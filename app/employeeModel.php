<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class employeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'email', 'password','username','telphone','birth_place','birth_day','gender','status','division_id','position_id','shift_id','leave','creator'
    ];

    static function employee_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('employee')
                ->leftjoin('division','employee.division_id','=','division.id')
                ->leftjoin('shift','employee.shift_id','=','shift.id')
                ->select('employee.*','shift.name as shift','division.name as division')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('employee')
              ->leftjoin('division','employee.division_id','=','division.id')
                ->leftjoin('shift','employee.shift_id','=','shift.id')
                ->select('employee.*','shift.name as shift','division.name as division')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.status', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.telphone', 'LIKE', '%'.$search.'%')
                ->orwhere('division.name', 'LIKE', '%'.$search.'%')
                ->orwhere('shift.name', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.email', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

        return $data;
    }

     static function employee_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('employee')
                ->leftjoin('division','employee.division_id','=','division.id')
                ->leftjoin('shift','employee.shift_id','=','shift.id')
                ->select('employee.*','shift.name as shift','division.name as division')
                ->get();
        }else{

             $data = DB::table('employee')
              ->leftjoin('division','employee.division_id','=','division.id')
                ->leftjoin('shift','employee.shift_id','=','shift.id')
                ->select('employee.*','shift.name as shift','division.name as division')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.status', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.telphone', 'LIKE', '%'.$search.'%')
                ->orwhere('division.name', 'LIKE', '%'.$search.'%')
                ->orwhere('shift.name', 'LIKE', '%'.$search.'%')
                ->orwhere('employee.email', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }

    static function employee_get_by_id($id){
    	
    	$data = DB::table('employee')
                ->leftjoin('employee_detail','employee.id','=','employee_detail.user_id')
                ->leftjoin('employee_salary','employee.id','=','employee_salary.user_id')
                ->leftjoin('position','position_id','=','position.id')
                ->leftjoin('division','division_id','=','division.id')
                ->leftjoin('shift','shift_id','=','shift.id')
                ->select('employee.*','employee_detail.*','employee.id as employee_id','shift.name as shift','division.name as division','position.name as position')
                ->where('employee.id',$id)
                ->get();
    	return $data;
    }

    static function employee_get_by_name($name){
        
        if($name == 'xnullx'){

            $data = DB::table('employee')
                ->select('id', 'name as text')
                ->orderby('name','asc')
                ->limit(10)
                ->get();
        }else{
         $data = DB::table('employee')
                ->where('employee.name', 'LIKE', '%'.$name.'%')
                ->select('id', 'name as text')
                ->limit(10)
                ->get();
        }
        return $data;
    }

    static function employee_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM employee WHERE id in($id)");
        return $users;
    } 

    static function employee_get_data($id){

        $data = DB::table('employee')
                ->select('id','division_id','name','position_id','status','email')
                ->where('employee.id',$id)
                ->get();
        return $data;
    }

    static function employee_get_api(){
        
        $data = DB::table('employee')
                ->leftjoin('employee_detail','employee.id','=','employee_detail.user_id')
                ->leftjoin('employee_salary','employee.id','=','employee_salary.user_id')
                ->leftjoin('position','position_id','=','position.id')
                ->leftjoin('division','division_id','=','division.id')
                ->leftjoin('shift','shift_id','=','shift.id')
                ->select('employee.id','employee.name','employee.email','employee.telphone','employee.status','employee.id as employee_id','shift.name as shift','division.name as division','position.name as position')
//->select('employee.*','employee_detail.*','employee.id as employee_id','shift.name as shift','division.name as division','position.name as position')
                ->get();
        return $data;
    }


     static function employee_get_by_id_api($id){
        
        $data = DB::table('employee')
                ->leftjoin('employee_detail','employee.id','=','employee_detail.user_id')
                ->leftjoin('employee_salary','employee.id','=','employee_salary.user_id')
                ->leftjoin('position','position_id','=','position.id')
                ->leftjoin('division','division_id','=','division.id')
                ->leftjoin('shift','shift_id','=','shift.id')
                ->select('employee.id','employee.name','employee.email','employee.telphone','employee.status','employee.id as employee_id','shift.name as shift','division.name as division','position.name as position')
                ->where('employee.id',$id)

//->select('employee.*','employee_detail.*','employee.id as employee_id','shift.name as shift','division.name as division','position.name as position')
                ->get();
        return $data;
    }


    static function employee_shift_get(){
        $data = DB::SELECT("SELECT id,shift_id,name,(SELECT name FROM shift where id=employee.shift_id)shift_name FROM employee WHERE `status` ='active' order by shift_id asc");
        return $data;
    }


    static function employee_all_status_get(){
        $data = DB::SELECT("   SELECT * FROM  (SELECT COUNT(*)att_jum FROM employee ee INNER JOIN attendance aa ON ee.`id`=aa.`user_id` WHERE `status`='active' AND DATE(check_in)=DATE(NOW()))att,
                    (SELECT COUNT(*)ee_jum FROM employee WHERE `status`='active') ee,
                    (SELECT COUNT(*)per_mit FROM permission  WHERE `type`='permission' AND date_start <= DATE(NOW()) AND date_end >=DATE(NOW()))per,
                     (SELECT COUNT(*)lev_mit FROM permission  WHERE `type` ='leave' AND date_start <= DATE(NOW()) AND date_end >=DATE(NOW()) )lev;
                    ");
        return $data;
    }
}
