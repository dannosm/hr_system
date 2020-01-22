<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class attendanceModel extends Model
{
	protected $table = 'attendance';

    static function attendance_get($request){
    	
        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('attendance')
               ->join('employee', 'user_id', '=', 'employee.id')->select("*")
                 ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('attendance')
               ->join('employee', 'user_id', '=', 'employee.id')->select("*")
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->where('attendance.description', 'LIKE', '%'.$search.'%')
                  ->offset($start)
                ->limit($length)
                ->get();
        }

        return $data;
    }

     static function attendance_get_count($request){
        
        $search=$request['search']["value"];
        if(empty($search)){
           $data = DB::table('attendance')
               ->join('employee', 'user_id', '=', 'employee.id')->select("*")
                ->get();
        }else{

             $data = DB::table('attendance')
               ->join('employee', 'user_id', '=', 'employee.id')->select("*")
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->where('attendance.description', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }

    static function attendance_save($value){
    	$sql = DB::insert("INSERT INTO attendance(user_id,check_in,check_out,tipe)VALUES $value");
    	return $sql;
    }
}
