<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class attendanceModel extends Model
{
	protected $table = 'attendance';

    static function attendance_get($request){
    	
        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];
        $param = $request['param'];

        $query = array();
        
        if(!empty($param['shift'])){

            $query[]= "ee.shift_id = '".$param['shift']."'";
        }

        if(!empty($param['division'])){
            $query[]= "ee.division_id = '".$param['division']."'";
        }

        if(!empty($param['date'])){
            $query[]= "date(check_in) = '".$param['date']."'";
        }

        if(!empty($query)){
            $query = " AND ".implode("AND ", $query);
        }else{
            $query = "";
        }
        
                if(empty($search)){

                   $data = DB::SELECT("SELECT aa.*,ee.name,
        (SELECT CONCAT(TIME(check_in),IF(check_in = check_out,'',' s/d '),IF(check_out = check_in,'',TIME(check_out))) FROM attendance WHERE user_id=aa.user_id AND tipe='break' AND DATE(check_in)=DATE(check_in) )breacks 
        FROM attendance aa inner join employee ee on aa.user_id=ee.id WHERE tipe = 'attendance' $query limit $start,$length");
                      
                }else{

                      $data = DB::SELECT("SELECT aa.*,ee.name,
        (SELECT CONCAT(TIME(check_in),IF(check_in = check_out,'',' s/d '),IF(check_out = check_in,'',TIME(check_out))) FROM attendance WHERE user_id=aa.user_id AND tipe='break' AND DATE(check_in)=DATE(check_in) )breacks 
        FROM attendance aa inner join employee ee on aa.user_id=ee.id WHERE tipe = 'attendance' $query AND (ee.name LIKE '%".$search."%' or aa.description LIKE '%".$search."%') limit $start,$length");
                }


        return $data;
    }

     static function attendance_get_count($request){


        
        $search=$request['search']["value"];

         $param = $request['param'];
        
        $query = array();
        
        if(!empty($param['shift'])){

            $query[]= "ee.shift_id = '".$param['shift']."'";
        }

        if(!empty($param['division'])){
            $query[]= "ee.division_id = '".$param['division']."'";
        }

        if(!empty($param['date'])){
            $query[]= "date(check_in) = '".$param['date']."'";
        }

        if(!empty($query)){
            $query = " AND ".implode("AND ", $query);
        }else{
            $query = "";
       }
       
        if(empty($search)){
           $data = DB::SELECT("SELECT COUNT(*)jum  
FROM attendance aa inner join employee ee on aa.user_id=ee.id WHERE tipe = 'attendance' $query ");
              
        }else{

              $data = DB::SELECT("SELECT count(*)jum 
FROM attendance aa inner join employee ee on aa.user_id=ee.id WHERE tipe = 'attendance' $query AND (ee.name LIKE '%".$search."%' or aa.description LIKE '%".$search."%') ");
        }

        return $data;
    }

    static function attendance_save($value){
    	$sql = DB::insert("INSERT INTO attendance(user_id,check_in,check_out,tipe)VALUES $value");
    	return $sql;
    }
}
