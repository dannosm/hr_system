<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class shiftDetailModel extends Model
{


    static function shift_detail_delete(){
    	DB::DELETE("DELETE FROM shift_detail WHERE 1");
    }

    static function shift_detail_insert($param){
    	

    	 $data = DB::INSERT("INSERT INTO shift_detail (employee_id,shift_id)VALUES $param ");
    	 $param = str_replace(";"," ", $param);
    	
    	 $employee = DB::INSERT("INSERT INTO employee (id, shift_id) VALUES $param ON DUPLICATE KEY UPDATE shift_id = VALUES(shift_id)");
    	 return $data; 
    }
}
