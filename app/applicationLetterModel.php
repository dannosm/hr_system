<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class applicationLetterModel extends Model
{
    protected $table = 'application_letter';
    protected $primaryKey='id';
    protected $fillable = [
        'title', 'description','creator','file_name','path'
    ];

    static function application_letter_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('application_letter')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('application_letter')
                ->where('title', 'LIKE', '%'.$search.'%')
                ->orwhere('description', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function application_letter_get_by_id($id){
    	
    	$data = applicationLetterModel::where('id',$id)->get();
    	return $data;
    }
    
    static function application_letter_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM application_letter WHERE id in($id)");
        return $data;
    } 
}
