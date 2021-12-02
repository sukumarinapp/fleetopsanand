<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\parameter;
use Auth;
use App\NotificationSetup;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access(){
        if(Auth::user()->usertype != "Admin"){
            echo "Access Denied";
            die;
        }
    }

    public function index()
    {
        $this->check_access();
        $notifications = NotificationSetup::all()->sortBy("sms_id");
        return view('sms.index',compact('notifications'));
    }

    public function update(Request $request)
    {
        $this->check_access();
        $id = $request->get("id");
        $sms_id = $request->get("sms_id");
        $sms_text = $request->get("sms_text");
        for($i=0;$i<count($sms_id);$i++){
            $notification = NotificationSetup::find($id[$i]);
            $notification->sms_id = $sms_id[$i];
            $notification->sms_text = $sms_text[$i];
            $notification->save();
        }
        return redirect('/sms')->with('message', 'Notification Setup Saved Successfully');
    }
        
}

	
	
	

	