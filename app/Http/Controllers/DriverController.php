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
        #$DDT = date('Y-m-d', strtotime("-1 days"));
        #echo Formulae::CCEI($DDT,"GN7122-17");
        #die;
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
        $ROI = $request->options;
        $VNO = $request->VNO;
        $sql = "SELECT a.CAN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and a.VNO='$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        $cust_name = $vehicle[0]->DNM . " " . $vehicle[0]->DSN;
        $CAN = $vehicle[0]->CAN;
        $SDT = date('Y-m-d', strtotime("-1 days"));        
        $RCN = $request->RCN;
        $VNO = $request->VNO;
        $RCN = $request->DCN;
        $RHN = $request->plat_id_hidden;
        $SPF = $request->earning_hidden;
        $CPF = $request->cash_hidden;
        $TPF = $request->trips_hidden;
        $SSR = $request->SSR;
        $DCR = 0;
        $sql = "SELECT * from tbl135 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result)==0){
            $sql = "insert into tbl135 (DDT,CAN,VNO,CHR,CML) values ('$SDT','$CAN','$VNO','0','0')";
            DB::insert($sql);
        }
        $sql = "SELECT * from tbl136 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result)==0){
            $sql = "insert into tbl136 (DDT,CAN,VNO,DES,DECL) values ('$SDT','$CAN','$VNO','A0','0')";
            DB::insert($sql);
        }
        $sql = "SELECT * from tbl136 where DDT='$SDT' and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        $DCR = $result[0]->id;
        $requestId = uniqid();
        $sql = "insert into tbl137 (DCR,SDT,CAN,VNO,RCN,RHN,SPF,CPF,TPF,SSR,RTN) values ('$DCR','$SDT','$CAN','$VNO','$RCN','$RHN','$SPF','$CPF','$TPF','$SSR','$requestId')";
        DB::insert($sql);
        $response = Billbox::payNow($requestId,$request->cash_hidden,$request->options,$request->DCN,$cust_name);
        if($response->statusCode=="SUCCESS"){
            $sql = "insert into tbl138 (RDT,DCR,CAN,VNO,RCN,RMT,ROI,RST,SSR,RTN) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$CPF','$ROI','0','$SSR','$requestId')";
            DB::insert($sql);
            return view('driver.prompt');
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

//http://localhost:8000/billbox?status=1&transac_id=6103e95fb962e&cust_ref=8723498807290116&pay_token=5e455780-9c2b-47f2-8387-a024c577263c
    public function billbox(Request $request)
    {
        $query = $request->all();
        print_r($query);
        $RST = $query['status'];
        $RTN = $query['transac_id'];
        if($RST == 1){
            $sql = "update tbl138 set RST=1 where RTN = '$RTN'";
            DB::update($sql);
        }

        $cust_ref = $query['cust_ref'];
        $pay_token = $query['pay_token'];
        $callback_time = date("Y-m-d H:i");
        $sql = "insert into billbox (status,transac_id,cust_ref,pay_token,callback_time) values ('$RST','$RTN','$cust_ref','$pay_token','$callback_time')";
            DB::insert($sql);
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
