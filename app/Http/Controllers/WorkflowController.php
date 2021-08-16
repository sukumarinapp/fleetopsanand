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
        $sql = "select d.id as vid,a.*,b.DNM,b.DSN from tbl136 a,driver b,vehicle d where a.driver_id=b.id and a.VNO=d.VNO and a.DECL=0 and a.DDT = (select max(DDT) from tbl136 c where a.VNO=c.VNO and DECL=0 group by VNO);";
        $vehicles = DB::select(DB::raw($sql));
        return view('workflow',compact('vehicles'));
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
        $VNO = $request->VNO;
        $OAC = $request->OAC;
        $VID = $request->VID;
        $sql = "SELECT * FROM users where email='$email' and UTV=1";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            if (Hash::check($password, $users[0]->password)) {
                $UAN = $users[0]->UAN;
                $ODT = date("Y-m-d");
                $OTT = date("H.i");
                $sql = "insert into tbl024 (ODT,OTT,CAN,VNO,UAN,OAC) values ('$ODT','$OTT','$CAN','$VNO','$UAN','$OAC')";
                DB::insert($sql);
                $sql = "update tbl136 set DECL=1 where VNO='$VNO'";
                $vehicle = DB::select(DB::raw($sql));
                $sql = "SELECT * FROM vehicle where id=$VID";
                $vehicle = DB::select(DB::raw($sql));
                $VBC0 = $vehicle[0]->VBC0; 
                $TSM = $vehicle[0]->TSM;
                SMSFleetops::send($TSM,$VBC0);
                return redirect('/overrides/'.$VID)->with('message', 'Vehicle Mobilized Successfully')->withInput();
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
        $sql = "SELECT d.PLF,e.RHN,a.*,b.name,c.DNO,c.DNM,c.DSN,c.DCN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
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
        $RCN = $request->RCN;
        $SPF = $request->SPF;
        $TPF = $request->TPF;
        $RMT = $request->RMT;
        $RHN = $request->RHN;
        $ROI = "";
        $SSR = Auth::user()->UAN;
        $SDT = date('Y-m-d', strtotime("-1 days"));  
        $DCR = 0;
        $sql = "SELECT * from tbl135 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result)==0){
            $sql = "insert into tbl135 (DDT,CAN,VNO,CHR,CML) values ('$SDT','$CAN','$VNO','0','0')";
            DB::insert($sql);
        }
        $sql = "SELECT * from tbl136 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result)==0){
            $sql = "insert into tbl136 (DDT,CAN,VNO,DES,DECL) values ('$SDT','$CAN','$VNO','A0','0')";
            DB::insert($sql);
        }
        $sql = "SELECT * from tbl136 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        $DCR = $result[0]->id;

        $sql = "insert into tbl137 (SDT,DCR,CAN,VNO,RCN,VBM,RHN,SPF,TPF,RMT,ROI,RST,SSR,RTN) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$VBM','$RHN','$SPF','$TPF','$RMT','$ROI','1','$SSR','')";
        DB::insert($sql);
        return redirect('/auditing/'.$VID)->with('message', 'Driver Sales Audit Done Successfully')->withInput();
    }
        
}

	
	
	

	