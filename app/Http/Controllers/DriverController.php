<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\rhplatform;
use App\Formulae;
use App\TrackerSMS;
use App\tbl137;
use App\tbl136;
use App\Billbox;
use App\SMSFleetops;

class DriverController extends Controller
{
    public function index()
    {
        $time = array();
        $time['current_date'] = date("Y-m-d");
        $time['current_time'] = date("H.i");
        return view('driver.index',compact('time'));
    }

    public function drivervno()
    {
        return view('driver.drivervno');
    }

    public function drivervnovalid(Request $request)
    {
        $VNO = trim($request->get("VNO"));
        $VNO = str_replace(' ', '', $VNO);        
        $VNO = str_replace('-', '', $VNO);        
        $DCN = trim($request->get("DCN"));
        //select * from vehicle where replace(VNO, '-', '') = 'GN712217';
        $sql = "SELECT a.*,b.VBM,b.DCN,b.VAM,b.VPF FROM vehicle a,driver b where a.driver_id=b.id and  replace(a.VNO, '-', '') = '$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        if(count($vehicle) > 0){
            $vehicle = $vehicle[0];
            $vehicle->DCN = $DCN; 
            $driver_id = $vehicle->driver_id;
            if($vehicle->VBM == "Ride Hailing"){
                $rhplatforms = rhplatform::all();
                $sql = "SELECT * FROM tbl361 where id <> 1 and id in (select PLF from driver_platform where driver_id = $driver_id)";
                $rhplatforms = DB::select(DB::raw($sql));
                return view('driver.driverrhsales', compact('rhplatforms','vehicle'));
            }else{
                return view('driver.driverrental',compact('vehicle'));
            }
        }else{
			return redirect('/drivervnoerror')->with('error', 'Vehicle not found');
        }
    }

    public function driverrental()
    {
        return view('driver.driverrental');
    }

    public function driverrhsales()
    {
        return view('driver.driverrhsales');
    }

    public function drivervnoerror()
    {
        return view('driver.drivervnoerror');
    }

    public function driverhelp($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp',compact('sales'));
    }

    public function driverhelp1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp1',compact('sales'));
    }

    public function driverhelp2($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $SDT = date('Y-m-d');
        $SDT_dMY = date('d-M-Y');
        $expected_sales = Formulae::EXPS($SDT,$VNO);
        $sales['SDT'] = $SDT;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = $expected_sales;
        return view('driver.driverhelp2',compact('sales'));
    }

    public function driverpay(Request $request)
    {
        $SSR = $request->SSR;
        $VBM = $request->VBM;
        $plat_id_hidden = 0;
        $earning_hidden = 0;
        $cash_hidden = 0;
        $trips_hidden = 0;
        if($VBM=="Ride Hailing"){
            $plat_id_hidden = trim($request->get("plat_id_hidden"));
            $earning_hidden = trim($request->get("earning_hidden"));
            $cash_hidden = trim($request->get("cash_hidden"));
            $trips_hidden = trim($request->get("trips_hidden"));
        }else{
            $cash_hidden = trim($request->get("SSA"));
        }
        $options = Billbox::listPayOptions();
        $sales = array();
        $sales['VBM'] = $VBM;
        $sales['VNO'] = trim($request->get("VNO"));
        $sales['DCN'] = trim($request->get("DCN"));
        $sales['plat_id_hidden'] = $plat_id_hidden;
        $sales['earning_hidden'] = $earning_hidden;
        $sales['cash_hidden'] = round($cash_hidden,2);
        $sales['trips_hidden'] = $trips_hidden;
        $sales['SSR'] = $SSR;
        return view('driver.driverpay',compact('sales','options'));
    }

    public function driverpaysave(Request $request)
    {
        $ROI = $request->options;
        $VNO = $request->VNO;
        $VBM = $request->VBM;
        $sql = "SELECT a.CAN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and a.VNO='$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        $cust_name = $vehicle[0]->DNM . " " . $vehicle[0]->DSN;
        $CAN = $vehicle[0]->CAN;
        $SDT = date('Y-m-d');
        $RCN = $request->RCN;
        $VNO = $request->VNO;
        $RCN = $request->DCN;
        $RHN = $request->plat_id_hidden;
        $SPF = $request->earning_hidden;
        $CPF = $request->cash_hidden;
        $TPF = $request->trips_hidden;
        $SSR = $request->SSR;
        $DCR = 0;
        $sql = "SELECT * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){        
            $DCR = $result[0]->id;
            $requestId = uniqid();
            $requestId = $VNO . "-" .$requestId;
            $response = Billbox::payNow($requestId,$request->cash_hidden,$request->options,$request->DCN,$cust_name);
            print_r($response);
            if($response->statusCode=="SUCCESS"){
                $TIM = date("Y-m-d H:i:s");
                $sql = "insert into tbl137 (SDT,DCR,CAN,VNO,RCN,VBM,RHN,SPF,TPF,RMT,ROI,RST,SSR,RTN,TIM) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$VBM','$RHN','$SPF','$TPF','$CPF','$ROI','0','$SSR','$requestId','$TIM')";
                echo $sql;
                DB::insert($sql);
                return view('driver.prompt');
            }else{
                $message =$response->statusMessage;
                return view('driver.error',compact('message'));
            }
        }else{
            return view('driver.nopending');
        }
  }

    public function driverhelp3($VNO,$DCN)
    {
       $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        
        $SDT_dMY = date('d-M-Y', strtotime("-1 days"));
        $expected_sales = Formulae::expected_sales($VNO);
        $sales['SDT'] = $SDT;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = $expected_sales;
        return view('driver.driverhelp3',compact('sales'));
    }

    public function driverpaysuccess()
    {
        return view('driver.driverpaysuccess');
    }

