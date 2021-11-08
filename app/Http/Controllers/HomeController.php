<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;

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

    public function usertree(){
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $type = "admin";
        
        if($parent_id == 0){
            $type = "admin";
        }else if($parent_id == 1){
            $type = "manager";
        }else if($parent_id > 1 && $usertype == "Manager"){
            $type = "submanager";
        }else if($parent_id > 1 && $usertype == "Client"){
            $type = "client";
        }
        $CAN = "";
        $name = Auth::user()->name;
        $usertree = array();
        if($type == "admin" || $type == "manager"){
            $sql1 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$user_id and usertype='Manager' and UTV=1 order by id";
            $managers = DB::select(DB::raw($sql1));
        }else if($type == "submanager"){
            $sql1 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$user_id and usertype='client' and UTV=1 order by id";
            $managers = DB::select(DB::raw($sql1));
        }else if($type == "client"){
            $sql1 = "select UAN from users where id=$user_id and usertype='Client' and UTV=1 order by id";
            $client = DB::select(DB::raw($sql1));
            $client = $client[0];
            $CAN = $client->UAN;
        }
        $i=0;
        if($type == "admin" || $type == "manager"){
            foreach($managers as $manager){
                $manager_id = $manager->id;
                $usertree[$i]['id'] = $manager_id;
                $usertree[$i]['email'] = $manager->email;
                $usertree[$i]['name'] = $manager->name;
                $usertree[$i]['UZS'] = $manager->UZS;
                $usertree[$i]['parent_id'] = $manager->parent_id;
                $usertree[$i]['usertype'] = "manager";
                $usertree[$i]['UAN'] = $manager->UAN;
                $usertree[$i]['level'] = 1;
                $sql3 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$manager_id and usertype='Client' order by id";
                $clients = DB::select(DB::raw($sql3));    
                $k=0;
                $usertree[$i]['client'] = array();
                foreach($clients as $client){
                    $client_id = $client->id;
                    $CAN = $client->UAN;
                    $parent_id = $client->parent_id;
                    $usertree[$i]['client'][$k]['id'] = $client_id;
                    $usertree[$i]['client'][$k]['name'] = $client->name;
                    $usertree[$i]['client'][$k]['email'] = $client->email;
                    $usertree[$i]['client'][$k]['UZS'] = $client->UZS;
                    $usertree[$i]['client'][$k]['parent_id'] = $client->parent_id;
                    $usertree[$i]['client'][$k]['usertype'] = "client";
                    $usertree[$i]['client'][$k]['level'] = 2;
                    $usertree[$i]['client'][$k]['UAN'] = $client->UAN;
                    $sql4 = "select a.id,a.driver_id,a.VNO,a.VTV,a.TID,b.DNM,b.DSN from vehicle a,driver b where a.driver_id=b.id and a.CAN='$CAN' and a.VTV=1";
                    $vehicles = DB::select(DB::raw($sql4));  
                    $c=0;
                    $usertree[$i]['client'][$k]['vehicle'] = array();
                    foreach($vehicles as $vehicle){
                        $usertree[$i]['client'][$k]['vehicle'][$c]['id'] = $vehicle->id;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['driver_id'] = $vehicle->driver_id;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['VNO'] = $vehicle->VNO;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['TID'] = $vehicle->TID;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['DNM'] = $vehicle->DNM;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['DSN'] = $vehicle->DSN;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['usertype'] = "vehicle";
                        $usertree[$i]['client'][$k]['vehicle'][$c]['level'] = 3;
                        $usertree[$i]['client'][$k]['vehicle'][$c]['parent_id'] = $parent_id;
                        $c++;
                    }
                    $k++;
                }
                $sql2 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$manager_id and usertype='Manager' order by id";
                $sub_managers = DB::select(DB::raw($sql2));
                $usertree[$i]['submanager'] = array();
                $j=0;
                foreach($sub_managers as $sub_manager){
                    $sub_manager_id = $sub_manager->id;
                    $usertree[$i]['submanager'][$j]['id'] = $sub_manager_id;
                    $usertree[$i]['submanager'][$j]['name'] = $sub_manager->name;
                    $usertree[$i]['submanager'][$j]['email'] = $sub_manager->email;
                    $usertree[$i]['submanager'][$j]['UZS'] = $sub_manager->UZS;
                    $usertree[$i]['submanager'][$j]['parent_id'] = $sub_manager->parent_id;
                    $usertree[$i]['submanager'][$j]['usertype'] = "submanager";  
                    $usertree[$i]['submanager'][$j]['level'] = 2;  
                    $usertree[$i]['submanager'][$j]['UAN'] = $sub_manager->UAN;  
                    $sql3 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$sub_manager_id and usertype='Client' order by id";
                    $clients = DB::select(DB::raw($sql3));    
                    $k=0;
                    $usertree[$i]['submanager'][$j]['client'] = array();
                    foreach($clients as $client){
                        $client_id = $client->id;
                        $CAN = $client->UAN;
                        $parent_id = $client->parent_id;
                        $usertree[$i]['submanager'][$j]['client'][$k]['id'] = $client_id;
                        $usertree[$i]['submanager'][$j]['client'][$k]['name'] = $client->name;
                        $usertree[$i]['submanager'][$j]['client'][$k]['email'] = $client->email;
                        $usertree[$i]['submanager'][$j]['client'][$k]['UZS'] = $client->UZS;
                        $usertree[$i]['submanager'][$j]['client'][$k]['parent_id'] = $client->parent_id;
                        $usertree[$i]['submanager'][$j]['client'][$k]['usertype'] = "client";
                        $usertree[$i]['submanager'][$j]['client'][$k]['level'] = 3;
                        $usertree[$i]['submanager'][$j]['client'][$k]['UAN'] = $client->UAN;
                        $sql4 = "select a.id,a.driver_id,a.VNO,a.VTV,a.TID,b.DNM,b.DSN from vehicle a,driver b where a.driver_id=b.id and a.CAN='$CAN' and a.VTV=1";
                        $vehicles = DB::select(DB::raw($sql4));  
                        $c=0;
                        $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'] = array();
                        foreach($vehicles as $vehicle){
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['id'] = $vehicle->id;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['driver_id'] = $vehicle->driver_id;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['VNO'] = $vehicle->VNO;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['TID'] = $vehicle->TID;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['DNM'] = $vehicle->DNM;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['DSN'] = $vehicle->DSN;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['usertype'] = "vehicle";
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['parent_id'] = $parent_id;
                            $usertree[$i]['submanager'][$j]['client'][$k]['vehicle'][$c]['level'] = 4;
                            $c++;
                        }
                        $k++;
                    }
                    $j++;
                }
                $i++;
            }
        }else if($type == "submanager"){
            $sql3 = "select email,id,UAN,name,UZS,parent_id,usertype from users where parent_id=$user_id and usertype='Client' order by id";
            $clients = DB::select(DB::raw($sql3));    
            $i=0;
            foreach($clients as $client){
                $client_id = $client->id;
                $CAN = $client->UAN;
                $parent_id = $client->parent_id;
                $usertree[$i]['id'] = $client_id;
                $usertree[$i]['name'] = $client->name;
                $usertree[$i]['email'] = $client->email;
                $usertree[$i]['UZS'] = $client->UZS;
                $usertree[$i]['parent_id'] = $client->parent_id;
                $usertree[$i]['usertype'] = "client";
                $usertree[$i]['level'] = 1;
                $usertree[$i]['UAN'] = $client->UAN;
                $sql4 = "select a.id,a.driver_id,a.VNO,a.VTV,a.TID,b.DNM,b.DSN from vehicle a,driver b where a.driver_id=b.id and a.CAN='$CAN' and a.VTV=1";
                $vehicles = DB::select(DB::raw($sql4));  
                $c=0;
                $usertree[$i]['vehicle'] = array();
                foreach($vehicles as $vehicle){
                    $usertree[$i]['vehicle'][$c]['id'] = $vehicle->id;
                    $usertree[$i]['vehicle'][$c]['driver_id'] = $vehicle->driver_id;
                    $usertree[$i]['vehicle'][$c]['VNO'] = $vehicle->VNO;
                    $usertree[$i]['vehicle'][$c]['TID'] = $vehicle->TID;
                    $usertree[$i]['vehicle'][$c]['DNM'] = $vehicle->DNM;
                    $usertree[$i]['vehicle'][$c]['DSN'] = $vehicle->DSN;
                    $usertree[$i]['vehicle'][$c]['usertype'] = "vehicle";
                    $usertree[$i]['vehicle'][$c]['level'] = 2;
                    $usertree[$i]['vehicle'][$c]['parent_id'] = $parent_id;
                    $c++;
                }
                $i++;
            }
        }else{
            $i=0;
            $sql = "select a.id,a.driver_id,a.VNO,a.VTV,a.TID,b.DNM,b.DSN from vehicle a,driver b where a.driver_id=b.id and a.CAN='$CAN' and a.VTV=1";
            $vehicles = DB::select(DB::raw($sql));  
            $i=0;
            foreach($vehicles as $vehicle){
                $usertree[$i]['id'] = $vehicle->id;
                $usertree[$i]['driver_id'] = $vehicle->driver_id;
                $usertree[$i]['VNO'] = $vehicle->VNO;
                $usertree[$i]['TID'] = $vehicle->TID;
                $usertree[$i]['DNM'] = $vehicle->DNM;
                $usertree[$i]['DSN'] = $vehicle->DSN;
                $usertree[$i]['usertype'] = "vehicle";
                $usertree[$i]['level'] = 1;
                $i++;
            }
        }
        return $usertree;
    }

    public function replay(){
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $type = "admin";
        
        if($parent_id == 0){
            $type = "admin";
        }else if($parent_id == 1){
            $type = "manager";
        }else if($parent_id > 1 && $usertype == "Manager"){
            $type = "submanager";
        }else if($parent_id > 1 && $usertype == "Client"){
            $type = "client";
        }
        $usertree = self::usertree();
        $VNO = "";
        $starttime = "";
        $endtime = ""; 
        //dd($usertree);
        $location = array();
        return view('replay',compact('location','usertree','type','VNO','starttime','endtime'));
    }

    public function track($VNO,$starttime,$endtime){
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $type = "admin";
        
        if($parent_id == 0){
            $type = "admin";
        }else if($parent_id == 1){
            $type = "manager";
        }else if($parent_id > 1 && $usertype == "Manager"){
            $type = "submanager";
        }else if($parent_id > 1 && $usertype == "Client"){
            $type = "client";
        }
        $usertree = self::usertree();
/*        $VNO = "GT4298-18";
        $starttime = "2021-07-28 23:59:58";
        $endtime = "2021-10-28 23:59:58"; */
        $sql = "select latitude,longitude,ground_speed,odometer,engine_on,capture_datetime from current_location a,vehicle b where a.terminal_id=b.TID and b.VNO='$VNO' and capture_datetime >= '$starttime' and capture_datetime <= '$endtime' order by a.id";
        $locationData = DB::select(DB::raw($sql));
        $location = array();
        $location["VNO"] = $VNO;
        $location["starttime"] = $starttime;
        $location["endtime"] = $endtime;
        $i=0;    
        $min_speed = 999999;
        $max_speed = 0;
        $odometer_start = 0;
        $odometer_end = 0;
        $total_seconds = 0;
        foreach($locationData as $loc){
            if($loc->ground_speed > $max_speed ) $max_speed = $loc->ground_speed; 
            if($loc->ground_speed != "0.00" && $loc->ground_speed < $min_speed ) $min_speed = $loc->ground_speed; 
            if($i == 0) $odometer_start = $loc->odometer;
            $location['loc'][$i][0] = $loc->latitude;
            $location['loc'][$i][1] = $loc->longitude;
            $odometer_end = $loc->odometer;
            $ground_speed = $loc->ground_speed;
            if($i>0 && $ground_speed <> 0 && $previous_ground_speed <> 0){
                $total_seconds = $total_seconds + strtotime($loc->capture_datetime) - strtotime($previous_time);
            }
            $previous_time = $loc->capture_datetime;
            $previous_ground_speed = $loc->ground_speed;
            $i++;
        }
        $hours_worked = round($total_seconds/3600,2);        
        $location["mileage"] = round($odometer_end - $odometer_start,2);
        $location["max_speed"] = $max_speed;
        $location["min_speed"] = $min_speed;
        $location["hours_worked"] = $hours_worked;
        echo json_encode($location);
        //return view('replay',compact('usertree','type','location','VNO','starttime','endtime'));
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $type = "admin";
        
        if($parent_id == 0){
            $type = "admin";
        }else if($parent_id == 1){
            $type = "manager";
        }else if($parent_id > 1 && $usertype == "Manager"){
            $type = "submanager";
        }else if($parent_id > 1 && $usertype == "Client"){
            $type = "client";
        }
        $usertree = self::usertree();
        $today = date("Y-m-d");
        $online = 0;
        $offline = 0;
        $inactive = 0;
        $new = 0;
        $total = 0;
        $sql = " select count(distinct terminal_id) as online from current_location where capture_date='$today'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $online = $result[0]->online;
        }
        $sql = " select count(VNO) as offline from vehicle where VTV=1 and driver_id <>'' and TID not in (select distinct terminal_id from current_location where capture_date='$today')";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $offline = $result[0]->offline;
        }
        $sql = "select count(VNO) as inactive from vehicle where VTV = 0 or driver_id is null";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $inactive = $result[0]->inactive;
        }
        $sql = " select count(VNO) as active from vehicle where VTV=1 and driver_id <> ''";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $active = $result[0]->active;
        }
        $sql = " select count(VNO) as total from vehicle";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $total = $result[0]->total;
        }
        $alerts = self::alerts();
        $starttime = "";
        $endtime = ""; 
        return view('home',compact('usertree','alerts','type','online','offline','inactive','active','total','starttime','endtime'));
    }

    private function get_filter($user_id,$parent_id,$usertype,$CAN){
        $filter = "";
        if($parent_id == 1){
            $sql="select UAN from users where parent_id=$user_id and usertype='Client'";
            $result = DB::select(DB::raw($sql));
            $filter = " AND CAN IN ('-1'";
            foreach($result as $row){
                $filter = $filter . ",'$row->UAN'";
            }     
            $filter = $filter . ") ";

            $sql="select UAN from users where parent_id=$user_id and usertype='Manager'";
            $result = DB::select(DB::raw($sql));
            foreach($result as $row){
                $filter = $filter . ",'$row->UAN'";
            }     
        }else if($parent_id > 1 && $usertype == "Manager"){
            $sql="select UAN from users where parent_id=$user_id and usertype='Client'";
            $result = DB::select(DB::raw($sql));
            $filter = " AND CAN IN ('-1'";
            foreach($result as $row){
                $filter = $filter . ",'$row->UAN'";
            }     
            $filter = $filter . ") ";
        }else if($parent_id > 1 && $usertype == "Client"){
            $filter = " and CAN='$CAN' ";
        }
        $filter = "";
        return $filter;
    }

    public function locations()
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $CAN = Auth::user()->UAN;
        $filter = self::get_filter($user_id,$parent_id,$usertype,$CAN);
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
        $filter = "";

        $today = date("Y-m-d");

        $sql = "select a.VNO,b.capture_date,b.capture_time,b.direction,terminal_id,latitude,longitude,ground_speed,odometer,engine_on from vehicle a,current_location b where a.VTV=1 ".$filter." and a.TID=b.terminal_id and b.id in (select max(id) from current_location where capture_date='$today' group by terminal_id)";

        //select * from alarm;
        $markers = DB::select(DB::raw($sql));
        ///dd($markers);
        return response()->json($markers);
    
    }

    private function minutes($time){
        $start_date = new DateTime($time);
        $since_start = $start_date->diff(new DateTime(date("Y-m-d H:i:s")));
        $minutes = $since_start->days * 24 * 60;
        $minutes += $since_start->h * 60;
        $minutes += $since_start->i;
        return $minutes;
    }

    public function alerts()
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $CAN = Auth::user()->UAN;
        $filter = self::get_filter($user_id,$parent_id,$usertype,$CAN);
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
        $filter = "";
        
        $msg1 = "Tracker Off";
        $msg2 = "Blocking On";
        $msg3 = "Alarm On";
        $msg4 = "Battery Off";
        $alerts = array();
        $current_date = date("Y-m-d");
        $current_time = date("H.i");

        $sql = "select concat(d.name,' ',d.UZS) as manager,c.name as client,a.id,b.VBM,a.VMK,a.VMD,a.VCL,a.VNO,a.driver_id,a.TID,concat(b.DNM,' ',b.DSN) as dname from vehicle a,driver b,users c,users d where c.parent_id=d.id and a.CAN=c.UAN and a.driver_id=b.id and a.VTV=1 and a.driver_id is not null";
        $result = DB::select(DB::raw($sql));
        $i = 0;
        foreach($result as $key => $res){
            $VNO = $res->VNO;
            $manager = $res->manager;
            $client = $res->client;
            $VMK = $res->VMK;
            $VMD = $res->VMD;
            $VCL = $res->VCL;
            $VBM = "";
            if($res->VBM=="Rental"){
                $VBM="RT";
            }elseif($res->VBM=="Hire Purchase"){
                $VBM="HP";
            }elseif($res->VBM=="Ride Hailing"){
                $VBM="RH";
            }

            $latitude = 0;
            $longitude = 0;

            $driver = $res->dname;
            $TID = $res->TID;
            $VID = $res->id;
            
            //if data not coming from tracker for 3 mins tracker is considered off
            $sql2 = "select id,capture_date,capture_time,latitude,longitude from current_location where terminal_id='$TID' and id =(select max(id) from current_location where terminal_id='$TID')";
            $tracker_off = DB::select(DB::raw($sql2));
            if(count($tracker_off) > 0){
                $id = $tracker_off[0]->id;
                $latitude = $tracker_off[0]->latitude;
                $longitude = $tracker_off[0]->longitude;
                $capture_date = $tracker_off[0]->capture_date;
                $capture_time = $tracker_off[0]->capture_time;
                $capture_time = substr($capture_time,0,2).".".substr($capture_time,2,2);
                $latitude = $tracker_off[0]->latitude;
                $longitude = $tracker_off[0]->longitude;
                if($capture_date < $current_date){
                    $alerts[$i]['cap_id'] = $id;
                    $alerts[$i]['VID'] = $VID;
                    $alerts[$i]['VNO'] = $VNO;
                    $alerts[$i]['manager'] = $VNO;
                    $alerts[$i]['manager'] = $manager;
                    $alerts[$i]['client'] = $client;
                    $alerts[$i]['VMK'] = $VMK;
                    $alerts[$i]['VMD'] = $VMD;
                    $alerts[$i]['VCL'] = $VCL;
                    $alerts[$i]['VBM'] = $VBM;
                    $alerts[$i]['driver'] = $driver;
                    $alerts[$i]['TID'] = $TID;
                    $alerts[$i]['type'] = "tracker";    
                    $alerts[$i]['alert'] = $msg1;    
                    $alerts[$i]['date'] = $capture_date;
                    $alerts[$i]['time'] = str_replace(".",":",$capture_time);
                    $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                    $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                    $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                    $alerts[$i]['latitude'] = $latitude;
                    $alerts[$i]['longitude'] = $longitude;
                    
                    $i++;
                }else{
                    if($current_time - $capture_time > .03){
                        $alerts[$i]['cap_id'] = $id;
                        $alerts[$i]['VID'] = $VID;
                        $alerts[$i]['VNO'] = $VNO;
                        $alerts[$i]['manager'] = $VNO;
                        $alerts[$i]['manager'] = $manager;
                        $alerts[$i]['client'] = $client;
                        $alerts[$i]['VMK'] = $VMK;
                        $alerts[$i]['VMD'] = $VMD;
                        $alerts[$i]['VCL'] = $VCL;
                        $alerts[$i]['VBM'] = $VBM;
                        $alerts[$i]['driver'] = $driver;
                        $alerts[$i]['TID'] = $TID;
                        $alerts[$i]['type'] = "tracker";    
                        $alerts[$i]['alert'] = $msg1;    
                        $alerts[$i]['date'] = $capture_date;
                        $alerts[$i]['time'] = str_replace(".",":",$capture_time);
                        $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                        $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                        $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                        $alerts[$i]['latitude'] = $latitude;
                        $alerts[$i]['longitude'] = $longitude;
                        $i++;
                    }
                }
            }

            //blocking on/off
            $sql3 = "select * from tbl136 where VNO='$VNO' and DES='A4' and DECL=0 and id=(select max(id) from tbl136 where VNO='$VNO');";
            $blocking = DB::select(DB::raw($sql3));
            if(count($blocking) > 0){
                //$alerts[$i]['cap_id'] = $id;
                $alerts[$i]['VID'] = $VID;
                $alerts[$i]['VNO'] = $VNO;
                $alerts[$i]['manager'] = $VNO;
                $alerts[$i]['manager'] = $manager;
                $alerts[$i]['client'] = $client;
                $alerts[$i]['VMK'] = $VMK;
                $alerts[$i]['VMD'] = $VMD;
                $alerts[$i]['VCL'] = $VCL;
                $alerts[$i]['VBM'] = $VBM;
                $alerts[$i]['driver'] = $driver;
                $alerts[$i]['TID'] = $TID;
                $alerts[$i]['type'] = "blocking";    
                $alerts[$i]['alert'] = $msg2;    
                $alerts[$i]['date'] = $blocking[0]->DDT;
                $alerts[$i]['time'] = "12:00";
                $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                $event_datetime = $blocking[0]->DDT." 12:00:00";
                $event_sql = "select latitude,longitude from current_location where id= (select max(id) from current_location where terminal_id='$TID' and capture_datetime <= '$event_datetime')";
                $event_loc = DB::select(DB::raw($event_sql));
                if(count($event_loc) > 0){
                    $latitude = $event_loc[0]->latitude;
                    $longitude = $event_loc[0]->longitude;
                }else{
                    $latitude = "";
                    $longitude = "";
                }
                $alerts[$i]['latitude'] = $latitude;
                $alerts[$i]['longitude'] = $longitude;

                $i++;
            }

            //buzzer on/off
            $sql3 = "select * from tbl136 where VNO='$VNO' and DES='A3' and alarm_off = 0 and DECL=0 and id=(select max(id) from tbl136 where VNO='$VNO');";
            $buzzer = DB::select(DB::raw($sql3));
            if(count($buzzer) > 0){
                //$alerts[$i]['cap_id'] = $id;
                $alerts[$i]['VID'] = $VID;
                $alerts[$i]['VNO'] = $VNO;
                $alerts[$i]['manager'] = $VNO;
                $alerts[$i]['manager'] = $manager;
                $alerts[$i]['client'] = $client;
                $alerts[$i]['VMK'] = $VMK;
                $alerts[$i]['VMD'] = $VMD;
                $alerts[$i]['VCL'] = $VCL;
                $alerts[$i]['VBM'] = $VBM;
                $alerts[$i]['driver'] = $driver;
                $alerts[$i]['TID'] = $TID;                
                $alerts[$i]['type'] = "buzzer";    
                $alerts[$i]['alert'] = $msg3;    
                $alerts[$i]['date'] = $buzzer[0]->DDT;
                $alerts[$i]['time'] = "10:00";
                $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                $alerts[$i]['latitude'] = $latitude;
                $alerts[$i]['longitude'] = $longitude;

                $event_datetime = $buzzer[0]->DDT." 10:00:00";
                $event_sql2 = "select latitude,longitude from current_location where id = (select max(id) from current_location where terminal_id='$TID' and capture_datetime <= '$event_datetime')";
                $event_loc2 = DB::select(DB::raw($event_sql2));
                if(count($event_loc2) > 0){
                    $latitude = $event_loc2[0]->latitude;
                    $longitude = $event_loc2[0]->longitude;
                }else{
                    $latitude = "";
                    $longitude = "";
                }

                $i++;
            }

            //battery on/off
            $sql4 = "select * from alarm where terminal_id='$TID' and id = (select max(id) from alarm where terminal_id='$TID' and command='9999')";
            $battery = DB::select(DB::raw($sql4));
            if(count($battery) > 0){
                $alert_time = $battery[0]->alert_time;
                $sql5 = "select * from current_location where terminal_id='$TID' and capture_datetime > '$alert_time' limit 1";
                $battery_on = DB::select(DB::raw($sql5));
                if(count($battery_on) == 0){
                    $alerts[$i]['VID'] = $VID;
                    $alerts[$i]['VNO'] = $VNO;
                    $alerts[$i]['manager'] = $VNO;
                    $alerts[$i]['manager'] = $manager;
                    $alerts[$i]['client'] = $client;
                    $alerts[$i]['VMK'] = $VMK;
                    $alerts[$i]['VMD'] = $VMD;
                    $alerts[$i]['VCL'] = $VCL;
                    $alerts[$i]['VBM'] = $VBM;
                    $alerts[$i]['driver'] = $driver;
                    $alerts[$i]['TID'] = $TID;     
                    $alerts[$i]['type'] = "battery";    
                    $alerts[$i]['alert'] = $msg4;    
                    $alerts[$i]['date'] = substr($alert_time,0,10);
                    $alerts[$i]['time'] = substr($alert_time,11,5);
                    $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                    $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                    $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                    $alerts[$i]['latitude'] = $latitude;
                    $alerts[$i]['longitude'] = $longitude;

                    $event_datetime = substr($alert_time,0,10)." ".substr($alert_time,11,5).":00";
                    $event_sql2 = "select latitude,longitude from current_location where id = (select max(id) from current_location where terminal_id='$TID' and capture_datetime <= '$event_datetime' )";
                    $event_loc2 = DB::select(DB::raw($event_sql2));
                    if(count($event_loc2) > 0){
                        $latitude = $event_loc2[0]->latitude;
                        $longitude = $event_loc2[0]->longitude;
                    }else{
                        $latitude = "";
                        $longitude = "";
                    }
                    $i++;
                }
            }
        }
        //dd($alerts);        
        return $alerts;
    }

    private function secondsToTime($inputSeconds) {
        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;

        // Extract days
        $days = floor($inputSeconds / $secondsInADay);

        // Extract hours
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        // Extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        // Extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        // Format and return
        $timeParts = [];
        $sections = [
            'day' => (int)$days,
            'hour' => (int)$hours,
            'minute' => (int)$minutes,
            'second' => (int)$seconds,
        ];

        foreach ($sections as $name => $value){
            if ($value > 0){
                $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
            }
        }

        return implode(', ', $timeParts);
    }

    public function alertlog($from,$to)
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $usertype = Auth::user()->usertype;
        $CAN = Auth::user()->UAN;
        $filter = self::get_filter($user_id,$parent_id,$usertype,$CAN);
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
        $filter = "";
        
        $msg1 = "Tracker Off";
        $msg2 = "Blocking On";
        $msg3 = "Alarm On";
        $msg4 = "Battery Off";
        $alerts = array();
        $current_date = date("Y-m-d");
        $current_time = date("H.i");

        $sql = "select concat(d.name,' ',d.UZS) as manager,c.name as client,a.id,b.VBM,a.VMK,a.VMD,a.VCL,a.VNO,a.driver_id,a.TID,concat(b.DNM,' ',b.DSN) as dname from vehicle a,driver b,users c,users d where c.parent_id=d.id and a.CAN=c.UAN and a.driver_id=b.id and a.VTV=1 and a.driver_id is not null";
        $result = DB::select(DB::raw($sql));
        $i = 0;
        foreach($result as $key => $res){
            $VNO = $res->VNO;
            $manager = $res->manager;
            $client = $res->client;
            $VMK = $res->VMK;
            $VMD = $res->VMD;
            $VCL = $res->VCL;
            $VBM = "";
            if($res->VBM=="Rental"){
                $VBM="RT";
            }elseif($res->VBM=="Hire Purchase"){
                $VBM="HP";
            }elseif($res->VBM=="Ride Hailing"){
                $VBM="RH";
            }

            $latitude = 0;
            $longitude = 0;

            $driver = $res->dname;
            $TID = $res->TID;
            $VID = $res->id;
        
            $msg1 = "Tracker Off";
            $msg2 = "Blocking On";
            $msg3 = "Alarm On";
            $msg4 = "Battery Off";
            $alerts = array();
            $current_date = date("Y-m-d");
            $current_time = date("H.i");
            //battery on/off
            $sql4 = "select * from alarm where terminal_id='$TID' and id = (select max(id) from alarm where terminal_id='$TID' and command='9999')";
            $battery = DB::select(DB::raw($sql4));
            if(count($battery) > 0){
                $alert_time = $battery[0]->alert_time;
                $sql5 = "select * from current_location where terminal_id='$TID' and capture_datetime > '$alert_time' order by capture_datetime limit 1";
                $battery_on = DB::select(DB::raw($sql5));
                if(count($battery_on) > 0){
                    //if($TID=='233500627989') echo $sql5;die;
                    $alerts[$i]['VID'] = $VID;
                    $alerts[$i]['VNO'] = $VNO;
                    $alerts[$i]['manager'] = $VNO;
                    $alerts[$i]['manager'] = $manager;
                    $alerts[$i]['client'] = $client;
                    $alerts[$i]['VMK'] = $VMK;
                    $alerts[$i]['VMD'] = $VMD;
                    $alerts[$i]['VCL'] = $VCL;
                    $alerts[$i]['VBM'] = $VBM;
                    $alerts[$i]['driver'] = $driver;
                    $alerts[$i]['TID'] = $TID;     
                    $alerts[$i]['type'] = "battery";    
                    $alerts[$i]['alert'] = $msg4;    
                    $alerts[$i]['date'] = substr($alert_time,0,10);
                    $alerts[$i]['time'] = substr($alert_time,11,5);
                    $alerts[$i]['hours'] = self::minutes($alerts[$i]['date']." ".$alerts[$i]['time'])/60;
                    $alerts[$i]['hours'] = $alerts[$i]['hours'] * 60 * 60;
                    $alerts[$i]['hours'] = self::secondsToTime($alerts[$i]['hours']);
                    $alerts[$i]['latitude'] = $latitude;
                    $alerts[$i]['longitude'] = $longitude;
                    $alerts[$i]['resolve_time'] = $battery_on[0]->capture_datetime;

                    $event_datetime = substr($alert_time,0,10)." ".substr($alert_time,11,5).":00";
                    $event_sql2 = "select latitude,longitude from current_location where id = (select max(id) from current_location where terminal_id='$TID' and capture_datetime <= '$event_datetime' )";
                    $event_loc2 = DB::select(DB::raw($event_sql2));
                    if(count($event_loc2) > 0){
                        $latitude = $event_loc2[0]->latitude;
                        $longitude = $event_loc2[0]->longitude;
                    }else{
                        $latitude = "";
                        $longitude = "";
                    }
                    $i++;
                }
            }
        }   
        //dd($alerts);        
        return view('alertlog',compact('alerts','title','from','to'));
    }
}
