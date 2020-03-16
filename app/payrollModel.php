<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class payrollModel extends Model
{
    protected $table = 'payroll';
    protected $primaryKey='payroll_id';
    protected $fillable = [
        'employee_id', 'sync_date', 'json_data',
    ];


     static function payroll_get_data_by_id($request){

        $data = DB::SELECT("SELECT py.*,em.`name`,em.id nik,DATE_FORMAT(py.`sync_date`,'%M %Y')slip_date,(SELECT `name` FROM division WHERE id=em.`division_id`)division,(SELECT `name` FROM `position` WHERE id=em.`position_id`)positions FROM payroll py INNER JOIN employee em ON py.`employee_id`=em.`id` WHERE employee_id ='".trim($request['employee_id'])."' AND DATE_FORMAT(sync_date,'%M')='".trim($request['periode'])."' AND YEAR(sync_date)='".trim($request['years'])."' ");
        return $data;
    }  

    static function get_payroll_list($request){

       // $data = DB::SELECT("SELECT em.id nik,em.`name`,IFNULL(py.`json_data`,0)json_data FROM employee em  LEFT JOIN payroll py ON em.id=py.`employee_id` WHERE em.`status`='Active' AND DATE_FORMAT(sync_date,'%M')='".trim($request['periode'])."' AND YEAR(sync_date)='".trim($request['years'])."' ");

        $data = DB::SELECT("SELECT nik,`name`,IFNULL(json_data,0)json_data FROM (SELECT id nik,`name` name FROM employee WHERE `status`='Active' GROUP BY id)emp
LEFT JOIN (SELECT employee_id ,json_data FROM payroll WHERE DATE_FORMAT(sync_date,'%M')='".trim($request['periode'])."' AND YEAR(sync_date)='".trim($request['years'])."' )py ON emp.nik=py.employee_id");
        return $data;
    } 


    static function payroll_sync_delete_month($years,$periode){
        $data = DB::DELETE("DELETE FROM payroll WHERE MONTH(sync_date)='$periode' AND YEAR(sync_date)='$years'");
        return $data;
    } 

}
