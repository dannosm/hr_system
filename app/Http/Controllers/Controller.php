<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authSession($id,$tipe)
    {


    	$datasession = Session::get('roles');
    	if(!isset($datasession[$id])){
    		return 0;
    	}
    	switch ($tipe) {
		    case 'r':

        	if($datasession[$id]->role_read != 1){
        		return 1;
        	}

		        break;
		    case 'w':

		    if($datasession[$id]->role_write != 1){

		        		return 1;
		        	}
		        
		        break;
		    case 'd':

		    if($datasession[$id]->role_delete != 1){

		        		return 1;
		        	}
		        
		        break;
		   
		}

    	
    }


}
