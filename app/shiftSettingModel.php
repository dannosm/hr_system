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


    static function shift_setting_delete_json_data($request){

    	$data = shiftSettingModel::WHERE('id',1)->get();

    	$json_data = json_decode($data[0]->shift_list,true);
    	$id = $request['list_id'];

    	for ($i=0; $i < count($request['list_id']); $i++) { 
			$key =  array_search($id[$i], array_column($json_data,'id'));
    		if($key === 0 || !empty($key)){
    			unset($json_data[$key]);
    		}
    		
    	}

    	$update = shiftSettingModel::where('id',1)->firstOrFail();
    	$update->shift_list = json_encode($json_data);
    	$update->save();


    }

   
}
