<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use App\User;
use App\UAN;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\FleetopsMail;
use App\SMSFleetops;

class ManagerController extends Controller
{
    public function index()
    {
        $this->check_access("VIEW");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        $filter = "";
        $sql="select id,name,UZS from users where usertype in ('Admin','Manager')";
        $parent = DB::select(DB::raw($sql));
        if($usertype == "Admin"){
            $sql="select * from users where usertype='Manager'";
            $users = DB::select(DB::raw($sql));            
        }else if($usertype == "Manager"){
            $sql= "with recursive cte (id,name,UAN,UZS,email,UJT,UCN,UTV,usertype,parent_id) as (
              select     id,
                         name,
                         UAN,
                         UZS,
                         email,
                         UJT,
                         UCN,
                         UTV,
                         usertype,
                         parent_id
              from       users
              where      parent_id = $user_id and usertype='Manager' 
              union all
              select     p.id,
                         p.name,
                         p.UAN,
                         p.UZS,
                         p.email,
                         p.UJT,
                         p.UCN,
                         p.UTV,
                         p.usertype,
                         p.parent_id
              from       users p
              inner join cte
                      on p.parent_id = cte.id and p.usertype = 'Manager'
            )
            select * from cte";
            $users = DB::select(DB::raw($sql));
        }
        return view('manager.index', compact('users','parent'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPA" && Auth::user()->usertype != "Admin" && Auth::user()->BPA == false ){
            echo "Access Denied";
            die;
        }else if($mode == "BPD" && Auth::user()->usertype != "Admin" && Auth::user()->BPD == false){
            echo "Access Denied";
            die;
        // }else if($mode == "VIEW" && Auth::user()->usertype != "Admin" && Auth::user()->BPA == false  && Auth::user()->BPD == false){
        //     echo "Access Denied";
        //     die;
        }
    }
   
    public function create()
    {
        $this->check_access("BPA");
        $user_id = Auth::user()->id;
        $sql="select * from users where UTV=1 and parent_id in (0,1) order by UAN,name,UZS";
        $managers = DB::select(DB::raw($sql));
        return view('manager.create',compact('managers'));
    }
   
