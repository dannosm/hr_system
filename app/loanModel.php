<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class loanModel extends Model
{
    protected $table = 'loans';
    protected $primaryKey='id';
    protected $fillable = [
        'type', 'user_id','date','description','creator','amount','status'
    ];

    static function loan_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('loans')
                ->join('employee', 'user_id', '=', 'employee.id')
                ->select("loans.*",'employee.name')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('loans')
                ->join('employee', 'user_id', '=', 'employee.id')
                ->select("loans.*",'employee.name')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

        return $data;
    	
    }

      static function loan_get_count($request){

        $search=$request['search']["value"];
        
        if(empty($search)){
           $data = DB::table('loans')
                ->join('employee', 'user_id', '=', 'employee.id')
                ->select("loans.*",'employee.name')
                ->get();
        }else{

             $data = DB::table('loans')
                ->join('employee', 'user_id', '=', 'employee.id')
                ->select("loans.*",'employee.name')
                ->where('employee.name', 'LIKE', '%'.$search.'%')
                ->get();
        }

        return $data;
        
    }

    static function loan_get_by_id($id){
    	
    	$sql = DB::table('loans')
            ->join('employee', 'user_id', '=', 'employee.id')
                ->select("loans.*",'employee.name')
            ->get();

            return $sql;
    }

    static function loan_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM loans WHERE id in($id)");
        return $data;
    }
}
