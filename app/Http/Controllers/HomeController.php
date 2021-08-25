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
        $parent_id = Auth::user()->id;
        $sql= "with recursive cte (id, name,UAN,usertype,parent_id) as (
          select     id,
                     name,
                     UAN,
                     usertype,
                     parent_id
          from       users
          where      parent_id = $parent_id
          union all
          select     p.id,
                     p.name,
                     p.UAN,
                     p.usertype,
                     p.parent_id
          from       users p
          inner join cte
                  on p.parent_id = cte.id
        )
        select * from cte";
        $users = DB::select(DB::raw($sql));
        //dd($result);
        return view('home',compact('users'));
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
