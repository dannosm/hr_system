<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class divisionModel extends Model
{
	protected $table = 'division';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'description', 'creator',
    ];

    static function division_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('division')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('division')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('description', 'LIKE', '%'.$search.'%')             
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function division_get_by_id($id){
    	
    	$users = divisionModel::where('id',$id)->get();
    	return $users;
    }
    
    static function division_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM division WHERE id in($id)");
        return $users;
    }    
    
}
