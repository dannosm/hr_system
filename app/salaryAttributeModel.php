<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class salaryAttributeModel extends Model
{
    protected $table = 'salary_attribute';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'type', 'creator','status'
    ];


    static function salary_attribute_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('salary_attribute')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('salary_attribute')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('tipe', 'LIKE', '%'.$search.'%')  
                ->orwhere('status', 'LIKE', '%'.$search.'%')             
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function salary_attribute_get_by_id($id){
    	
    	$data = salaryAttributeModel::where('id',$id)->get();
    	return $data;
    }
    
    static function salary_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM salary_attribute WHERE id in($id)");
        return $data;
    }  

    static function salary_attribute_get_status_active($request){

         $data = DB::SELECT("SELECT sa.id,sa.`name`,if(sd.`value` is null,'',sd.`value`)value FROM salary_attribute sa LEFT JOIN salary_attribute_data sd ON sa.`id`=sd.`salary_attribute_id` AND sd.`employee_id`='".$request->get('id')."' WHERE `status`='active'");

        return $data;

    } 


}
