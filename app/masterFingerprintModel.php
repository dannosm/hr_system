<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class masterFingerprintModel extends Model
{
	protected $table = 'master_fingerprints';
    protected $primaryKey='id';
    protected $fillable = [
        'name', 'ip','port','status','type',
    ];



   static function get_finger_print_by_id($id){
   	  
   	  $data = DB::table('master_fingerprints')
                ->where('id',$id)
                ->get();

        return $data;
   }

   //crund masater fingermprint
    static function finger_print_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

      if(empty($search)){
           $data = DB::table('master_fingerprints')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('master_fingerprints')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('ip', 'LIKE', '%'.$search.'%')     
                ->orwhere('port', 'LIKE', '%'.$search.'%')             
                ->offset($start)
                ->limit($length)
                ->get();
        }

      return $data;
    }

    //crund masater fingermprint
    static function finger_print_get_count($request){

        $search=$request['search']["value"];

      if(empty($search)){
           $data = DB::table('master_fingerprints')
                ->get();
        }else{

             $data = DB::table('master_fingerprints')
                ->where('name', 'LIKE', '%'.$search.'%')
                ->orwhere('ip', 'LIKE', '%'.$search.'%')     
                ->orwhere('port', 'LIKE', '%'.$search.'%')             
                ->get();
        }

      return $data;
    }

    static function finger_print_get_by_id($id){
      
      $users = masterFingerprintModel::where('id',$id)->get();
      return $users;
    }
    
    static function finger_print_delete($request){
        $id = implode(',', $request['list_id']);
        $users = DB::DELETE("DELETE FROM master_fingerprints WHERE id in($id)");
        return $users;
    }    

    //endcrute

    
}
