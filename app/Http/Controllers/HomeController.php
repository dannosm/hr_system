<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\groupRoleDetailModel as grd;
USE App\employeeModel as emp;
use App\permissionModel;
use App\attendanceModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    if(empty(Session::get('roles'))){
        
        $data = array();
        foreach (grd::group_role_detail_get_by_id(Auth::user()->role_group) as $key => $value) {
            $data[$value->role_id] = $value;
        }

        Session::put('roles',$data);
     }
    
    $att = emp::employee_all_status_get();
    $persen = attendanceModel::attendance_persen_late();

    $persen = ceil((($att[0]->ee_jum * $persen[0]->telat_masuk) / 100)*$att[0]->ee_jum);

    $permit = permissionModel::permit_count();
    $leave = permissionModel::leave_count();
    $per = [];
    $per2 = [];
    $lev = [];

    for ($i=0; $i < count($permit); $i++) { 
         $per[@$permit[$i]->bulan]= @$permit[$i]->jum;
     } 
     for ($i=1; $i < 13 ; $i++) { 
        $per2[$i] =empty(@$per[$i]) ? 0:@$per[$i];
     }
     $per = array();
     for ($i=0; $i < count($permit); $i++) { 
         $per[@$leave[$i]->bulan]= @$leave[$i]->jum;
     } 
     for ($i=1; $i < 13 ; $i++) { 
        $lev[$i] =empty(@$per[$i]) ? 0:@$per[$i];
     }
        return view('home')->with('data',$att)->with('leave',$lev)->with('permit',$per2)->with('persen',$persen);
    }

    static function resession(){

        
        
        $data = array();
        foreach (grd::group_role_detail_get_by_id(Auth::user()->role_group) as $key => $value) {
            $data[$value->role_id] = $value;
        }

        Session::put('roles',$data);

    }
}