//http://fleetopsgh.com/billbox?status=1&transac_id=6109608da766c&cust_ref=8723498807290116&pay_token=5e455780-9c2b-47f2-8387-a024c577263c
    public function billbox(Request $request)
    {
        $query = $request->all();
        $RST = $query['status'];
        $RTN = $query['transac_id'];
        echo $RTN."\n";
        if($RST == 0){
            $sql = "SELECT a.*,b.VBC0,b.TSM from tbl137 a,vehicle b where a.VNO=b.VNO and a.RTN = '$RTN'";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $DCR = $result[0]->DCR;
                $VNO = $result[0]->VNO;
                $SDT = $result[0]->SDT;
                $VBM = $result[0]->VBM;
                $RCN = $result[0]->RCN;
                $RMT = $result[0]->RMT;
                $VBC0 = $result[0]->VBC0; 
                $TSM = $result[0]->TSM;
                echo $RTN."\n";
                $sql = "update tbl137 set RST=1 where RTN = '$RTN'";
                DB::update($sql);
                if($VBM == "Ride Hailing"){
                    $EXPS = Formulae::EXPS($SDT,$VNO);
                    echo $EXPS."<br>";
                    $sql = "SELECT sum(RMT) as TOTDEC from tbl137 where RST = 1 and DCR ='$DCR'";
                    $result = DB::select(DB::raw($sql));
                    if(count($result)>0){
                        $TOTDEC = $result[0]->TOTDEC;
                        echo $TOTDEC."<br>";
                        if($TOTDEC >= $EXPS){
                            $sql = "update tbl136 set DECL = 1 where id = '$DCR'";
                            DB::update($sql);
                            $msg = "Thank you for a successful sales declaration.Fuel consumed for the sales declared and offline trips (if any) are being measured and shall be communicated to you in a separate message.";                  
                            SMSFleetops::send($TSM,$VBC0);
                            echo $msg."<br>";
                            $DAT = date("Y-m-d");
                            $TIM = date("H:i:s");
                            $CTX = "Sales Declaration";
                            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX) values ('$RCN','$msg','$DAT','$TIM','$CTX')";
                            DB::insert($sql);
                            SMSFleetops::send($RCN,$msg);
                        }else{
                            $sql = "update tbl136 set DECL = 1 where id = '$DCR'";
                            DB::update($sql);
                            $msg="Cash Declared is Incorrect. Further to our checks, the cash collected you have accounted for is incorrect. Please send remaining cash immediately else we shall be compelled to enforce the policy. The car owner has been notified of this issue accordingly.";
                            echo $msg."<br>";
                            $DAT = date("Y-m-d");
                            $TIM = date("H:i:s");
                            $CTX = "Sales Declaration";
                            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX) values ('$RCN','$msg','$DAT','$TIM','$CTX')";
                            DB::insert($sql);
                            SMSFleetops::send($RCN,$msg);
                        }
                    }
                }else{
                    SMSFleetops::send($TSM,$VBC0);
                    $msg="Thank you for a successful payment of GHC ".$RMT.".";
                    echo $msg."<br>";
                    SMSFleetops::send($RCN,$msg);
                }           
                
            }
        }

        $cust_ref = $query['cust_ref'];
        $pay_token = $query['pay_token'];
        $callback_time = date("Y-m-d H:i");
        $sql = "insert into billbox (status,transac_id,cust_ref,pay_token,callback_time) values ('$RST','$RTN','$cust_ref','$pay_token','$callback_time')";
            DB::insert($sql);
    }

    public function driverpayerror()
    {
        return view('driver.driverpayerror');
    }
    
    public function driverhelpprev1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelpprev1',compact('sales'));
    }

    public function driverhelpprev2($VNO,$DCN)
    {
        $sales = array();
        $SDT = date('Y-m-d', strtotime("-1 days"));
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $CML = Formulae::CML($SDT,$VNO);
        $NWM = Formulae::NWM();
        if($CML <= $NWM){
            $sql = "update tbl136 set DECL=1 where DDT = '$SDT' AND VNO='$VNO'";
            DB::update($sql);
            TrackerSMS::unblock($VNO);
            return view('driver.driverhelpprev2',compact('sales'));
        }else{
            return view('driver.driverhelpprev3',compact('sales'));
        }
    }

    
    
}
