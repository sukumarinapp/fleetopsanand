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

    private function check_access(){
        
    }

    public function index()
    {
        $this->check_access();
        $sql = "SELECT * from vehicle where VTV=1 and driver_id is not null";
        $vehicles = DB::select(DB::raw($sql));
        return view('workflow',compact('vehicles'));
    }


    public function override($VNO)
    {
        $this->check_access();
        $id = $VNO;
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('override',compact('vehicle'));
    }

    public function saveoverride(Request $request)
    {
        $this->check_access();
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
                $sql = "SELECT * FROM vehicle where id=$VID";
                $vehicle = DB::select(DB::raw($sql));
                $VBC0 = $vehicle[0]->VBC0; 
                $TSM = $vehicle[0]->TSM;
                SMSFleetops::send($TSM,$VBC0);
                return redirect('/override/'.$VID)->with('message', 'Vehicle Immobilized/Blocked Overridden Successfully')->withInput();
            } else {
               return redirect('/override/'.$VID)->with('error', 'Invalid Username Credentials')->withInput();
            }
        }else{
            return redirect('/override/'.$VID)->with('error', 'Username does not exist or inactive')->withInput();
        }
    }
    
    public function auditsrch()
    {
        $this->check_access();
        $sql = "SELECT * from vehicle where VTV=1 and driver_id is not null";
        $vehicles = DB::select(DB::raw($sql));
        return view('auditsrch',compact('vehicles'));
        
    }

    public function auditing($VNO)
    {
        $this->check_access();
        $id = $VNO;
        $sql = "SELECT e.RHN,a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('auditing',compact('vehicle'));
    }
        
}

	
	
	

	