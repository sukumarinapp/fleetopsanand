<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  
use DB;
use App\rhplatform;
use App\Vehicle;
use App\User;
use Auth;
use App\Formulae;
use App\SMSFleetops;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPC" && Auth::user()->usertype != "Admin" && Auth::user()->BPC == false){
            echo "Access Denied";
            die;
        }else if($mode == "BPF" && Auth::user()->usertype != "Admin" && Auth::user()->BPF == false){
            echo "Access Denied";
            die;
        }
    }

    public function index()
    {
        $this->check_access("BPC");
        $today = date("Y-m-d");
        $sql = "SELECT a.*,b.id as did,b.DNM,b.DSN,b.VBM,c.name FROM vehicle a LEFT JOIN driver b ON a.driver_id = b.id INNER JOIN users c ON a.CAN = c.UAN";
        $vehicles = DB::select(DB::raw($sql));
        
        foreach($vehicles as $vehicle){
            $TID = $vehicle->TID;
            $VNO = $vehicle->VNO;
            $sql3 = "SELECT * from tracker_status where TID='$TID' and status=0";
            $offline = DB::select(DB::raw($sql3));
            if(count($offline) > 0){
                $vehicle->offline  = 1;
            }else{
                $vehicle->offline  = 0;
            }
            $sql4 = "select VNO from tbl136 where DECL=0 and VNO='$VNO'";
            $DECL = DB::select(DB::raw($sql4));
            if(count($DECL) > 0){
                $vehicle->DECL  = 0;
            }else{
                $vehicle->DECL  = 1;
            }
        }
        //dd($vehicles);
        return view('vehicle.index', compact('vehicles'));
    }
   
    public function create()
    {
        $this->check_access("BPC");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $clients = User::Where('usertype','Client')->get();
        }else if($usertype == "Manager"){
            $clients = User::Where('usertype','Client')->Where('parent_id',$user_id)->get();
        }
        $rhplatforms = rhplatform::all();
        return view('vehicle.create', compact('rhplatforms','clients'));
    }
   
    public function store(Request $request)
    {
        $this->check_access("BPC");
        $VNO = trim($request->get('VNO'));
        $VNO = str_replace(' ', '', $VNO);
        $sql = "SELECT * FROM vehicle where VNO='$VNO'";
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return redirect('/vehicle/create')->with('error', 'Duplicate Vehicle Reg No');
        }else{
            $VTV = ($request->get("VTV") != null) ? 1 : 0;
            $ECY = trim($request->get('ECY'));
            $CON = Formulae::CON($VNO);
            $insert = array(
                'CAN' => $request->get('CAN'),
                'VNO' => $request->get('VNO'),
                'VDT' => date("Y-m-d"),
                'VMK' => $request->get('VMK'),
                'VMD' => $request->get('VMD'),
                'VCL' => $request->get('VCL'),
                'ECY' => $ECY,
                'CON' => $CON,
                'VFT' => $request->get('VFT'),
                'VFC' => $request->get('VFC'),
                'TSN' => $request->get('TSN'),
                'TID' => $request->get('TID'),
                'TSM' => $request->get('TSM'),
                'TIP' => $request->get('TIP'),
                'VZC1' => $request->get('VZC1'),
                'VZC0' => $request->get('VZC0'),
                'VBC1' => $request->get('VBC1'),
                'VBC0' => $request->get('VBC0'),
                'VTV' => $VTV,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );

            $vehicle = new Vehicle($insert);
            $vehicle->save();

            $last_insert_id = $vehicle->id;

            $VID = "";
            if($request->VID != null){
                $VID =  $last_insert_id.'.'.$request->VID->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VID'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            }

            $VRD = "";
            if($request->VRD != null){
                $VRD =  $last_insert_id.'.'.$request->VRD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VRD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            }

            $vehicle = Vehicle::find($last_insert_id);
            $vehicle->VID  =  $VID;
            $vehicle->VRD  =  $VRD;
            $vehicle->save();
            return redirect('/vehicle')->with('message', 'Vehicle added Successfully');
        }
    }
      
    public function edit($id)
    {
        $this->check_access("BPC");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $clients = User::Where('usertype','Client')->get();
        }else if($usertype == "Manager"){
            $clients = User::Where('usertype','Client')->Where('parent_id',$user_id)->get();
        }
        $rhplatforms = rhplatform::all();
        $vehicle = Vehicle::find($id);
        $TID = $vehicle->TID;
        $today = date("Y-m-d");
        $sql3 = " select distinct terminal_id from current_location where capture_date='$today' and terminal_id='$TID'";
        $tracker = DB::select(DB::raw($sql3));
        $online = 0;
        if(count($tracker) > 0){
            $online = 1;
        }
        return view('vehicle.edit', compact('vehicle','rhplatforms','clients','online'));
    }
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPC");
        $VNO = trim($request->get('VNO'));
        $VNO = str_replace(' ', '', $VNO);
        $sql = "SELECT * FROM vehicle where VNO='$VNO'  and id <> $id";
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return redirect("/vehicle/$id/edit")->with('error', 'Duplicate Vehicle Reg No');
        }else{
            $VTV = ($request->get("VTV") != null) ? 1 : 0;
            $VID = "";
            if($request->VID != null){
                $VID =  $id.'.'.$request->VID->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VID'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            }
          

            $VRD = "";
            if($request->VRD != null){
                $VRD =  $id.'.'.$request->VRD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VRD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            }

            $ECY = trim($request->get('ECY'));
            $vehicle = Vehicle::find($id);            
            $vehicle->VNO  =  $request->get('VNO');
            $CON = Formulae::CON($vehicle->VNO);
            $vehicle->CAN  =  $request->get('CAN');
            if($VID != "") $vehicle->VID  =  $VID;
            if($VRD != "") $vehicle->VRD  =  $VRD;
            $vehicle->VMK  =  $request->get('VMK');
            $vehicle->VMD  =  $request->get('VMD');            
            $vehicle->VCL =  $request->get('VCL');
            $vehicle->ECY = $ECY;
            $vehicle->CON =  $CON;
            $vehicle->VFT =  $request->get('VFT');
            $vehicle->VFC =  $request->get('VFC');
            $vehicle->TSN =  $request->get('TSN');
            $vehicle->TID =  $request->get('TID');
            $vehicle->TSM =  $request->get('TSM');
            $vehicle->TIP =  $request->get('TIP');
            $vehicle->VZC1 =  $request->get('VZC1');
            $vehicle->VZC0 =  $request->get('VZC0');
            $vehicle->VBC1 =  $request->get('VBC1');
            $vehicle->VBC0 =  $request->get('VBC0');
            if($vehicle->driver_id == ""){
                $vehicle->VTV = $VTV;
            }
            $vehicle->updated_at =  date("Y-m-d H:i:s");        
            $vehicle->save();
            return redirect('/vehicle')->with('message', 'Vehicle Updated Successfully');
        }

    } 
   
    public function destroy($id)
    {
        $this->check_access("BPC");
        $sql = "SELECT * FROM vehicle where id=$id and driver_id is not null";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/vehicle')->with('error', 'Vehicle cannot be deleted');
        }else{
            $this->check_access("BPC");
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
            return redirect('/vehicle')->with('message', 'Vehicle Deleted Successfully');
        }
    }

    public function assigndriver(Request $request){
        $this->check_access("BPF");
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $DID = $request->get('driver_id');
        $VID = $vehicle->id;
        $vehicle->driver_id = $DID;
        $vehicle->save();
        $CAN = $vehicle->CAN;
        $VNO = $vehicle->VNO;
        $UAN = Auth::user()->name;
        $TIM = date("Y-m-d H:i");
        $LDT = date("Y-m-d");
        $sql = "insert into vehicle_log (LDT,CAN,VNO,DID,UAN,TIM,ATN) values ('$LDT','$CAN','$VNO','$DID','$UAN','$TIM','Assign Vehicle')";
        DB::insert($sql);
        self::send_sms($VID);
        return redirect('/vehicle')->with('message', 'Driver Assigned Successfully');
    }

    public function resendsms($VID){
        self::send_sms($VID);
        return redirect('/fdriver')->with('message', 'SMS Sent Successfully');
    }

    public function assign($id){
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.name FROM vehicle a,users b where a.CAN=b.UAN and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $sql = "SELECT id,DNO,DNM,DSN,DNO,DCN FROM driver where id not in (select driver_id from vehicle where driver_id<>'')";
        $drivers = DB::select(DB::raw($sql));
        return view('vehicle.assign', compact('vehicle','drivers'));
    }

    private function send_sms($VID){
        $sql = "select b.DCN,b.DNM,b.VBM,b.VAM,b.VPF,b.WDY,b.MDY,b.VPD,c.name,c.UCN from vehicle a,driver b,users c where a.driver_id=b.id and a.CAN=c.UAN and a.id=$VID";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $VBM = $vehicle->VBM;
        $DNM = $vehicle->DNM;
        $VAM = $vehicle->VAM;
        $VPF = $vehicle->VPF;
        $WDY = $vehicle->WDY;
        $MDY = $vehicle->MDY;
        $VPD = $vehicle->VPD;
        $name = $vehicle->name;
        $UCN = $vehicle->UCN;
        $DCN = $vehicle->DCN;
        $SMS = "";
        $SMS = "Dear ".$DNM.",\n";
        $SMS = $SMS ."You have been setup successfully on FOVCollector(v2.1) by FleetOps as follows:\n";
        if($VBM == "Ride Hailing"){
            $SMS = $SMS ."Independent Contractor on Ride Hailing\n";    
            $SMS = $SMS ."Declare sales daily by 10:00am\n";
        }else if($VBM == "Rental"){
            $SMS = $SMS ."Vehicle Rental Customer\n";    
            $SMS = $SMS ."Rental Fee: ".$VAM."\n";    
            $SMS = $SMS ."Payment Freq: ".$VPF."\n";    
            if($VPF == "Weekly"){
                $SMS = $SMS ."Payment Day: ".$WDY."\n";    
            }else if($VPF == "Monthly"){
                $SMS = $SMS ."Payment Day: ".$MDY."\n";    
            }
            $SMS = $SMS ."First Payment: ".$VPD."\n";    
        }else if($VBM == "Hire Purchase"){
            $SMS = $SMS ."Hire Purchase Customer\n";    
            $SMS = $SMS ."Instalment: ".$VAM."\n";    
            $SMS = $SMS ."Payment Freq: ".$VPF."\n";    
            if($VPF == "Weekly"){
                $SMS = $SMS ."Payment Day: ".$WDY."\n";    
            }else if($VPF == "Monthly"){
                $SMS = $SMS ."Payment Day: ".$MDY."\n";    
            }
            $SMS = $SMS ."First Payment: ".$VPD."\n";    
        }
        $SMS = $SMS ."Please make prompt payments to avoid any inconveniences. For further details you may contact ".$name." on ".$UCN."\n";
        $SMS = $SMS ."Thank you.\n";
        $DAT = date("Y-m-d");
        $TIM = date("H:i:s");
        $CTX = "Driver";
        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$SMS','$DAT','$TIM','$CTX','$DNM')";
        DB::insert($sql);
        SMSFleetops::send($DCN,$SMS);
    }

    public function removedriver(Request $request){
        $this->check_access("BPF");
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $DID = $vehicle->driver_id;
        $vehicle->driver_id  =  null;
        $vehicle->save();
        $CAN = $vehicle->CAN;
        $VNO = $vehicle->VNO;
        $UAN = Auth::user()->name;
        $TIM = date("Y-m-d H:i");
        $LDT = date("Y-m-d");
        $sql = "insert into vehicle_log (LDT,CAN,VNO,DID,UAN,TIM,ATN) values ('$LDT','$CAN','$VNO','$DID','$UAN','$TIM','Unassign Vehicle')";
        DB::insert($sql);
        return redirect('/vehicle')->with('message', 'Driver Removed Successfully');
    }

    public function remove($id){
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.name,c.DCN,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('vehicle.remove', compact('vehicle'));
    }

    public function checkVNO(Request $request){
        $VNO = trim($request->get('VNO'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where VNO='$VNO'";
        }else{
            $sql = "SELECT * FROM vehicle where VNO='$VNO' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_device_sn(Request $request){
        $TSN = trim($request->get('TSN'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TSN='$TSN'";
        }else{
            $sql = "SELECT * FROM vehicle where TSN='$TSN' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_id(Request $request){
        $TID = trim($request->get('TID'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TID='$TID'";
        }else{
            $sql = "SELECT * FROM vehicle where TID='$TID' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_sim_no(Request $request){
        $TSM = trim($request->get('TSM'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TSM='$TSM'";
        }else{
            $sql = "SELECT * FROM vehicle where TSM='$TSM' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }
}
