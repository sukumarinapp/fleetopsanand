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
        $sql = "select terminal_id,latitude,longitude from current_location where id in (select max(id) from current_location group by terminal_id)";
        $markers = DB::select(DB::raw($sql));
        return view('home',compact('markers'));
    }
}
