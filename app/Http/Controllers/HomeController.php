<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
        $sql = "select a.VNO,terminal_id,latitude,longitude,ground_speed,odometer from vehicle a,current_location b where a.TID=b.terminal_id and b.id in (select max(id) from current_location group by terminal_id)";
        $markers = DB::select(DB::raw($sql));
        return view('home',compact('markers'));
    }
}
