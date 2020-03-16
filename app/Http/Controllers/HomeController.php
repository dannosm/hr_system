<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\groupRoleDetailModel as grd;

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

        return view('home');
    }
}
