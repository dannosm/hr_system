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
                ->leftjoin('salary_module_detail','salary_attribute.id','=','salary_attribute_id')
                ->select('salary_attribute.id as id','type','salary_attribute.name as name','salary_module_id as module_id'
                ,DB::raw('(select name from salary_module where id=salary_module_id) as module_name'),'status')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('salary_attribute')
                ->leftjoin('salary_module_detail','salary_attribute.id','=','salary_attribute_id')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('type', 'LIKE', '%'.$search.'%')  
                ->orwhere('status', 'LIKE', '%'.$search.'%')
                 ->select('salary_attribute.id as id','type as tipe','salary_attribute.name as name','salary_module_id as module_id'
                ,DB::raw('(select name from salary_module where id=salary_module_id) as module_name'),'status')           
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function salary_attribute_get_by_id($id){
    	
        $data = DB::table('salary_attribute')
                ->leftjoin('salary_module_detail','salary_attribute.id','=','salary_attribute_id')
                //->leftjoin('salary_module','salary_module_id','=','salary_module.id')
                ->where('salary_attribute.id', '=',$id)
                ->select('salary_attribute.id as id','type','salary_attribute.name as name','salary_module_id as module_id'
                ,DB::raw('(select name from salary_module where id=salary_module_id) as module_name'),'status')
                ->get();

           
    	///$data = salaryAttributeModel::where('id',$id)->get();
    	return $data;
    }
    
    static function salary_attribute_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM salary_attribute WHERE id in($id)");
        return $data;
    }  

    static function salary_attribute_get_status_active($request){

         $data = DB::SELECT("SELECT sa.id,sa.`name`,if(sd.`value` is null,'',sd.`value`)value FROM salary_attribute sa LEFT JOIN salary_attribute_data sd ON sa.`id`=sd.`salary_attribute_id` AND sd.`employee_id`='".$request->get('id')."' WHERE `status`='active'");

        return $data;

    } 


}
