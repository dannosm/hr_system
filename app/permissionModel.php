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

     static function permission_get_count($request){
        
        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('permission')
                ->join('employee', 'permission.user_id', '=', 'employee.id')
                ->select('permission.*', 'employee.name')
                ->get();
        }else{

             $data = DB::table('permission')
                ->join('employee', 'permission.user_id', '=', 'employee.id')
                ->select('permission.*', 'employee.name')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->orwhere('category', 'LIKE', '%'.$search.'%')
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

    static function permit_count(){
        $data = DB::select("SELECT COUNT(id)jum,MONTH(date_start)bulan FROM permission WHERE `type`='permission' AND year(date_start)=year(now()) GROUP BY MONTH(date_start)");
        return $data;
    }
     static function leave_count(){
        $data = DB::select("SELECT COUNT(id)jum,MONTH(date_start)bulan FROM permission WHERE `type`='leave' AND year(date_start)=year(now()) GROUP BY MONTH(date_start)");
        return $data;
        
    }
}
