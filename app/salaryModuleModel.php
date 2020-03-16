<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class salaryModuleModel extends Model
{
    protected $table = 'salary_module';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'status', 'creator',
    ];

    static function salary_module_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('salary_module')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('salary_module')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('status', 'LIKE', '%'.$search.'%')             
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }


    static function salary_module_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('salary_module')
                ->get();
        }else{

             $data = DB::table('salary_module')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('status', 'LIKE', '%'.$search.'%')             
                ->get();
        }

        return $data;
    }

    static function salary_module_get_by_id($id){
    	
    	$users = salaryModuleModel::where('id',$id)->get();
    	return $users;
    }
    
    static function salary_module_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM salary_module WHERE id in($id)");
        return $users;
    } 
    static function get_extension_module($id){
        $data = DB::SELECT("SELECT sm.`status`,smd.* FROM salary_module sm INNER JOIN salary_module_detail smd ON sm.id=smd.`salary_module_id` WHERE sm.id='".$id."'");
        return $data;
    }  
}
