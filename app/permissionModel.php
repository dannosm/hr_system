<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class permissionModel extends Model
{
    protected $table = 'permission';
    protected $primaryKey='id';
    protected $fillable = [
        'type', 'category', 'user_id','date_start','date_end','description','creator','days'
    ];

    static function permission_get($request){
    	
        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('permission')
                ->join('employee', 'permission.user_id', '=', 'employee.id')
                ->select('permission.*', 'employee.name')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('permission')
                ->join('employee', 'permission.user_id', '=', 'employee.id')
                ->select('permission.*', 'employee.name')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->orwhere('category', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

        return $data;
    }

    static function permission_get_by_id($id){
    	
    	 $data = DB::table('permission')
                ->join('employee', 'permission.user_id', '=', 'employee.id')
                ->select('permission.*', 'employee.name')
                ->where('permission.id',$id)
                ->get();
    	return $data;
    }

    static function permission_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM permission WHERE id in($id)");
        return $data;
    }
}
