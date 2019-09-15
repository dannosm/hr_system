<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class attendanceModel extends Model
{
	protected $table = 'attendance';

    static function attendance_get(){
    	$sql = DB::table('attendance')
            ->join('employee', 'user_id', '=', 'employee.id')->select("*")
            ->get();

            return $sql;
    }
}
