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
        $sql = "SELECT a.*,b.DNM,b.DSN,b.VBM,c.name FROM vehicle a LEFT JOIN driver b ON a.driver_id = b.id LEFT JOIN users c ON a.CAN = c.UAN";
        $vehicles = DB::select(DB::raw($sql));
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
        return view('vehicle.edit', compact('vehicle','rhplatforms','clients'));
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
            $vehicle->VTV = $VTV;
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
        $vehicle->driver_id  =  $request->get('driver_id');
        $vehicle->save();
        return redirect('/vehicle')->with('message', 'Driver Assigned Successfully');
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

    public function removedriver(Request $request){
        $this->check_access("BPF");
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $vehicle->driver_id  =  null;
        $vehicle->save();
        return redirect('/vehicle')->with('message', 'Driver Removed Successfully');
    }

    public function remove($id){
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
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
