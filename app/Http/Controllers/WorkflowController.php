<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\SMSFleetops;
use Illuminate\Support\Facades\Hash;
use App\Formulae;

class WorkflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($BP){
        if($BP == "BPJ2"){
            if(Auth::user()->usertype=="Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ2==1)){
            }else{
                echo "Access Denied";
                die;
            }            
        }
        if($BP == "BPJ1"){
            if(Auth::user()->usertype=="Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ1==1)){
            }else{
                echo "Access Denied";
                die;
            }            
        }
    }

    public function index()
    {
        $this->check_access("BPJ2");
        $sql = "select d.id as vid,a.*,b.DNM,b.DSN from tbl136 a,driver b,vehicle d where a.driver_id=b.id and a.VNO=d.VNO and a.DECL=0 and a.DDT = (select max(DDT) from tbl136 c where a.VNO=c.VNO and DECL=0 group by VNO) order by DDT";
        $vehicles = DB::select(DB::raw($sql));
        foreach($vehicles as $vehicle){
            $DCR = $vehicle->id;
            $RMT = 0;
            $sql2 = "select sum(RMT) as PAID from tbl137 where DCR=$DCR and RST=1";
            $paid = DB::select(DB::raw($sql2));
            if(count($paid) > 0){
                if($paid[0]->PAID != "" ) $RMT = $paid[0]->PAID;
            }
            $vehicle->ADT = 0;
            $sql2 = "select * from sales_audit where DCR=$DCR";
            $result = DB::select(DB::raw($sql2));
            if(count($result) > 0){
                $vehicle->ADT = 1;
            }
            $CCEI = round(Formulae::CCEI2($DCR),2);
            $vehicle->RMT = $RMT;
            $vehicle->CCEI = $CCEI;
        }
        return view('workflow',compact('vehicles'));
    }

    public function workflowlog($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Workflow Log';
        $sql = "select * from tbl140 where WST >= '$from' and WST <='$to'";
        $workflow = DB::select(DB::raw($sql));
        return view('workflowlog',compact('workflow','title','from','to'));
    }

    public function vehiclelog($from,$to)
    {
        $sql = "select a.*,b.DNM,b.DSN from vehicle_log a,driver b where LDT >= '$from' and LDT <='$to' and a.DID=b.id order by TIM desc";
        $title = 'Vehicle Assign Log';
        $vehiclelog = DB::select(DB::raw($sql));
        return view('vehiclelog',compact('vehiclelog','title','from','to'));
    }
    public function rhreport($from,$to)
    {
        $sql = "select a.*,b.DCN from tbl136 a,driver b where a.driver_id=b.id and a.VBM = 'Ride Hailing' and DDT >='$from' and DDT <='$to' order by DDT desc";
        $title = 'RH Daily Report';
        $rhreport = DB::select(DB::raw($sql));
        foreach($rhreport as $sale){
            $DCR = $sale->id;
            $VNO = $sale->VNO;
            $sql = "select * from tbl137 where DCR=$DCR and SSR='Driver' and RST=1";
            $tbl137 = DB::select(DB::raw($sql));
            if(count($tbl137) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = round(Formulae::CCEI2($DCR),2);
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }else{
                $sale->EXPS = "";
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }

            $sql = "select * from tbl136 where id=$DCR and DNW=1";
            $tbl136 = DB::select(DB::raw($sql));
            if(count($tbl136) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }

            $sql = "select * from tbl136 where id=$DCR and CRS=1";
            $tbl136 = DB::select(DB::raw($sql));
            if(count($tbl136) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }
        }
        return view('rhreport',compact('rhreport','title','from','to'));
    }

    public function sales($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Pending Sales (RT/HP)';
        $sql="select a.VBM,b.*,c.DNM,c.DSN from tbl136 a,sales_rental b,driver c where a.id=b.DCR and a.driver_id=c.id and b.SDT >='$from' and b.SDT <='$to' and DECL=0 and a.id not in (select DCR from tbl137 where RST=1) order by b.SDT desc";
        $sales = DB::select(DB::raw($sql));
        return view('sales',compact('sales','title','from','to'));
    }

    public function collection($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'General Sales Ledger';
        $sql = "select * from tbl137 where SDT >='$from' and SDT <='$to' order by SDT desc";
        $sales = DB::select(DB::raw($sql));
        return view('collection',compact('sales','title','from','to'));
    }

    public function notificationslog($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Notification Log';
        $sql = "select * from sms_log where DAT >='$from' and DAT <='$to' order by DAT desc";
        $logs = DB::select(DB::raw($sql));
        return view('notificationslog',compact('logs','title','from','to'));
    }
     public function alertlog($from,$to)
        {
        $this->check_access("BPJ2");
        $title = 'Alert Log';
        $sql = "select * from sms_log where DAT >='$from' and DAT <='$to' order by DAT desc";
        $logs = DB::select(DB::raw($sql));
        return view('alertlog',compact('logs','title','from','to'));
        }

    public function override($VNO)
    {
        $this->check_access("BPJ2");
        $id = $VNO;
        $sql = "SELECT d.alarm_off,d.DES,a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c,tbl136 d where d.DECL=0 and a.VNO=d.VNO and a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('override',compact('vehicle'));
    }

    public function saveoverride(Request $request)
    {
        $this->check_access("BPJ2");
        $email = trim($request->UAN);
        $password = $request->password;
        $CAN = $request->CAN;
        $WCI = $request->WCI;
        $VNO = $request->VNO;
        $OAC = $request->OAC;
        $VID = $request->VID;
        $sql = "SELECT * FROM users where email='$email' and UTV=1";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            if (Hash::check($password, $users[0]->password)) {
                $sql = "SELECT * FROM tbl136 where VNO='$VNO' and DECL = 0";
                $tbl136 = DB::select(DB::raw($sql));
                $DCR = 0;
                $DES = "";
                $ODT = date("Y-m-d");
                $WST = date("Y-m-d");
                if(count($tbl136) > 0){
                    $DCR = $tbl136[0]->id;
                    $DES = $tbl136[0]->DES;
                    $WST = $tbl136[0]->DDT;
                }
                $UAN = $users[0]->UAN;                
                $OTT = date("H.i");
                $WTP = "";
                if($DES == "A4"){
                    $sql = "update tbl136 set DECL=1,attempts=0 where id='$DCR'";
                    DB::update($sql);
                    $WTP = "Vehicle Unblocked";
                }else{
                    $sql = "update tbl136 set alarm_off=1,alarm_off_attempts=0 where id='$DCR'";
                    DB::update($sql);
                    $WTP = "Buzzer Turned Off";
                }
                
                $sql = "insert into tbl024 (DCR,ODT,OTT,CAN,VNO,UAN,OAC) values ($DCR,'$ODT','$OTT','$CAN','$VNO','$UAN','$OAC')";
                DB::insert($sql);
                $WNB = "WFL" . str_pad($DCR,3,'0',STR_PAD_LEFT);
                
                $sql = "insert into tbl140 (DCR,WST,WCI,UAN,CAN,VNO,WNB,WTP,WCD) values ($DCR,'$WST','$WCI','$UAN','$CAN','$VNO','$WNB','$WTP','$ODT')";
                DB::insert($sql);
                $sql = "SELECT a.*,b.DNM,b.DSN,b.DCN FROM vehicle a,driver b where a.driver_id=b.id and a.id=$VID";
                $vehicle = DB::select(DB::raw($sql));
                $VZC0 = $vehicle[0]->VZC0;
                $VBC0 = $vehicle[0]->VBC0; 
                $TSM = $vehicle[0]->TSM;
                $DNM = $vehicle[0]->DNM . " " . $vehicle[0]->DSN ;
                $DCN = $vehicle[0]->DCN;
                $TSM = $vehicle[0]->TSM;

                $DAT = date("Y-m-d");
                $TIM = date("H:i:s");

                if($DES == "A4"){
                    $CTX = "Vehicle Unblocked"; 
                    $MSG = "Hi ". $DNM." your vehicle has been unblocked successfully.";
                    
                    $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$MSG','$DAT','$TIM','$CTX','$DNM')";
                    DB::insert($sql);
                    SMSFleetops::send($TSM,$VBC0);                    
                    SMSFleetops::send($DCN,$MSG);
                    return redirect('/workflow')->with('message', 'Vehicle Mobilized Successfully');
                }else{
                    $CTX = "Buzzer Turned Off";

                    $MSG = "Hi ". $DNM." your vehicle buzzer has been turned off successfully.";
                    
                    $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$MSG','$DAT','$TIM','$CTX','$DNM')";
                    DB::insert($sql);
                    SMSFleetops::send($TSM,$VZC0);
                    SMSFleetops::send($DCN,$MSG);
                    return redirect('/workflow')->with('message', 'Vehicle Buzzer Turned off Successfully');
                }
            } else {
               return redirect('/override/'.$VID)->with('error', 'Invalid User Credentials')->withInput();
            }
        }else{
            return redirect('/override/'.$VID)->with('error', 'Username does not exist or inactive')->withInput();
        }
    }

    public function overrides($VNO)
    {
        $this->check_access("BPJ2");
        $id = $VNO;
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('overrides',compact('vehicle'));
    }
    
    public function auditsrch()
    {
        $this->check_access("BPJ1");
        $sql = "SELECT a.* from vehicle a,driver b where a.driver_id=b.id and VTV=1 and b.VBM='Ride Hailing'";
        $vehicles = DB::select(DB::raw($sql));
        return view('auditsrch',compact('vehicles'));
        
    }

    public function auditing($VNO,$DCR)
    {
        $this->check_access("BPJ1");
        $id = $VNO;
        $sql = "SELECT d.PLF,e.RHN,a.*,b.UAN,b.name,c.DNO,c.DNM,c.DSN,c.DCN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $VNO = $vehicle->VNO;
        $sql = "SELECT * from tbl137 where DCR=$DCR and id = (select max(id) from tbl137 where DCR=$DCR)";
        $result = DB::select(DB::raw($sql));
        $vehicle->RCN = $result[0]->RCN;
        return view('auditing',compact('vehicle'));
    }

    public function auditingsave(Request $request)
    {
        $this->check_access("BPJ1");
        $rhvisibility = ($request->get("rhvisibility") != null) ? 1 : 0;
        $VBM = "Ride Hailing";
        $VID = $request->VID;
        $VNO = $request->VNO;
        $CAN = $request->CAN;
        $UAN = $request->UAN;
        $RCN = $request->RCN;
        $SPF = $request->SPF;
        $TPF = $request->TPF;
        $CPF = $request->RMT;
        $RHN = $request->RHN;
        $USR = Auth::user()->UAN;
        $ADT = date('Y-m-d');
        $DCR = 0;
        $DCN = "";
        $DNM = "";
        $sql = "SELECT a.DDT,a.id,c.DNM,c.DSN,c.DCN from tbl136 a,vehicle b,driver c where a.VNO=b.VNO and b.driver_id=c.id and a.VNO ='$VNO' and DECL=0";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $DCR = $result[0]->id;
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
        }
        
        $RMT = 0;
        $sql = "select RHN,RMT,RCN,VNO from tbl137 where DCR=$DCR and RST=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $RMT = $RMT + $result[0]->RMT;
        }

        $TIM = date("Y-m-d H:i:s");
        if($rhvisibility == 0){
            $RHV = 1;
            $sql = "insert into sales_audit (ADT,DCR,RHN,RHV,SPF,CPF,TPF,TIM,USR) values ('$ADT','$DCR','$RHN','$RHV','$SPF','$CPF','$TPF','$TIM','$USR')";
            DB::insert($sql);            
        }else{
           $RHV = 0; 
           $CPF = round(Formulae::EXPS2($DCR),2);; 
           $sql = "insert into sales_audit (ADT,DCR,RHN,RHV,SPF,CPF,TPF,TIM,USR) values ('$ADT','$DCR','$RHN','$RHV','0','$CPF','0','$TIM','$USR')";
            DB::insert($sql);
        }
        $BAL = $CPF - $RMT;
        $msg="";
        if($BAL >= 0){
            $msg = "Hi ".$DNM.". Cash Declared is Incorrect. Further to our checks, the cash collected you have accounted for is incorrect. Please send remaining cash GHC ".$BAL." immediately else we shall be compelled to enforce the policy. The car owner has been notified of this issue accordingly. Click here to pay. http://fleetopsgh.com/balance/".$DCR;
        }else{
            $msg = "Hi ".$DNM.",Thank you for a successful sales declaration of GHC ".$RMT;
            $sql = "update tbl136 set DECL = 1,attempts=0,alarm_off=1,alarm_off_attempts=0 where id = '$DCR'";
            DB::update($sql);
        }
        $DAT = date("Y-m-d");
        $TIM = date("H:i:s");
        $CTX = "Sales Audit";
        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
        $values = [$RCN,$msg,$DAT,$TIM,$CTX,$DNM];
        DB::insert($sql,$values);
        SMSFleetops::send($RCN,$msg);
        return redirect('/workflow')->with('message', 'Driver Sales Audit Done Successfully')->withInput();

    }

    public function help()
    {
       return view('help'); 
    }

    public function rhresettesting($DCR){
        $sql = "delete from tbl137 where DCR=$DCR";
        DB::delete($sql);
        $sql = "delete from sales_audit where DCR=$DCR";
        DB::delete($sql);
        $sql = "update tbl136 set DECL=0,CRS=0,DNW=0 where id=$DCR";
        DB::update($sql);
        
        $from = date('Y-m-d', strtotime('-6 days'));
        $to = date('Y-m-d');
        $sql = "select a.*,b.DCN from tbl136 a,driver b where a.driver_id=b.id and a.VBM = 'Ride Hailing' and DDT >='$from' and DDT <='$to' order by DDT desc";
        $title = 'RH Daily Report';
        $rhreport = DB::select(DB::raw($sql));
        foreach($rhreport as $sale){
            $DCR = $sale->id;
            $VNO = $sale->VNO;
            $sql = "select * from tbl137 where DCR=$DCR and SSR='Driver' and RST=1";
            $tbl137 = DB::select(DB::raw($sql));
            if(count($tbl137) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = round(Formulae::CCEI2($DCR),2);
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }else{
                $sale->EXPS = "";
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }
        }
        return view('rhreport',compact('rhreport','title','from','to'));
    }

    public function resendsms($id){
        $sql = "select * from sms_log where id=$id";
        $sms = DB::select(DB::raw($sql));  
        if(count($sms) > 0){
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $PHN = $sms[0]->PHN;
            $MSG = $sms[0]->MSG;
            $CTX = $sms[0]->CTX;
            $NAM = $sms[0]->NAM;
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
            $values = [$PHN,$MSG,$DAT,$TIM,$CTX,$NAM];
            DB::insert($sql,$values);
            SMSFleetops::send($PHN,$MSG);
            $from = date('Y-m-d', strtotime('-6 days'));
            $to   = date('Y-m-d');
            return redirect("/notificationslog/$from/$to")->with('message', 'SMS Resend Successfully');

        }
    }
        
}

	
	
	

	