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

        if(!empty($param['date']) && $param['range'] == true && !empty($param['date_end'])){
             $query[]= "date(check_in) >= '".$param['date']."' AND date(check_in) <= '".$param['date_end']."'";

        }elseif(!empty($param['date'])){
            $query[]= "date(check_in) >= '".$param['date']."'";
        }

        if(!empty($param['employee'])){
            $query[]= "user_id = '".$param['employee']."'";
        }
        
        if(!empty($query)){
            $query = " AND ".implode("AND ", $query);
        }else{
            $query = "";
        }
                if(empty($search)){

                   $data = DB::SELECT("SELECT aa.*, 
                           ee.name, 
                           (SELECT CONCAT(TIME(check_in), IF(check_in = check_out, '', ' s/d '), IF( 
                                           check_out = check_in, '', TIME(check_out))) 
                            FROM   attendance 
                            WHERE  user_id = aa.user_id 
                                   AND tipe = 'break' 
                                   AND DATE(check_in) = DATE(check_in) LIMIT 1)breacks 
                    FROM   attendance aa 
                           INNER JOIN employee ee 
                                   ON aa.user_id = ee.id 
                    WHERE  tipe = 'attendance'  $query limit $start,$length");
                      
                }else{

                      $data = DB::SELECT("SELECT aa.*,ee.name,
        (SELECT CONCAT(TIME(check_in),IF(check_in = check_out,'',' s/d '),IF(check_out = check_in,'',TIME(check_out))) FROM attendance WHERE user_id=aa.user_id AND tipe='break' AND DATE(check_in)=DATE(check_in) limit 1)breacks 
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


    static function attendance_calculate_late($month,$years){
        $data = DB::SELECT("SELECT user_id,tipe,breack_tipe,shift_id,
SUM(IF(tipe='attendance',(CASE WHEN CEILING(TIME_TO_SEC(TIMEDIFF(masuk,time_in))/60) > late_limit THEN 1 ELSE 0 END),0 ))telat_masuk,
SUM(IF(tipe='break', IF(breack_tipe ='duration',(CASE WHEN CEILING(TIME_TO_SEC(TIMEDIFF(pulang,masuk))/60) > breack_duration THEN 1 ELSE 0 END),(CASE WHEN pulang > breack_out THEN 1 ELSE 0 END) ),0
))telat_isti
FROM 
(SELECT aa.*,ee.`shift_id`,TIME(aa.check_in)masuk,TIME(aa.`check_out`)pulang FROM attendance aa INNER JOIN employee ee ON aa.`user_id` = ee.`id` AND MONTH(aa.check_in)='$month' AND YEAR(aa.check_in)='$years')ae 
INNER JOIN (SELECT * FROM shift )sf ON ae.shift_id=sf.id  GROUP BY user_id
");
        return $data;
    }


    static function attendance_persen_late(){
        $data = DB::SELECT("SELECT COUNT(user_id),
SUM(IF(tipe='attendance',(CASE WHEN CEILING(TIME_TO_SEC(TIMEDIFF(masuk,time_in))/60) > late_limit THEN 1 ELSE 0 END),0 ))telat_masuk
FROM 
(SELECT aa.*,ee.`shift_id`,TIME(aa.check_in)masuk,TIME(aa.`check_out`)pulang FROM attendance aa INNER JOIN employee ee ON aa.`user_id` = ee.`id` WHERE tipe='attendance' AND DATE(check_in)=DATE(NOW()))ae 

INNER JOIN (SELECT * FROM shift )sf ON ae.shift_id=sf.id  


");

        return $data;
    }
}
