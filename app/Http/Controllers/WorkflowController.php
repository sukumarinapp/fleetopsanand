<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\SMSFleetops;
use Illuminate\Support\Facades\Hash;

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

    public function sales($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'General Sales Ledger';
        $sql="select a.VBM,b.*,c.DNM,c.DSN from tbl136 a,sales_rental b,driver c where a.id=b.DCR and a.driver_id=c.id and b.SDT >='$from' and b.SDT <='$to' order by b.SDT desc";
        $sales = DB::select(DB::raw($sql));
        return view('sales',compact('sales','title','from','to'));
    }

    public function collection($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Collection Report';
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

    public function override($VNO)
    {
        $this->check_access("BPJ2");
        $id = $VNO;
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
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
                $sql = "update tbl136 set DECL=1,attempts=0 where VNO='$VNO'";
                DB::update($sql);
                $sql = "insert into tbl024 (DCR,ODT,OTT,CAN,VNO,UAN,OAC) values ($DCR,'$ODT','$OTT','$CAN','$VNO','$UAN','$OAC')";
                DB::insert($sql);
                $WNB = "WFL" . str_pad($DCR,3,'0',STR_PAD_LEFT);
                $WTP = "Vehicle Unblocked";
                $sql = "insert into tbl140 (DCR,WST,WCI,UAN,CAN,VNO,WNB,WTP,WCD) values ($DCR,'$WST','$WCI','$UAN','$CAN','$VNO','$WNB','$WTP','$ODT')";
                DB::insert($sql);
                $sql = "SELECT * FROM vehicle where id=$VID";
                $vehicle = DB::select(DB::raw($sql));
                $VZC0 = $vehicle[0]->VZC0;
                $VBC0 = $vehicle[0]->VBC0; 
                $TSM = $vehicle[0]->TSM;
                if($DES == "A4"){
                    SMSFleetops::send($TSM,$VBC0);
                    return redirect('/workflow')->with('message', 'Vehicle Mobilized Successfully');
                }else{
                    SMSFleetops::send($TSM,$VZC0);
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

    public function auditing($VNO)
    {
        $this->check_access("BPJ1");
        $id = $VNO;
        $sql = "SELECT d.PLF,e.RHN,a.*,b.UAN,b.name,c.DNO,c.DNM,c.DSN,c.DCN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
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
        $RMT = $request->RMT;
        $RHN = $request->RHN;
        $ROI = "";
        $SSR = Auth::user()->UAN;
        $SDT = date('Y-m-d');
        $DCR = 0;
        $TSM = 0;
        $VZC0 = 0;
        $VBC0 = 0;
        $VBC1 = 0;
        $WST = 0;
        $WCI = "";
        $sql = "SELECT a.DDT,a.id,b.TSM,b.VZC0,b.VBC0,b.VBC1,c.DNM,c.DSN from tbl136 a,vehicle b,driver c where a.VNO=b.VNO and b.driver_id=c.id and a.VNO ='$VNO' and DECL=0";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $DCR = $result[0]->id;
            $TSM = $result[0]->TSM;
            $VZC0 = $result[0]->VZC0;
            $VBC0 = $result[0]->VBC0;
            $VBC1 = $result[0]->VBC1;
            $WST = $result[0]->DDT;
            $WCI = $result[0]->DNM . " " .$result[0]->DSN;
        }
        $WNB = "WFL" . str_pad($DCR,3,'0',STR_PAD_LEFT);
        if($rhvisibility == 0){
            $TIM = date("Y-m-d H:i:s");
            $sql = "insert into tbl137 (SDT,DCR,CAN,VNO,RCN,VBM,RHN,SPF,TPF,RMT,ROI,RST,SSR,RTN) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$VBM','$RHN','$SPF','$TPF','$RMT','$ROI','1','$SSR','$TIM')";
            DB::insert($sql);
            $sql = "update tbl136 set DECL=1,attempts=0 where VNO='$VNO'";
            DB::update($sql);
            $WTP = "Sale Audit Vehicle Unblocked";
            $sql = "insert into tbl140 (DCR,WST,WCI,UAN,CAN,VNO,WNB,WTP,WCD) values ($DCR,'$WST','$WCI','$UAN','$CAN','$VNO','$WNB','$WTP','$SDT')";
            DB::insert($sql);
            SMSFleetops::send($TSM,$VZC0);
            SMSFleetops::send($TSM,$VBC0);
            return redirect('/workflow')->with('message', 'Driver Sales Audit Done Successfully')->withInput();
        }else{
           $WTP = "Sale Audit Vehicle Blocked";
           $sql = "update tbl136 set DECL=0,DES='A4',attempts=0 where id='$DCR'";
           DB::update($sql);
           $sql = "insert into tbl140 (DCR,WST,WCI,UAN,CAN,VNO,WNB,WTP,WCD) values ($DCR,'$WST','$WCI','$UAN','$CAN','$VNO','$WNB','$WTP','$SDT')";
           DB::insert($sql);
           SMSFleetops::send($TSM,$VBC1); 
           return redirect('/workflow')->with('message', 'Driver Sales Audit Done and Vehicle blocked Successfully')->withInput();
        }
    }

    public function help()
    {
       return view('help'); 
    }
        
}

	
	
	

	