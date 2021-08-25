<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  
use DB;
use App\rhplatform;
use App\Driver;
use App\DriverPlatform;
use Auth;


class FdriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPF" && Auth::user()->usertype != "Admin" && Auth::user()->BPF == false){
            echo "Access Denied";
            die;
        }
    }

   public function index()
   {
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.id as vid,b.VNO FROM driver a LEFT JOIN vehicle b ON a.id = b.driver_id";
        $drivers = DB::select(DB::raw($sql));
        return view('fdriver.index', compact('drivers'));
    }
   
    public function create()
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM tbl361 where id <> 1";
        $rhplatforms = DB::select(DB::raw($sql));
        return view('fdriver.create', compact('rhplatforms'));
    }
   
    public function store(Request $request)
    {
        
        $this->check_access("BPF");
        $DNO = trim($request->get('DNO'));
        $sql = "SELECT * FROM driver where DNO='$DNO'";
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return redirect('/fdriver/create')->with('error', 'Duplicate License Number');
        }else{
            $VPF = "";
            $WDY = 0;
            $MDY = 0;
            $VPD = "";
            $VAM = 0;
            if($request->get('VBM') != "Ride Hailing"){
               $VPF = $request->get('VPF');
               $WDY = $request->get('WDY');
               $MDY = $request->get('MDY');
               $VPD = $request->get('VPD'); 
               $VAM = $request->get('VAM'); 
            }
           

            $insert = array(
                'DNO' => $request->get('DNO'),
                'DNM' => $request->get('DNM'),
                'DSN' => $request->get('DSN'),
                'DCN' => $request->get('DCN'),
                'VBM' => $request->get('VBM'),
                'VPF' => $VPF,
                'WDY' => $WDY,
                'MDY' => $MDY,
                'VAM' => $VAM,
                'LEX' => $request->get('LEX'),
                'CEX' => $request->get('CEX'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
            if($VPD != "") $insert += array('VPD' => $VPD);
            $driver = new Driver($insert);
            $driver->save();
            $last_insert_id = $driver->id;

            $DLD = "";
            if($request->DLD != null){
                $DLD =  $last_insert_id.'.'.$request->DLD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            }
            $VCC = "";
            if($request->VCC != null){
                $VCC =  $last_insert_id.'.'.$request->VCC->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VCC'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VCC']['tmp_name'], $filepath.$VCC);
            }
            $driver = Driver::find($last_insert_id);
            $driver->DLD  =  $DLD;
            $driver->VCC  =  $VCC;
            $driver->save();

            $sql = "delete from driver_platform where driver_id=$last_insert_id";
            DB::delete(DB::raw($sql));
            
            $PLFS = $request->get('PLF');
            foreach($PLFS as $PLF){
                $driverplatform = new DriverPlatform();
                $driverplatform->driver_id = $last_insert_id;
                $driverplatform->PLF = $PLF;
                $driverplatform->save();
            }

            


            return redirect('/fdriver')->with('message', 'Driver added Successfully');
        }
    }
      
    public function edit($id)
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM tbl361 where id <> 1";
        $rhplatforms = DB::select(DB::raw($sql));
        $driver = Driver::find($id);
        $sql = "SELECT PLF FROM driver_platform where driver_id='$id'";
        $driver_platforms = DB::select(DB::raw($sql));
        return view('fdriver.edit', compact('driver','rhplatforms','driver_platforms'));
    }
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPF");
        $DNO = trim($request->get('DNO'));
        $sql = "SELECT * FROM driver where DNO='$DNO' and id <> $id";
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return redirect("/driver/$id/edit")->with('error', 'Duplicate License Number');
        }else{
            $DLD = "";
            if($request->DLD != null){
                $DLD =  $id.'.'.$request->DLD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            }
            
            $VCC = "";
            if($request->VCC != null){
                $VCC =  $id.'.'.$request->VCC->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VCC'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VCC']['tmp_name'], $filepath.$VCC);
            }
            $driver = Driver::find($id);
            $VPF = "";
            $WDY = 0;
            $MDY = 0;
            $VPD = NULL;
            $VAM = 0;
            if($request->get('VBM') != "Ride Hailing"){
               $VPF = $request->get('VPF');
               $WDY = $request->get('WDY');
               $MDY = $request->get('MDY');
               $VPD = $request->get('VPD'); 
               $VAM = $request->get('VAM'); 
            }
            $driver->DNO =  $request->get('DNO');
            $driver->DNM =  $request->get('DNM');
            $driver->DSN =  $request->get('DSN');
            $driver->DCN =  $request->get('DCN');
            if($DLD != "") $driver->DLD  =  $DLD;
            if($VCC != "") $driver->VCC  =  $VCC;
            if($request->get('VBM') != ""){
                $driver->VBM =  $request->get('VBM');
            }
            $driver->VPF =  $VPF;
            $driver->WDY =  $WDY;
            $driver->MDY =  $MDY;
            $driver->VPD =  $VPD;
            $driver->VAM =  $VAM;
            $driver->LEX =  $request->get('LEX');
            $driver->CEX =  $request->get('CEX');
            $driver->updated_at =  date("Y-m-d H:i:s");        
            $driver->save();

            $sql = "delete from driver_platform where driver_id=$id";
            DB::delete(DB::raw($sql));
            
            $PLFS = $request->get('PLF');
            foreach($PLFS as $PLF){
                $driverplatform = new DriverPlatform();
                $driverplatform->driver_id = $id;
                $driverplatform->PLF = $PLF;
                $driverplatform->save();
            }

            return redirect('/fdriver')->with('message', 'Driver Updated Successfully');
        }

    }
   
    public function destroy($id)
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM vehicle where driver_id=$id";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/fdriver')->with('error', 'Driver cannot be deleted');
        }else{
            $driver = Driver::find($id);
            $driver->delete();
            return redirect('/fdriver')->with('message', 'Driver Deleted Successfully');
        }
    }

    public function checkDNO(Request $request){
        $DNO = trim($request->get('DNO'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM driver where DNO='$DNO'";
        }else{
            $sql = "SELECT * FROM driver where DNO='$DNO' and id <> $id";
        }
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function checkDCN(Request $request){
        $DCN = trim($request->get('DCN'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM driver where DCN='$DCN'";
        }else{
            $sql = "SELECT * FROM driver where DCN='$DCN' and id <> $id";
        }
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }
}
