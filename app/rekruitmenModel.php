<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class rekruitmenModel extends Model
{
    protected $table = 'rekruitmen';
    protected $primaryKey='id';
    protected $fillable = [
        'title','path'
    ];

    static function rekruitmen_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('rekruitmen')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('rekruitmen')
                ->where('title', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }


     static function rekruitmen_get_count($request){

        $search=$request['search']["value"];

        if(empty($search)){
           $data = DB::table('rekruitmen')
                ->get();
        }else{

             $data = DB::table('rekruitmen')
                ->where('title', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
    }

    static function rekruitmen_get_by_id($id){
    	
    	$data = rekruitmenModel::where('id',$id)->get();
    	return $data;
    }
    
    static function rekruitmen_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM rekruitmen WHERE id in($id)");
        return $data;
    } 
}
