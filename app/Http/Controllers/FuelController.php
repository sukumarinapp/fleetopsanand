<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use app\SMSFleetops;
use Illuminate\Support\Facades\Hash;

class FuelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access(){
        if(Auth::user()->usertype == "Admin" || (Auth::user()->RBA4==1 && (Auth::user()->RBA4A==1 || Auth::user()->RBA4B==1 ))){
        }else{
            echo "Access Denied";
            die;
        }            
    }

    public function fuelsrch()
    {
        $this->check_access();        
        $sql = "SELECT a.* from vehicle a,driver b where a.driver_id=b.id and VTV=1 and b.VBM='Ride Hailing'";
        $vehicles = DB::select(DB::raw($sql));
        return view('fuelsrch',compact('vehicles'));
    }

    public function fueler($VNO)
    {
        $this->check_access(); 
        $id = $VNO;
        $sql = "SELECT d.PLF,e.RHN,a.*,b.name,c.DNO,c.DNM,c.DSN,c.DCN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $DCN = $vehicle->DCN;
        $msg = "Your fueling code is 1111";
        //SMSFleetops::send($DSN,$msg);
        return view('fueler',compact('vehicle'));
    }
        
}

	
	
	

	