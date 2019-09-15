<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class positionModel extends Model
{
    protected $table = 'position';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'description', 'creator',
    ];

    static function position_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('position')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('position')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('description', 'LIKE', '%'.$search.'%')             
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function position_get_by_id($id){
    	
    	$users = positionModel::where('id',$id)->get();
    	return $users;
    }
    
    static function position_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM position WHERE id in($id)");
        return $users;
    }    
}
