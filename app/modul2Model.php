<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modul2Model extends Model
{
    static function select2_get_raw($post){
        
        if(empty($post['q'])){

            $data = DB::table($post['field'])
            	->limit(10)
                ->get();
        }else{
         $data = DB::table($field)
                ->where('text', 'LIKE', '%'.$post['q'].'%')
                ->limit(10)
                ->get();
        }
        return $data;
    }
}
