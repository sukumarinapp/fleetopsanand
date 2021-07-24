<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\rhplatform;
use App\Formulae;
use App\TrackerSMS;
use App\tbl137;
use App\tbl136;
use App\Billbox;

class DriverController extends Controller
{
    public function index()
    {
        $time = array();
        $time['current_date'] = date("Y-m-d");
        $time['current_time'] = date("H.i");
        return view('driver.index',compact('time'));
    }

    public function drivervno()
    {
        return view('driver.drivervno');
    }

    public function drivervnovalid(Request $request)
    {
        $VNO = trim($request->get("VNO"));
        $VNO = str_replace(' ', '', $VNO);        
        $DCN = trim($request->get("DCN"));
        $sql = "SELECT a.*,b.VBM,b.DCN FROM vehicle a,driver b where a.driver_id=b.id and  a.VNO='$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        if(count($vehicle) > 0){
            $vehicle = $vehicle[0];
            $vehicle->DCN = $DCN; 
            $driver_id = $vehicle->driver_id;
            if($vehicle->VBM == "Ride Hailing"){
                $rhplatforms = rhplatform::all();
                $sql = "SELECT * FROM tbl361 where id <> 1 and id in (select PLF from driver_platform where driver_id = $driver_id)";
                $rhplatforms = DB::select(DB::raw($sql));
                return view('driver.driverrhsales', compact('rhplatforms','vehicle'));
            }else{
                return view('driver.driverrental',compact('vehicle'));
            }
        }else{
			return redirect('/drivervnoerror')->with('error', 'Vehicle not found');
        }
    }

    public function driverrental()
    {
        return view('driver.driverrental');
    }

    public function driverrhsales()
    {
        return view('driver.driverrhsales');
    }

    public function drivervnoerror()
    {
        return view('driver.drivervnoerror');
    }

    public function driverhelp($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp',compact('sales'));
    }

    public function driverhelp1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp1',compact('sales'));
    }

    public function driverhelp2($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $SDT = date('Y-m-d', strtotime("-1 days"));
        $SDT_dMY = date('d-M-Y', strtotime("-1 days"));
        $expected_sales = Formulae::expected_sales($VNO,0);
        $sales['SDT'] = $SDT;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = $expected_sales;
        return view('driver.driverhelp2',compact('sales'));
    }

    

    public function driverpay(Request $request)
    {
        $options = Billbox::listPayOptions();
        $sales = array();
        $sales['VNO'] = trim($request->get("VNO"));
        $sales['DCN'] = trim($request->get("DCN"));
        $sales['plat_id_hidden'] = trim($request->get("plat_id_hidden"));
        $sales['earning_hidden'] = trim($request->get("earning_hidden"));
        $sales['cash_hidden'] = trim($request->get("cash_hidden"));
        $sales['trips_hidden'] = trim($request->get("trips_hidden"));
        $sales['SSR'] = trim($request->get("SSR"));
        return view('driver.driverpay',compact('sales','options'));
    }

    public function driverpaysave(Request $request)
    {
        $options = trim($request->get("options"));
        echo $options;die;
        $VNO = trim($request->get("VNO"));
        $DCN = trim($request->get("DCN"));
        $SSR = trim($request->get("SSR"));
        $TPF = trim($request->get("trips_hidden"));        
        $sql = "SELECT * FROM vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        $CAN = $result[0]->CAN;
        $CML = 0;
        $CHR = 0;
        $SDT = date('Y-m-d', strtotime("-1 days"));
        $sql = "SELECT * FROM tbl136 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $CML = $result[0]->CML;
            $CHR = $result[0]->CHR;
        }
        $expected_sales = Formulae::expected_sales($VNO,$TPF);
        $RCN = trim($request->get("DCN"));
        $RHN = trim($request->get("plat_id_hidden"));
        $SPF = trim($request->get("earning_hidden"));
        $CPF = trim($request->get("cash_hidden"));
        $insert = array(
                'SDT' => $SDT,
                'CAN' => $CAN,
                'VNO' => $VNO,
                'RCN' => $RCN,
                'RHN' => $RHN,
                'SPF' => $SPF,
                'CPF' => $CPF,
                'TPF' => $TPF,
                'SSR' => $SSR,
            );
        $tbl137 = new tbl137($insert);
        $tbl137->save();

        //call billbox paynow API

        if($SSR == "Driver"){
            $sql = "SELECT sum(CPF) as paid_amount FROM tbl137 where VNO='$VNO' and SDT='$SDT'";
            $result = DB::select(DB::raw($sql));
            $paid_amount = $result[0]->paid_amount;
            return view('driver.driverpaysuccess');
            if($paid_amount >= $expected_sales){
                #turn off buzzer if active
                #unblock vehicle if blocked
            }else{
                
            }
        }else{
            $sales = array();
            $sales['VNO'] = $VNO;
            $sales['DCN'] = $DCN;
            $sales['expected_sales'] = $expected_sales;
            return view('driver.driverhelp3',compact('sales'));
        }
    }

    public function driverhelp3($VNO,$DCN)
    {
       $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        
        $SDT_dMY = date('d-M-Y', strtotime("-1 days"));
        $expected_sales = Formulae::expected_sales($VNO);
        $sales['SDT'] = $SDT;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = $expected_sales;
        return view('driver.driverhelp3',compact('sales'));
    }

    public function driverpaysuccess()
    {
        return view('driver.driverpaysuccess');
    }

    public function billbox()
    {
        return view('driver.billbox');
    }

    public function driverpayerror()
    {
        return view('driver.driverpayerror');
    }
    
    public function driverhelpprev1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelpprev1',compact('sales'));
    }

    public function driverhelpprev2($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $CML = Formulae::CML($VNO);
        $NWM = Formulae::NWM($VNO);
        $DDT = date("Y-m-d");
        if($CML <= $NWM){
            $sql = "update tbl136 set DECL=1 where DDT = '$DDT' AND VNO='$VNO'";
            DB::update($sql);
            TrackerSMS::unblock($VNO);
            return view('driver.driverhelpprev2',compact('sales'));
        }else{
            return view('driver.driverhelpprev3',compact('sales'));
        }
    }

    
    
}
