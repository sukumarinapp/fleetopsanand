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
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO' and DNW=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DCR = $result[0]->id;
            return redirect("/balance/".$DCR);
        }
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
                $DCR = 0; 
                $sql = "select * from tbl136 where replace(VNO, '-', '') = '$VNO' and DECL=0";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $DCR = $result[0]->id;
                }
                $ADT = 0;
                $sql = "select * from sales_audit where DCR=$DCR";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $ADT = 1;
                }
                if($ADT == 1){
                    return redirect("/balance/".$DCR);
                }else{
                    $rhplatforms = rhplatform::all();
                    $sql = "SELECT * FROM tbl361 where id <> 1 and id in (select PLF from driver_platform where driver_id = $driver_id)";
                    $rhplatforms = DB::select(DB::raw($sql));
                    return view('driver.driverrhsales', compact('rhplatforms','vehicle'));
                }
            }else{
                if($vehicle->VBM == "Hire Purchase" || $vehicle->VBM == "Rental"){
                    $DCR = 0; 
                    $sql = "select * from tbl136 where replace(VNO, '-', '') = '$VNO' and DECL=0";
                    $result = DB::select(DB::raw($sql));
                    if(count($result) > 0){
                        $vehicle->QTY = 1;
                        $vehicle->TOT = $vehicle->VAM;
                        $DCR = $result[0]->id;
                    }else{
                        return view('driver.nopending');
                    }
                    $sql = "select SSA from sales_rental where DCR = $DCR";
                    $result = DB::select(DB::raw($sql));
                    $vehicle->VAM = 0;
                    $vehicle->QTY = 0;
                    $vehicle->TOT = 0;
                    if(count($result) > 0){
                        foreach($result as $res){
                            $vehicle->VAM = $res->SSA;
                            $vehicle->TOT = $vehicle->TOT + $res->SSA;
                            $vehicle->QTY = $vehicle->QTY + 1;
                        }
                    }
                } 
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
        $DCR = 0;
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) <= 0){
           return view('driver.nopending'); 
        }else{
            $DCR = $result[0]->id;
        }

        $sql = "update tbl136 set CRS=1 where id=$DCR";
        DB::update(DB::raw($sql));

        $PLF = 0;
        $sql=" select c.PLF from vehicle a,driver b,driver_platform c where a.driver_id=b.id and b.id=c.driver_id and a.VNO='$VNO'";
        $platform = DB::select(DB::raw($sql));
        if(count($platform) > 0){
            $PLF = $platform[0]->PLF;
        }
        $SDT = date('Y-m-d');
        $SDT_dMY = date('d-M-Y');
        $expected_sales = Formulae::EXPS2($DCR);
        $sales['SDT'] = $SDT;
        $sales['PLF'] = $PLF;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = round($expected_sales,2);
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
        $CRS = 0;
        $sql = "SELECT * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){        
            $DCR = $result[0]->id;
            $CRS = $result[0]->CRS;
            $requestId = uniqid();
            $requestId = $VNO . "-" .$requestId;
            $response = Billbox::payNow($requestId,$request->cash_hidden,$request->options,$request->DCN,$cust_name);
            if($response->statusCode=="SUCCESS"){
                $TIM = date("Y-m-d H:i:s");
                $sql = "insert into tbl137 (SDT,DCR,CAN,VNO,RCN,VBM,RHN,SPF,TPF,RMT,ROI,RST,SSR,RTN,TIM) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$VBM','$RHN','$SPF','$TPF','$CPF','$ROI','0','$SSR','$requestId','$TIM')";
                DB::insert($sql);

                if($CRS == 1){
                    $sql2 = "select * from notification where sms_id='SMSE11'";
                    $result2 = DB::select(DB::raw($sql2));
                    if(count($result2) > 0){
                        $msg = $result2[0]->sms_text;
                        $sql3 = "select name,UZS,UCN from users where UAN='$CAN'";
                        $result3 = DB::select(DB::raw($sql3));
                        $CZN = "";
                        $UCN = "";
                        if(count($result3) > 0){
                            $CZN = $result3[0]->name." ".$result3[0]->UZS;
                            $UCN = $result3[0]->UCN;
                        }
                        $msg = str_replace("#{CZN}#",$CZN,$msg);
                        $msg = str_replace("#{DNM}#",$cust_name,$msg);
                        $msg = str_replace("#{VNO}#",$VNO,$msg);
                        //$msg = str_replace("#{EXPS}#",$CPF,$msg);
                        //$FTP = round(Formulae::FTP($DCR),2);
                        //$msg = str_replace("#{FTP}#",$FTP,$msg);
                        SMSFleetops::send($UCN,$msg);
                        $DAT = date("Y-m-d");
                        $TIM = date("H:i:s");
                        $CTX = "Client";
                        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$UCN','$msg','$DAT','$TIM','$CTX','$CZN')";
                        DB::insert($sql);
                    }
                }
                return view('driver.prompt');
            }else{
                $message = $response->statusMessage;
                return view('driver.error',compact('message'));
            }
        }else{
            return view('driver.nopending');
        }
  }

    public function balance($DCR)
    {
        $VNO = "";
        $RMT = 0;
        $CPF = 0;
        $BAL = 0;
        $RHN = 0;
        $RCN = "";
        $CPF = Formulae::EXPS2($DCR);
        $sql = "select * from tbl136 where id=$DCR";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0 ){
            $VNO = $result[0]->VNO;
        }

        $sql = "select * from sales_audit where DCR=$DCR";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0 ){
            if($result[0]->CPF != "" ) $CPF = $result[0]->CPF;
        }else{
            //return redirect('/driver');
        }
        $sql = "select RHN,RMT,RCN,VNO from tbl137 where DCR=$DCR and RST=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            foreach($result as $res){
                $RMT = $RMT + $res->RMT;
                $VNO = $res->VNO;
                $RCN = $res->RCN;
                $RHN = $res->RHN;
            }
        }
        $BAL = $CPF - $RMT;
        if($BAL <= 0) return view('driver.nopending');
        return view('driver.balance',compact('VNO','DCR','RCN','BAL','RHN'));
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
                            //SMSFleetops::send($TSM,$VBC0);
                            //echo $msg."<br>";
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
                    //SMSFleetops::send($TSM,$VBC0);
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
        $CML = 0;
        $DCR = 0;
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $CML = $result[0]->CML;
            $SDT = $result[0]->DDT;
            $DCR = $result[0]->id;
        }else{
           return view('driver.nopending'); 
        }
        $NWM = Formulae::NWM();
        $EXPS = Formulae::EXPS2($DCR);
        if($CML <= $NWM){
            $sql = "update tbl136 set DECL=1,attempts=0,alarm_off=1,alarm_off_attempts=0 where id = '$DCR'";
            DB::update($sql);
            return view('driver.driverhelpprev2',compact('sales'));
        }else{
            $DCN = "";
            $DNM = "";
            $sql = "UPDATE tbl136 set DNW=1 where id=$DCR";
            DB::update(DB::raw($sql));
            $sql = "SELECT c.DNM,c.DSN,c.DCN from vehicle b,driver c where b.driver_id=c.id and b.VNO ='$VNO'";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $DCN = $result[0]->DCN;
                $DNM = $result[0]->DNM." ".$result[0]->DSN;
            }
            $CPF = round(Formulae::EXPS2($DCR),2);
            $msg = "Hi ".$DNM.". Unfortunately, your claim did not work previous day was not successful. System reset failed. Please proceed to pay an amount of GHC ".$CPF." http://fleetopsgh.com/balance/".$DCR;
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Did not work claim failure";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
            $values = [$DCN,$msg,$DAT,$TIM,$CTX,$DNM];
            DB::insert($sql,$values);
            SMSFleetops::send($DCN,$msg);
            return view('driver.driverhelpprev3',compact('sales'));
        }
    }

    
    
}
