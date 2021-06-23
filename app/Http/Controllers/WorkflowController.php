<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;

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

    public function workflow1(Request $request)
    {
        $this->check_access();
        $id = trim($request->get("VNO"));
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('workflow1',compact('vehicle'));
    }
    
    public function auditing1(Request $request)
    {
        return view('auditing1');
    }
        
}

	
	
	

	