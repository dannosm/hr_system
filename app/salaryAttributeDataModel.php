<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class salaryAttributeDataModel extends Model
{
    protected $table = 'salary_attribute_data';
    protected $primaryKey='id';
    protected $fillable = [
        'employee_id', 'salary_attribute_id', 'product_attribute_name','value','creator'
    ];
}
