<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class shiftSettingModel extends Model
{
    protected $table = 'shift_setting';
    protected $primaryKey='id';
    protected $fillable = [
        'tipe', 'status', 'shift_list',
    ];


    static function shift_setting_get(){

    	$data = DB::SELECT("SELECT *,IF(last_update > sc,1,0)lst FROM (SELECT *,CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',`schedule`)sc FROM shift_setting WHERE id='1')sets");
    	return $data;
    }

   
}
