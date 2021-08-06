<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class FuelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fuelsrch()
    {
        $sql = "SELECT a.* from vehicle a,driver b where a.driver_id=b.id and VTV=1 and b.VBM='Ride Hailing'";
        $vehicles = DB::select(DB::raw($sql));
        return view('fuelsrch',compact('vehicles'));
        
    }
        
}

	
	
	

	