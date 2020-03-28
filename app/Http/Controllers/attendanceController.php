<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\attendanceModel;
use App\masterFingerprintModel as fingerPrint;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
       
       if($this->authSession(1,'r') == 1){return redirect('home');}
    	 
       return view('attendance.attendance');
    }

      function attendance_get(Request $request){

     	$draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
		try {

			$user = attendanceModel::attendance_get($request);

			$total = attendanceModel::attendance_get_count($request);

		    $output['draw']=$draw;
            if($total){
                $output['recordsTotal']=$output['recordsFiltered']=$total[0]->jum;
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

          if($this->authSession(1,'w') == 1){return json_encode(array('msg'=>'Your Not Have Permission', 'content'=>"Your Not Have Permission", 'success'=>FALSE));}

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
                

           $Connect = fsockopen($ip, $port, $errno, $errstr, 1);
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
                    $i=1;
                    $xcount = count($a_log_response);
                    for($a=0;$a<count($a_log_response);$a++)
                    {
                        $baris=Parse_Data($a_log_response[$a],"<Row>","</Row>");
                        $PIN=(int)Parse_Data($baris,"<PIN>","</PIN>");
                        $NAMA=Parse_Data($baris,"<NAME>","</NAME>");
                        $DateTime=Parse_Data($baris,"<DateTime>","</DateTime>");
                        $Verified=Parse_Data($baris,"<Verified>","</Verified>");
                        $Status=Parse_Data($baris,"<Status>","</Status>");

                        if($xcount == $i){
                           $string .= "('".$PIN."','".$DateTime."','".$DateTime."','$tipe');";
                        }else{
                           $string .= "('".$PIN."','".$DateTime."','".$DateTime."','$tipe'),";
                        }
                        $i++;
                    }//endfor
                      
             }else{
                 $notconnect[] = array("name"=>$value->name,"ip"=>$value->ip);
             }

         }//endforeach

         $attendance_save = attendanceModel::attendance_save($string);
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


     public function attendance_export_excel(Request $request){

        $end = $request->get('end');
        $start = $request->get('start');
        unset($request['start']);
        unset($request['end']);
        $request['start'] =0;
        $request['length']=1000;
        $request['param'] =array('date_end' => $end,'date'=>$start,'range'=> true);

        $att =  attendanceModel::attendance_get($request);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'NAME');
        $sheet->setCellValue('C1', 'CHECK IN');
        $sheet->setCellValue('D1', 'CHECK OUT');
        $sheet->setCellValue('E1', 'DESCRIPTION');

        $i = 1;

        foreach ($att as $key => $value) {
                $i++;
                $sheet->setCellValue('A'.$i,$value->user_id);
                $sheet->setCellValue('B'.$i, $value->name);
                $sheet->setCellValue('C'.$i, $value->check_in);
                $sheet->setCellValue('D'.$i, $value->check_out);
                $sheet->setCellValue('E'.$i, $value->description);


        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('attendance.xlsx');

     
        return json_encode(array('msg'=>'Sava Data Success', 'content'=>"", 'success'=>TRUE));    


    
    }





}
