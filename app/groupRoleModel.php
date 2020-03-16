<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class groupRoleModel extends Model
{
    protected $table = 'group_role';
    protected $primaryKey='group_role_id';
    protected $fillable = [
       'status','group_name'
    ];

    static function group_role_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('group_role')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('group_role')
                ->where('group_name', 'LIKE', '%'.$search.'%')
                ->where('status', 'LIKE', '%'.$search.'%')

                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }


    static function group_role_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('group_role')
                ->get();
        }else{

             $data = DB::table('group_role')
                ->where('group_name', 'LIKE', '%'.$search.'%') 
                ->where('status', 'LIKE', '%'.$search.'%')          

                ->get();
        }

        return $data;
    }

    static function group_role_get_by_id($id){
    	
    	 $users = DB::SELECT("SELECT gr.`status`,gr.`group_name`,role_id,role_write,role_read,role_delete,group_role_id FROM group_role gr INNER JOIN group_role_detail gd ON gr.`group_role_id`=gd.`group_id` WHERE gr.`group_role_id`='".$id."'");
        return $users;
    }
    
    static function group_role_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM group_role WHERE group_role_id in($id)");
        return $users;
    }    
}
