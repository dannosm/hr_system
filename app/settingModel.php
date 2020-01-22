<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class settingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'setting_json', 'image','type',
    ];

    static function setting_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('settings')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('settings')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function setting_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('settings')
                ->get();
        }else{

             $data = DB::table('settings')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }

    static function setting_get_by_id($id){
    	
    	$users = settingModel::where('id',$id)->get();
    	return $users;
    }
    
    static function setting_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM setting WHERE id in($id)");
        return $users;
    } 
}
