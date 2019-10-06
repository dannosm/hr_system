<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class salaryModuleDetailModel extends Model
{
    protected $table = 'salary_module_detail';
    protected $primaryKey='id';
    protected $fillable = [
        'salary_attribute_id', 'salary_module_id',
    ];


    static function salary_module_detail_delete($id){
        $data = DB::DELETE("DELETE FROM salary_module_detail WHERE salary_attribute_id = $id");
        return $data;
    }
}
