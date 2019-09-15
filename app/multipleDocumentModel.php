<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class multipleDocumentModel extends Model
{
    protected $table = 'multiple_document';
    protected $primaryKey='id';
    protected $fillable = [
        'title', 'description','creator','file_name','path','type'
    ];

    static function multiple_document_get($request){

        $length=$request['length'];
        $start=$request['start'];
        $search=$request['search']["value"];

    	if(empty($search)){
           $data = DB::table('multiple_document')
                ->offset($start)
                ->limit($length)
                ->get();
        }else{

             $data = DB::table('multiple_document')
                ->where('title', 'LIKE', '%'.$search.'%')
                ->orwhere('description', 'LIKE', '%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->get();
        }

    	return $data;
    }

    static function multiple_document_get_by_id($id){
    	
    	$data = multipleDocumentModel::where('id',$id)->get();
    	return $data;
    }
    
    static function multiple_document_delete($request){
        $id = implode(',', $request['list_id']);
        $data = DB::DELETE("DELETE FROM multiple_document WHERE id in($id)");
        return $data;
    } 
}
