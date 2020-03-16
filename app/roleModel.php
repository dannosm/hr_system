<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class roleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey='role_id';
    protected $fillable = [
        'name',
    ];

    static function role_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('role')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('role')
                ->where('role_name', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }


    static function role_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('role')
                ->get();
        }else{

             $data = DB::table('division')
                ->where('role_name', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }

    static function role_get_by_id($id){
    	
    	$users = roleModel::where('role_id',$id)->get();
    	return $users;
    }
    
    static function role_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM role WHERE role_id in($id)");
        return $users;
    }   
}
