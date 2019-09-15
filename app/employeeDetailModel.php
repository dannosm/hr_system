<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class employeeDetailModel extends Model
{
    protected $table = 'employee_detail';
    protected $primaryKey='id';

    static function employee_detail_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM employee_detail WHERE user_id in ($id)");
        return $users;
    } 
}
