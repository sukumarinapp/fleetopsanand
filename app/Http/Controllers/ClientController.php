<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use App\User;
use App\CAN;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\FleetopsMail;
use App\SMSFleetops;

class ClientController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPB" && Auth::user()->usertype != "Admin" && Auth::user()->BPB == false){
            echo "Access Denied";
            die;
        }else if($mode == "BPE" && Auth::user()->usertype != "Admin" && Auth::user()->BPE == false){
            echo "Access Denied";
            die;
        }else if($mode == "VIEW" && Auth::user()->usertype != "Admin" && Auth::user()->BPB == false  && Auth::user()->BPE == false){
            echo "Access Denied";
            die;
        }
    }

    public function index()
    {
        $this->check_access("VIEW");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $users = User::Where('usertype','Client')->get();
        }else if($usertype == "Manager"){
            $sql= "with recursive cte (id,name,UAN,UZS,CZN,email,UCN,UTV,usertype,parent_id) as (
              select     id,
                         name,
                         UAN,
                         UZS,
                         CZN,
                         email,
                         UCN,
                         UTV,
                         usertype,
                         parent_id
              from       users
              where      parent_id = $user_id  
              union all
              select     p.id,
                         p.name,
                         p.UAN,
                         p.UZS,
                         p.CZN,
                         p.email,
                         p.UCN,
                         p.UTV,
                         p.usertype,
                         p.parent_id
              from       users p
              inner join cte
                      on p.parent_id = cte.id
            )
            select * from cte";
            $users = DB::select(DB::raw($sql));
        }
        return view('client.index', compact('users'));
    }
   
    public function create()
    {
        $this->check_access("BPB");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $sql="select * from users where UTV=1 and usertype='Manager' and BPE=1";
            $managers = DB::select(DB::raw($sql));
        }else if($usertype == "Manager"){
            $sql= "with recursive cte (id,name,UAN,UZS,email,UJT,UCN,UTV,usertype,BPE,parent_id) as (
              select     id,
                         name,
                         UAN,
                         UZS,
                         email,
                         UJT,
                         UCN,
                         UTV,
                         usertype,
                         BPE,
                         parent_id
              from       users
              where      parent_id = $user_id and UTV=1 AND BPE=1 and usertype='Manager' 
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
                         p.BPE,
                         p.parent_id
              from       users p
              inner join cte
                      on p.parent_id = cte.id and p.BPE=1
            )
            select * from cte";
            $managers = DB::select(DB::raw($sql));
        }
        return view('client.create', compact('managers'));
    }
   
    public function store(Request $request)
    {
        $this->check_access("BPB");
        $email = trim($request->get('email'));
        $sms = ($request->get("sms") != null) ? 1 : 0;
        $sql = "SELECT * FROM users where email='$email'";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return redirect('/client/create')->with('error', 'Email already used by another user');
        }else{
            $UTV = ($request->get("UTV") != null) ? 1 : 0;
            $RBA = ($request->get("RBA") != null) ? 1 : 0;
            $RBA1 = ($request->get("RBA1") != null) ? 1 : 0;
            $RBA2 = ($request->get("RBA2") != null) ? 1 : 0;
            $RBA3 = ($request->get("RBA3") != null) ? 1 : 0;
            $RBA4 = ($request->get("RBA4") != null) ? 1 : 0;
            $RBA4A = "";
            if($request->get("RBA4") != null){
                $RBA4A = $request->get("RBA4A");
            }
            $RBB = ($request->get("RBB") != null) ? 1 : 0;
            $BPJ = ($request->get("BPJ") != null) ? 1 : 0;
            $BPJ1 = ($request->get("BPJ1") != null) ? 1 : 0;
            $BPJ2 = ($request->get("BPJ2") != null) ? 1 : 0;
            $insert = array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'usertype' => 'Client',
                'parent_id' => $request->get('parent_id'),
                'UDT' => date("Y-m-d"),
                'CZN' => $request->get('CZN'),
                'CMT' => $request->get('CMT'),
                'UZA' => $request->get('UZA'),
                'UCN' => $request->get('UCN'),
                'CMA' => $request->get('CMA'),
                'CMN' => $request->get('CMN'), 
                'CMB' => $request->get('CMB'), 
                'CBK' => $request->get('CBK'), 
                'UTV' => $UTV,
                'RBA' => $RBA,
                'RBA1' => $RBA1,
                'RBA2' => $RBA2,
                'RBA3' => $RBA3,
                'RBA4' => $RBA4,
                'RBA4A' => $RBA4A,
                'RBB' => $RBB,
                'BPJ' => $BPJ,
                'BPJ1' => $BPJ1,
                'BPJ2' => $BPJ2,
                'password' => Hash::make($request->get('password')),
                'remember_token' => Str::random(10),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
            $user = new User($insert);
            $user->save();
            $last_insert_id = $user->id;
            $can = new CAN();
            $can->save();
            $CAN =  "C".$can->id;;
            $user = User::find($last_insert_id);
            $user->UAN  =  $CAN;
            $user->save();

            $password = trim($request->get('password'));
            $name = trim($request->get('CZN'));
            $mobile = trim($request->get('UCN'));  
            if($UTV == 1 && $sms == 1){
                Mail::to($email)->send(new FleetopsMail($name,"Client",$email,$password));
                $message = "Dear $name, Your have been registered as a Client with FleetOps. Your Username is $email and Password is $password";
                SMSFleetops::send($mobile,$message);
            }
            
            $users = User::Where('usertype','Client')->get();
            return redirect('/client')->with('message', 'Client Added Successfully');
        }
    }
   
    public function edit($id)
    {
        $this->check_access("BPE");
        $user = User::find($id);
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $sql="select * from users where UTV=1 and usertype='Manager'";
            $managers = DB::select(DB::raw($sql));
        }else if($usertype == "Manager"){
            $sql= "with recursive cte (id,name,UAN,UZS,email,UJT,UCN,UTV,usertype,BPE,parent_id) as (
              select     id,
                         name,
                         UAN,
                         UZS,
                         email,
                         UJT,
                         UCN,
                         UTV,
                         usertype,
                         BPE,
                         parent_id
              from       users
              where      parent_id = $user_id and UTV=1 AND BPE=1 and usertype='Manager' 
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
                         p.BPE,
                         p.parent_id
              from       users p
              inner join cte
                      on p.parent_id = cte.id and p.BPE=1
            )
            select * from cte";
            $managers = DB::select(DB::raw($sql));
        }
        return view('client.edit', compact('user','managers'));
    }
    
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPE");
        $email = trim($request->get('email'));
        $sql = "SELECT * FROM users where email='$email' and id <> $id";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            return redirect("/client/$id/edit")->with('error', 'Email already used by another Client');
        }else{
            $UTV = ($request->get("UTV") != null) ? 1 : 0;
            $RBA = ($request->get("RBA") != null) ? 1 : 0;
            $RBA1 = ($request->get("RBA1") != null) ? 1 : 0;
            $RBA2 = ($request->get("RBA2") != null) ? 1 : 0;
            $RBA3 = ($request->get("RBA3") != null) ? 1 : 0;
            $RBA4 = ($request->get("RBA4") != null) ? 1 : 0;
            $RBA4A = "";
            if($request->get("RBA4") != null){
                $RBA4A = $request->get("RBA4A");
            }
            $RBB = ($request->get("RBB") != null) ? 1 : 0;
            $BPJ = ($request->get("BPJ") != null) ? 1 : 0;
            $BPJ1 = ($request->get("BPJ1") != null) ? 1 : 0;
            $BPJ2 = ($request->get("BPJ2") != null) ? 1 : 0;
            $user = User::find($id);
            $user->name  =  $request->get('name');
            $user->parent_id  =  $request->get('parent_id');
            $user->CZN  =  $request->get('CZN');
            $user->CMT  =  $request->get('CMT');
            $user->UZA  =  $request->get('UZA');            
            $user->CMA =  $request->get('CMA');
            $user->UCN =  $request->get('UCN');
            $user->CMN =  $request->get('CMN');
            $user->email =  $request->get('email');
            $user->CMB =  $request->get('CMB');
            $user->CBK =  $request->get('CBK');
            $user->UTV   =  $UTV;            
            $user->RBA   =  $RBA;            
            $user->RBA1   =  $RBA1;            
            $user->RBA2   =  $RBA2;            
            $user->RBA3   =  $RBA3;            
            $user->RBA4   =  $RBA4;            
            $user->RBA4A   =  $RBA4A;            
            $user->RBB   =  $RBB;            
            $user->BPJ   =  $BPJ;            
            $user->BPJ1   =  $BPJ1;            
            $user->BPJ2   =  $BPJ2;
            $user->updated_at = date("Y-m-d H:i:s");
            $password = trim($request->get('password'));
            if($password != ""){
                $user->password = Hash::make($password);
            }
            $user->save();
            
            $sms = ($request->get("sms") != null) ? 1 : 0;

            $password = trim($request->get('password'));
            $name = trim($request->get('CZN'));
            $mobile = trim($request->get('UCN'));  
            if($password != "" && $UTV == 1 && $sms == 1){
                Mail::to($email)->send(new FleetopsMail($name,"Client",$email,$password));
                $message = "Dear $name, Your Password with FleetOps is reset. Your Username is $email and New Password is $password";
                SMSFleetops::send($mobile,$message);
            }

            return redirect('/client')->with('message', 'Client Updated Successfully');
        }
    }
   
    public function destroy($id)
    {
        $this->check_access("BPE");
        $sql = "SELECT * FROM users a,vehicle b where a.UAN = b.CAN and a.id=$id";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/client')->with('error', 'Client cannot be deleted');
        }else{
        $this->check_access("BPE");
        $user = User::find($id);
        $user->delete();
        return redirect('/client')->with('message', 'Client Deleted Successfully');
             }
    }
}
 