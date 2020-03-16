<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class groupRoleDetailModel extends Model
{
    protected $table = 'group_role_detail';
    protected $primaryKey='id';
    protected $fillable = [
        'role_id', 'role_read','role_write','role_delete','group_id'
    ];


    static function group_role_detail_get_by_id($id){
		
		$data = DB::table('group_role_detail')
                ->where('group_id',$id)
                ->get();
    	
        return $data;
    }

    static function delete_raw_all($id){
    	$detele =  DB::DELETE("DELETE FROM group_role_detail where group_id='$id'");
    }
}
