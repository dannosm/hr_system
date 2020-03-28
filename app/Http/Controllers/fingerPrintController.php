<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\masterFingerprintModel as fingerprint;
use Auth;


class fingerPrintController extends Controller
{

	  public function __construct()
    {
        
		function Parse_Data($data,$p1,$p2){
		    $data=" ".$data;
		    $hasil="";
		    $awal=strpos($data,$p1);
		    if($awal!=""){
		        $akhir=strpos(strstr($data,$p1),$p2);
		        if($akhir!=""){
		            $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
		        }
		    }
		    return $hasil;    
		}
    }


   //start crud fingeerprint
     public function index(){
        
        if($this->authSession(3,'r') == 1){return redirect('home');}

         return view('finger_print.finger_print');
    }

    function finger_print_get(Request $request){

        try {
        $draw=$request['draw'];

            $data = fingerprint::finger_print_get($request);
            $total = fingerprint::finger_print_get_count($request)->count();

            $output['draw']=$draw;
            if($total){
                $output['recordsTotal']=$output['recordsFiltered']=$total;
            }else{
                $output['recordsTotal']=$output['recordsFiltered']=$draw;   
            }
            $output['success']=TRUE;
            $output['token_status']='valid';
            $output['data'] = $data;
          

            echo json_encode($output);
        } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }
    }

    function finger_print_add(){

        if($this->authSession(3,'2') == 1){return redirect('home');}

         return view('finger_print.finger_print_add');
    }

    function finger_print_save(Request $request){
        try{
           
           if($this->authSession(3,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}
         
            $user = Auth::user();
            $add = new fingerprint;
            $add->name = $request->get('name');
            $add->ip = $request->get('ip');
            $add->port = $request->get('port');
            $add->status = $request->get('status');
            $add->type = $request->get('type');
           // $add->creator = $user->id;
            $result = $add->save();
            
            return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function finger_print_edit($id){

        if($this->authSession(3,'w') == 1){return redirect('home');}


         $data = fingerprint::finger_print_get_by_id($id);

         return view('finger_print.finger_print_edit')->with('data',$data[0]);
    }

    function finger_print_update(Request $request){
        try{

           if($this->authSession(3,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

             $user = Auth::user();
             $add = fingerprint::where('id', $request->get('id'))->firstOrFail();
             $add->name = $request->get('name');
             $add->ip = $request->get('ip');
            $add->port = $request->get('port');
            $add->status = $request->get('status');
            $add->type = $request->get('type');
             $result = $add->save();
            
             return json_encode(array('msg'=>'Sava Data Success', 'content'=>$result, 'success'=>TRUE));    

        } catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }

    function finger_print_delete(Request $request){
        try{

           if($this->authSession(3,'d') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $delete = fingerprint::finger_print_delete($request);
            return json_encode(array('msg'=>'Delete Data Success', 'content'=>$delete, 'success'=>TRUE));    
        }catch (Exception $e) {
            return json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }  
    }


    //endcrud fingeerprint


    public function finger_print_upload_user(){

           if($this->authSession(3,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}


    	$IP = "192.168.100.206";
    	$PORT = "4370";
    	$Key = 0;
    	 if($IP!=""){
    	 	echo "sa";
    	 	 $Connect = fsockopen($IP, $PORT, $errno, $errstr, 1);
                if($Connect){
                #Get id or nik and name
                $id='10';
                $nama="dannusm";
                #soap php to mesin
                $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN>".$id."</PIN><Name>".$nama."</Name></Arg></SetUserInfo>";
                    $newLine="\r\n";
                    fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                    fputs($Connect, "Content-Type: text/xml".$newLine);
                    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                    fputs($Connect, $soap_request.$newLine);
                    $buffer="";
                    while($Response=fgets($Connect, 1024)){
                        echo $buffer=$buffer.$Response;
                    }
                }else echo "Koneksi Gagal";
                  
                $buffer=Parse_Data($buffer,"<Information>","</Information>");
                echo "<B>Result:</B><BR>";
                echo $buffer;
            }//endif connetion 




    }


     public function finger_print_export_absen()
    {

           if($this->authSession(3,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

    	exit();
        #date zona
        date_default_timezone_set('Asia/Jakarta');
        
        #date today
        $tgl = date('Y-m-d');
        #get ip status access 1
        //$ip_url = DB::table('ip_urls')->where('ip_access','1')->get();

        #looping and get data attendancen by ip
        //foreach ($ip_url as $taks) {

        $IP = "192.168.100.206";
    	$PORT = "4370";
    	$key = 0;
        error_reporting(0);

       #validasi ip connet or not         
        $Connect = fsockopen($IP, $PORT, $errno, $errstr, 1);
          

                   $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                    if($Connect)
                    {
                       $soap_request="<GetAttLog><ArgComKey xsi:type='xsd:integer\'>".$key."</ArgComKey> <Arg> <Date xsi:type='xsd:string'>".$tgl."</Date> </Arg></GetAttLog>" ;
                        $newLine="\r\n";
                        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                        fputs($Connect, "Content-Type: text/xml".$newLine);
                        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                        fputs($Connect, $soap_request.$newLine);
                        $buffer="";
                        while($Response=fgets($Connect, 1024)){
                                $buffer=$buffer.$Response;
                              
                        }
                    }//ifconnect
                    else{


                    }//else


                    $log_response=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                    $log_response=str_replace("\r\n","\n",$log_response);
                    $a_log_response=explode("\n",$log_response);
                    for($a=0;$a<count($a_log_response);$a++)
                    {
                        $baris=Parse_Data($a_log_response[$a],"<Row>","</Row>");
                        $PIN=(int)Parse_Data($baris,"<PIN>","</PIN>");
                        echo $NAMA=Parse_Data($baris,"<NAME>","</NAME>");
                       echo $DateTime=Parse_Data($baris,"<DateTime>","</DateTime>");
                        $Verified=Parse_Data($baris,"<Verified>","</Verified>");
                        $Status=Parse_Data($baris,"<Status>","</Status>");

                        echo "das";
					 }//LOOP for i
        // }//foreach


    }


    public function finger_print_get_all_mesin(Request $request){
        try {
            
           if($this->authSession(5,'r') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

            $fingerprint = fingerprint::all();

                if($fingerprint->count() > 0){
                    return json_encode(array('msg'=>'Success', 'content'=>$fingerprint, 'success'=>TRUE));    
                }else{
                    return json_encode(array('msg'=>'Finger Print Tidak Ditemukan', 'content'=>$fingerprint, 'success'=>FALSE));    
                }

          
        } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }

    }
}
