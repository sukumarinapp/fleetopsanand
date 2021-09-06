<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $usertree = array();
        $sql1 = "select id,UAN,name,UZS,parent_id,usertype from users where parent_id=1 and usertype='Manager' order by id";
        $managers = DB::select(DB::raw($sql1));
        $i=0;
        foreach($managers as $manager){
            $manager_id = $manager->id;
            $usertree[$i]['id'] = $manager_id;
            $usertree[$i]['name'] = $manager->name;
            $usertree[$i]['UZS'] = $manager->UZS;
            $usertree[$i]['parent_id'] = $manager->parent_id;
            $usertree[$i]['usertype'] = "manager";
            $usertree[$i]['UAN'] = $manager->UAN;
            $sql2 = "select id,UAN,name,UZS,parent_id,usertype from users where parent_id=$manager_id and usertype='Manager' order by id";
            $sub_managers = DB::select(DB::raw($sql2));
            $j=0;
            foreach($sub_managers as $sub_manager){
                $sub_manager_id = $sub_manager->id;
                $usertree[$i]['submanager'][$j]['id'] = $sub_manager_id;
                $usertree[$i]['submanager'][$j]['name'] = $sub_manager->name;
                $usertree[$i]['submanager'][$j]['UZS'] = $sub_manager->UZS;
                $usertree[$i]['submanager'][$j]['parent_id'] = $sub_manager->parent_id;
                $usertree[$i]['submanager'][$j]['usertype'] = "submanager";  
                $usertree[$i]['submanager'][$j]['UAN'] = $sub_manager->UAN;  
                $sql3 = "select id,UAN,name,UZS,parent_id,usertype from users where parent_id=$sub_manager_id and usertype='Client' order by id";
                $clients = DB::select(DB::raw($sql3));    
                $k=0;
                foreach($clients as $client){
                    $client_id = $client->id;
                    $CAN = $client->UAN;
                    $usertree[$i]['submanager'][$j]['client'][$k]['id'] = $client_id;
                    $usertree[$i]['submanager'][$j]['client'][$k]['name'] = $client->name;
                    $usertree[$i]['submanager'][$j]['client'][$k]['UZS'] = $client->UZS;
                    $usertree[$i]['submanager'][$j]['client'][$k]['parent_id'] = $client->parent_id;
                    $usertree[$i]['submanager'][$j]['client'][$k]['usertype'] = "client";
                    $usertree[$i]['submanager'][$j]['client'][$k]['UAN'] = $client->UAN;
                    $sql4 = "select a.id,a.driver_id,a.VNO,a.VTV,a.TID,b.DNM,b.DSN from vehicle a,driver b where a.driver_id=b.id and a.CAN='$CAN' and a.VTV=1";
                    $vehicles = DB::select(DB::raw($sql4));  
                    $c=0;
                    foreach($vehicles as $vehicle){
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['id'] = $vehicle->id;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['driver_id'] = $vehicle->driver_id;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['VNO'] = $vehicle->VNO;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['TID'] = $vehicle->TID;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['DNM'] = $vehicle->DNM;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['DSN'] = $vehicle->DSN;
                        $c++;
                    }
                    $k++;
                }
                $j++;
            }
            $i++;
        }
        //dd($usertree);
        /*$sql= "with recursive cte (id, name,UZS,UAN,usertype,parent_id) as (
          select     id,
                     name,
                     UZS,
                     UAN,
                     usertype,
                     parent_id
          from       users
          where      parent_id = $user_id
          union all
          select     p.id,
                     p.name,
                     p.UZS,
                     p.UAN,
                     p.usertype,
                     p.parent_id
          from       users p
          inner join cte
                  on p.parent_id = cte.id
        )
        select * from cte";
        $users = DB::select(DB::raw($sql));*/
        return view('home',compact('usertree'));
    }

    public function locations()
    {
        

        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        $UAN = Auth::user()->UAN;
        $filter = "";
        if($usertype == "Manager"){
            $sql="select UAN from users where parent_id=$user_id and usertype='Client'";
            $result = DB::select(DB::raw($sql));
            $i = 0;
            foreach($result as $row){
                if($i == 0) $filter = " AND CAN IN (";
                $filter = $filter . " '$row->UAN' ";
                $i++;
                if($i < count($result)) $filter = $filter . ",";
            }     
            $filter = $filter . ") ";
        }else if($usertype == "Client"){
            $filter = " AND CAN = '$UAN' ";
        }
        
        $sql = "select a.VNO,terminal_id,latitude,longitude,ground_speed,odometer,engine_on from vehicle a,current_location b where a.VTV=1 ".$filter." and a.TID=b.terminal_id and b.id in (select max(id) from current_location group by terminal_id)";
        $markers = DB::select(DB::raw($sql));
        return response()->json($markers);
    }
}
