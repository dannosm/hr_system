<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class shiftModel extends Model
{
    protected $table = 'shift';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'time_in', 'time_out','late_limit','breack_tipe','breack_duration','breack_in','breack_out',
    ];

    static function shift_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];
    	
    	if(empty($search)){
           $data = DB::table('shift')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('shift')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('late_limit', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

        return $data;
    }


      static function shift_get_count($request){

        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('shift')
                ->get();
        }else{

             $data = DB::table('shift')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('late_limit', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }



    static function shift_get_by_id($id){
    	
    	$data = shiftModel::where('id',$id)->get();
    	return $data;
    }

    static function shift_delete($request){
        $id = implode(',', $request['list_id']);
        $shift = DB::DELETE("DELETE FROM shift WHERE id in($id)");
        return $shift;
    }
}
