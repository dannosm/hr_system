<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class userModel extends Model
{
	protected $table = 'users';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'email', 'password','username',
    ];

    static function user_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $users = DB::table('users')
                ->leftjoin('group_role','users.role_group','=','group_role.group_role_id')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $users = DB::table('users')
                ->leftjoin('group_role','users.role_group','=','group_role.group_role_id')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('username', 'LIKE', '%'.$search.'%')
                ->orwhere('email', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $users;
    }


 static function user_get_count($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

        if(empty($search)){
           $users = DB::table('users')
                ->get();
        }else{

             $users = DB::table('users')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('username', 'LIKE', '%'.$search.'%')
                ->orwhere('email', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $users;
    }

    static function user_get_by_id($id){
    	
    	$users = userModel::where('id',$id)
         ->leftjoin('group_role','users.role_group','=','group_role.group_role_id')
        ->get();
    	return $users;
    }
    
    static function user_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM users WHERE id in($id)");
        return $users;
    }    
}
