<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\rhplatform;
use Auth;
use DB;

class RHPlatformController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access(){
        if(Auth::user()->usertype != "Admin" && Auth::user()->BPI == false){
            echo "<h1>Access Denied</h1>";
            die;
        }
    }

    public function index()
    {
        $this->check_access();
        $rhplatforms = rhplatform::all();
        return view('rhplatform.index', compact('rhplatforms'));        
    }

    public function create()
    {
        $this->check_access();
        return view('rhplatform.create');
    }

    public function store(Request $request)
    {
        $this->check_access();
        $rhplatform = new rhplatform([
            'RHN' => $request->get('RHN'),
            'RMN' => $request->get('RMN'),
            'RMS' => $request->get('RMS'),
            'RML' => $request->get('RML'),
            'RHF' => $request->get('RHF'),
            'RHT' => $request->get('RHT'),
            'status' => $request->get('status'),
            'can_delete' => "1"
        ]);
        $rhplatform->save();
        return redirect('/rhplatform')->with('message', 'RH Platform Settings added Successfully');
    }

    public function edit($id)
    {
        $this->check_access();
        $rhplatform = rhplatform::find($id);
        return view('rhplatform.edit', compact('rhplatform'));
    }

    public function update(Request $request, $id)
    {
        $this->check_access();
        $rhplatform = rhplatform::find("$id");
        $rhplatform->RHN = $request->get('RHN');
        $rhplatform->RMN = $request->get('RMN');
        $rhplatform->RMS = $request->get('RMS');
        $rhplatform->RML = $request->get('RML');
        $rhplatform->RHF = $request->get('RHF');
        $rhplatform->RHT = $request->get('RHT');
        $rhplatform->status = $request->get('status');
        $rhplatform->save();
        return redirect('/rhplatform')->with('message', 'RH Platform Updated Successfully');
    }

    public function destroy($id)
    {
        $this->check_access();
        $sql = "SELECT * FROM driver_platform where PLF=$id";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/rhplatform')->with('error', 'This RH Platform cannot be deleted');
        }else{
            $rhplatform = rhplatform::find($id);
            $rhplatform->delete();
            return redirect('/rhplatform')->with('message', 'RH Platform Settings Deleted Successfully');
        }
    }

}
