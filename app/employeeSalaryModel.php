<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class employeeSalaryModel extends Model
{
    protected $table = 'employee_salary';
    protected $primaryKey='id';
    

    static function employee_salary_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM employee_salary WHERE user_id in($id)");
        return $users;
    } 
    
}