    public function store(Request $request)
    {
        $this->check_access("BPA");
        $email = trim($request->get('email'));
        $sms = ($request->get("sms") != null) ? 1 : 0;
        $sql = "SELECT * FROM users where email='$email'";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return redirect('/manager/create')->with('error', 'Email already used by another user');
        }else{
            $UTV = ($request->get("UTV") != null) ? 1 : 0;
            $BPA = ($request->get("BPA") != null) ? 1 : 0;
            $BPB = ($request->get("BPB") != null) ? 1 : 0;
            $BPC = ($request->get("BPC") != null) ? 1 : 0;
            $BPD = ($request->get("BPD") != null) ? 1 : 0;
            $BPE = ($request->get("BPE") != null) ? 1 : 0;
            $BPF = ($request->get("BPF") != null) ? 1 : 0;
            $BPG = ($request->get("BPG") != null) ? 1 : 0;
            $BPH = ($request->get("BPH") != null) ? 1 : 0;
            $BPI = ($request->get("BPI") != null) ? 1 : 0;
            $BPJ = ($request->get("BPJ") != null) ? 1 : 0;
            $BPJ1 = ($request->get("BPJ1") != null) ? 1 : 0;
            $BPJ2 = ($request->get("BPJ2") != null) ? 1 : 0;
            $BPK = ($request->get("BPK") != null) ? 1 : 0;
            $BPL = ($request->get("BPL") != null) ? 1 : 0;
            $insert = array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'usertype' => 'Manager',
                'parent_id' => $request->get('parent_id'),
                'UDT' => date("Y-m-d"),
                'UJT' => $request->get('UJT'),
                'UZS' => $request->get('UZS'),
                'UZA' => $request->get('UZA'),
                'UCN' => $request->get('UCN'),
                'UTV' => $UTV,
                'BPA' => $BPA,
                'BPB' => $BPB,
                'BPC' => $BPC,
                'BPD' => $BPD,
                'BPE' => $BPE,
                'BPF' => $BPF,
                'BPG' => $BPG,
                'BPH' => $BPH,
                'BPI' => $BPI,
                'BPJ' => $BPJ,
                'BPJ1' => $BPJ1,
                'BPJ2' => $BPJ2,
                'BPK' => $BPK,
                'BPL' => $BPL,
                'password' => Hash::make(trim($request->get('password'))),
                'remember_token' => Str::random(10),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
            $user = new User($insert);
            $user->save();
            $last_insert_id = $user->id;
            $uan = new UAN();
            $uan->save();
            $UAN =  "U".$uan->id;
            $user = User::find($last_insert_id);
            $user->UAN  =  $UAN;
            $user->save();

            if($UTV == 1 && $sms == 1){
                $name = trim($request->get('name')) . " " . trim($request->get('UZS'));
                $mobile = trim($request->get('UCN'));
                $password = trim($request->get('password'));
                Mail::to($email)->send(new FleetopsMail($name,"Manager",$email,$password));
                $message = "Dear $name, Your have been registered as a Manager with FleetOps. Your Username is $email and Password is $password";
                $DAT = date("Y-m-d");
                $TIM = date("H:i:s");
                $CTX = "Create Manager";
                $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$mobile','$message','$DAT','$TIM','$CTX','$name')";
                DB::insert($sql);
                SMSFleetops::send($mobile,$message);
            }
            
            $users = User::Where('usertype','Manager')->get();
            return redirect('/manager')->with('message', 'User Added Successfully');
        }
          
    }
   
    public function edit($id)
    {
        $this->check_access("BPD");
        $user = User::find($id);
        $parent_id = $user->parent_id;
        $sql="select * from users where UTV=1 and parent_id in (0,1) order by UAN,name,UZS";
        $managers = DB::select(DB::raw($sql));
        $sql2="select * from users where id = $parent_id ";
        $current_manager = DB::select(DB::raw($sql2));
        $current_manager = $current_manager[0];
        return view('manager.edit', compact('user','managers','current_manager'));
    }
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPD");
        $email = trim($request->get('email'));
        $sms = ($request->get("sms") != null) ? 1 : 0;
        $sql = "SELECT * FROM users where email='$email' and id <> $id";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return redirect("/manager/$id/edit")->with('error', 'Email already used by another user');
        }else{
            $UTV = ($request->get("UTV") != null) ? 1 : 0;
            $BPA = ($request->get("BPA") != null) ? 1 : 0;
            $BPB = ($request->get("BPB") != null) ? 1 : 0;
            $BPC = ($request->get("BPC") != null) ? 1 : 0;
            $BPD = ($request->get("BPD") != null) ? 1 : 0;
            $BPE = ($request->get("BPE") != null) ? 1 : 0;
            $BPF = ($request->get("BPF") != null) ? 1 : 0;
            $BPG = ($request->get("BPG") != null) ? 1 : 0;
            $BPH = ($request->get("BPH") != null) ? 1 : 0;
            $BPI = ($request->get("BPI") != null) ? 1 : 0;
            $BPJ = ($request->get("BPJ") != null) ? 1 : 0;
            $BPJ1 = ($request->get("BPJ1") != null) ? 1 : 0;
            $BPJ2 = ($request->get("BPJ2") != null) ? 1 : 0;
            $BPK = ($request->get("BPK") != null) ? 1 : 0;
            $BPL = ($request->get("BPL") != null) ? 1 : 0;
            $user = User::find($id);
            $user->name  =  $request->get('name');
            $user->parent_id  =  $request->get('parent_id');
            $user->email =  $request->get('email');
            $user->UJT   =  $request->get('UJT');
            $user->UZS   =  $request->get('UZS');
            $user->UZA   =  $request->get('UZA');
            $user->UCN   =  $request->get('UCN');
            $user->UTV   =  $UTV;            
            $user->BPA   =  $BPA;            
            $user->BPB   =  $BPB;            
            $user->BPC   =  $BPC;            
            $user->BPD   =  $BPD;            
            $user->BPE   =  $BPE;            
            $user->BPF   =  $BPF;            
            $user->BPG   =  $BPG;            
            $user->BPH   =  $BPH;            
            $user->BPI   =  $BPI;            
            $user->BPJ   =  $BPJ;            
            $user->BPJ1   =  $BPJ1;            
            $user->BPJ2   =  $BPJ2;
            $user->BPK   =  $BPK;
            $user->BPL   =  $BPL;
            $user->updated_at = date("Y-m-d H:i:s");
            $password = trim($request->get('password'));
            if($password != ""){
                $user->password = Hash::make($password);
            }
            $user->save();

            $name = trim($request->get('name')) . " " . trim($request->get('UZS'));
            $mobile = trim($request->get('UCN'));
            $password = trim($request->get('password'));
            if($UTV == 1 && $password != "" && $sms == 1){
                Mail::to($email)->send(new FleetopsMail($name,"Manager",$email,$password));
                $message = "Dear $name, Your Password with FleetOps is reset. Your Username is $email and Password is $password";
                $DAT = date("Y-m-d");
                $TIM = date("H:i:s");
                $CTX = "Update Manager";
                $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$mobile','$message','$DAT','$TIM','$CTX','$name')";
                DB::insert($sql);
                SMSFleetops::send($mobile,$message);
            }
            
            return redirect('/manager')->with('message', 'User Updated Successfully');
        }
    }
   
    public function destroy($id)
    {
        $this->check_access("BPD");
        $sql = "SELECT * FROM users where parent_id=$id";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/manager')->with('error', 'User cannot be deleted');
        }else{
            $user = User::find($id);
            $user->delete();
            return redirect('/manager')->with('message', 'User Deleted Successfully');
        }
    }

    public function checkEmail(Request $request){
        $email = trim($request->get('email'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM users where email='$email'";
        }else{
            $sql = "SELECT * FROM users where email='$email' and id <> $id";
        }
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }

    public function duplicateUserContact(Request $request){
        $UCN = trim($request->get('UCN'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM users where UCN='$UCN'";
        }else{
            $sql = "SELECT * FROM users where UCN='$UCN' and id <> $id";
        }
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }

    public function change_password(Request $request){
        return view('manager.change');
    }

    public function update_password(Request $request){
        $id = Auth::user()->id;
        $new_password = trim($request->get("new_password"));
        $confirm_password = trim($request->get("confirm_password"));
        if($new_password != $confirm_password){
            return redirect("/change_password")->with('error', 'Passwords does not match');
        }else{
            $user = User::find($id);
            $user->password = Hash::make($new_password);
            $user->save();
            return redirect('/change_password')->with('message', 'Password Changed Successfully');
        }
        
    }
}
