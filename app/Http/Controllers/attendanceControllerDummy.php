<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\attendanceModel;
use App\masterFingerprintModel as fingerPrint;
class attendanceController extends Controller
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

    public function index(){

    	 return view('attendance.attendance');
    }

      function attendance_get(){

     	$draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
		try {

			$user = attendanceModel::attendance_get();
			$total = $user->count();


		    $output['draw']=$draw;
            if($total){
                $output['recordsTotal']=$output['recordsFiltered']=$total;
            }else{
                $output['recordsTotal']=$output['recordsFiltered']=$draw;   
            }
            $output['success']=TRUE;
            $output['token_status']='valid';
            $output['data'] = $user;
          

			echo json_encode($output);
		} catch (Exception $e) {
			echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));			
		}
    }


    public function attendance_update_data(Request $request){
    try {

         date_default_timezone_set('Asia/Jakarta');
        //$ip="3a6a022db65b.sn.mynetname.net:8080";
         $start = $request->get('start');
         $end = $request->get('end');
         $string = "";
         foreach ($request->get('mesin_finger') as $key => $value) {

            //get ip dan port fingerprint
            $mesin = fingerPrint::get_finger_print_by_id($value);
            $mesin = $mesin[0];
            $notconnect = []; 
            $ip = $mesin->ip;
            $port = $mesin->port;
            $tipe = $mesin->type;
            $key = 0;
            $errno='';
            $errstr='';
            $dumy = $this->dummy_data();
          
            $xcount = count($dumy);
            $i = 1;
            foreach ($dumy as $key => $value) {
                if($xcount == $i){
                   $string .= "('".$value['id']."','".$value['datetime']."','".$value['datetime']."','$tipe');";
                }else{
                   $string .= "('".$value['id']."','".$value['datetime']."','".$value['datetime']."','$tipe'),";
                }
                $i++;
            }
                


    /*        $Connect = fsockopen($ip, $port, $errno, $errstr, 1);
            if($Connect){
                                   
                       $soap_request="<GetAttLog><ArgComKey xsi:type='xsd:integer\'>".$key."</ArgComKey> <Arg> <Date xsi:type='xsd:string'>".$start."</Date></Arg></GetAttLog>" ;
                        $newLine="\r\n";
                        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                        fputs($Connect, "Content-Type: text/xml".$newLine);
                        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                        fputs($Connect, $soap_request.$newLine);
                        $buffer="";
                        while($Response=fgets($Connect, 1024)){
                                $buffer=$buffer.$Response;
                        }


                    $log_response=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                    $log_response=str_replace("\r\n","\n",$log_response);
                    $a_log_response=explode("\n",$log_response);
                    for($a=0;$a<count($a_log_response);$a++)
                    {
                        $baris=Parse_Data($a_log_response[$a],"<Row>","</Row>");
                        $PIN=(int)Parse_Data($baris,"<PIN>","</PIN>");
                        $NAMA=Parse_Data($baris,"<NAME>","</NAME>");
                        $DateTime=Parse_Data($baris,"<DateTime>","</DateTime>");
                        $Verified=Parse_Data($baris,"<Verified>","</Verified>");
                        $Status=Parse_Data($baris,"<Status>","</Status>");

                            if (date('Y-m-d',strtotime($DateTime)) >= $start AND  date('Y-m-d',strtotime($DateTime)) <= $end) {
                                DB::insert("INSERT INTO `attendance_tmphours`(`a_nik`, `a_datetime`) VALUES ('".$PIN."','".$DateTime."')");
                            }
                    }//endfor
                      
             }else{
                 $notconnect[] = array("name"=>$value->name,"ip"=>$value->ip);
             }*/

         }//endforeach

         $attendance_save = attendanceModel::attendance_save($string);
         echo $attendance_save;
         exit();
         echo json_encode(array('msg'=>'Update Data success', 'content'=>$e->getMessage(), 'success'=>TRUE, 'token_status'=>'valid'));          

         } catch (Exception $e) {
            echo json_encode(array('msg'=>'gagal', 'content'=>$e->getMessage(), 'success'=>FALSE, 'token_status'=>'invalid'));          
        }

    }



    function dummy_data(){
         date_default_timezone_set('Asia/Jakarta');
        for ($i=0; $i < 10 ; $i++) { 
            $data []=array('id' => $i+1,'datetime'=>date("Y-m-d H:i:s"));
        }
        return $data ;
    }





}
